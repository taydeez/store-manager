<?php

namespace App\Http\Controllers;

use App\Http\Resources\BookResource;
use App\Http\Responses\ApiResponse;
use App\Models\Book;
use App\Models\Stock;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use League\Flysystem\FilesystemException;

class BooksController extends Controller
{

    public function index(): JsonResponse
    {
        $books = Book::filter()->OrderBy('created_at', 'desc')->get();
        return ApiResponse::success(BookResource::collection($books));
    }


    public function show(int $id): JsonResponse
    {
        //$book = Book::with('latestStock')->where('id', $id)->first();

        $book = Cache::remember('book_' . $id, 600, fn() => Book::with('latestStock')->where('id', $id)->first());

        return ApiResponse::success(new BookResource($book));
    }

    public function update($id, Request $request, Book $books)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'string:255',
            'quantity' => 'integer|min:1',
            'price' => 'integer|min:1',
            'added_by' => 'integer',
        ]);

        if ($validator->fails()) {
            return ApiResponse::error('validation error', $validator->errors()->all(), 422);
        }

        try {
            $book = $books->where('id', $id)->first();

            $url = null;

            if ($request->hasFile('image')) {
                $old_path = $this->extractStoragePath($book->image_url);
                Storage::delete($old_path);

                $path = $request->file('image')->store('photos');
                $url = Storage::url($path);
            }

            $request->merge([
                'tags' => $request->input('tags'),
                'image_url' => $url
            ]);


            $book = $books->where('id', $id)->first();
            $book->update($request->all());
            return ApiResponse::success([], 'Book updated successfully');
        } catch (\Exception $e) {
            Log::error('Update Book Error', ['exception' => $e->getMessage()]);
            return ApiResponse::error('An Error has occurred', 500);
        }
    }

    private function extractStoragePath(string $url): string
    {
        $parsed = parse_url($url);

        // For GCS: https://storage.googleapis.com/bucket/photos/file.jpg
        if (str_contains($parsed['host'], 'storage.googleapis.com')) {
            return ltrim(
                str_replace(
                    '/' . env('GCP_BUCKET'),
                    '',
                    $parsed['path']
                ),
                '/'
            );
        }

        // For local storage: http://localhost:8000/storage/photos/file.jpg
        if (str_contains($parsed['host'], parse_url(config('app.url'))['host'])) {
            return ltrim(str_replace('/storage', '', $parsed['path']), '/');
        }

        throw new \Exception("Unsupported URL format: {$url}");
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string:255:unique:books',
            'quantity' => 'required|integer|min:1',
            'price' => 'required|integer|min:1',
            'added_by' => 'required|integer',
            'available' => 'string',
            'image_url' => 'string',
            'tags' => 'array',
            'image' => 'image|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($validator->fails()) {
            return ApiResponse::error('validation error', $validator->errors()->all(), 422);
        }

        try {
            $path = null;
            $url = null;

            if ($request->hasFile('image')) {
                try {
//                    $image = $request->file('image');
//                    $filename = time() . '_' . $image->getClientOriginalName();

//                    $path = Storage::disk()->putFileAs(
//                        'bookstore-images', // folder in bucket
//                        $request->file('image'),
//                        $filename
//                    );
                    $path = $request->file('image')->store();


                    // Get public URL
                    //$url = "https://storage.googleapis.com/" . env('GCP_BUCKET') . "/" . $path;
                    $url = Storage::url($path);
                } catch (\Exception $e) {
                    Log::error('upload error', ['exception' => $e->getMessage()]);
                    return ApiResponse::error('An Error has occurred', $e->getMessage(), 500);
                }
            }
            $request->merge([
                'tags' => $request->input('tags'),
                'image_url' => $url
            ]);

            DB::transaction(function () use ($request) {
                $book = Book::create($request->all());

                Stock::create([
                    'book_id' => $book->id,
                    'user_id' => $request->user()->id,
                    'main_store_quantity' => $request->input('quantity'),
                    'grand_quantity' => $request->input('quantity'),
                    'added' => $request->input('quantity'),
                    'removed' => 0,
                    'description' => 'book added'
                ]);
            });

            return ApiResponse::success([], 'Book created successfully');
        } catch (FilesystemException $e) {
            Log::error(' filesystem error:', ['error' => $e->getMessage()]);

            return response()->json([
                'success' => false,
                'error' => 'Filesystem error: ' . $e->getMessage()
            ], 500);
        } catch (\Exception $e) {
            Log::error('Create Book Error', ['exception' => $e->getMessage()]);
            return ApiResponse::error('An Error has occurred', $e->getMessage(), 500);
        }
    }

    public function shelf($book_id)
    {
        $book = Book::where('id', $book_id)->firstOrFail();
        $status = $book->available ? 'unshelved' : 'shelved';
        $book->available = !$book->available;
        $book->save();
        return ApiResponse::success([], "Book is $status successfully");
    }

    public function destroy(int $id): JsonResponse
    {
        $book = Book::Where('id', $id)->first();
        $book->delete();
        return ApiResponse::success([], 'Book deleted successfully');
    }


}
