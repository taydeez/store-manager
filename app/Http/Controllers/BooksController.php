<?php

namespace App\Http\Controllers;

use App\Http\Resources\BookResource;
use App\Http\Resources\StoreFrontResource;
use App\Http\Responses\ApiResponse;
use App\Models\Books;
use App\Models\Stocks;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class BooksController extends Controller
{

        public function index(): JsonResponse
        {
            try{
                $books = Books::filter()->get();
                return ApiResponse::success(BookResource::collection($books));
            }catch(\Exception $e){
                Log::error('get all books',['exception' =>$e->getMessage()]);
                return ApiResponse::error('Something went wrong');
            }
        }


        public function show(int $id): JsonResponse
        {
            try {
                $book = Books::with('latestStock')->where('id', $id)->first();
                return ApiResponse::success(new BookResource($book));
            }catch (\Exception $e) {
                Log::error('Get single book error', ['exception' => $e->getMessage()]);
                return ApiResponse::error('An Error has occurred', 500);
            }
        }



        public function store(Request $request)
        {
            $validator = Validator::make($request->all(),[
                    'title'=>'required|string:255',
                    'quantity'=>'required|integer|min:1',
                    'price'=>'required|integer|min:1',
                    'added_by' => 'required|integer',
                    'available' => 'string',
                    'image_url' => 'string',
                    'tags'     => 'array',
                    'image' => 'image|mimes:jpg,jpeg,png|max:2048',
            ]);

            if ($validator->fails())
            {
                return ApiResponse::error('validation error',$validator->errors()->all(), 422);
            }

            try{

                $path = null;

                if($request->hasFile('image'))
                {
                    $path = $request->file('image')->store('photos', 'public');
                }
                // store the file in /storage/app/public/photos

                $request->merge([
                    'tags' => $request->input('tags'),
                    'image_url' => $path
                ]);

                DB::transaction(function () use ($request) {
                      $book =  Books::create($request->all());

                      Stocks::create([
                            'book_id'       => $book->id,
                            'user_id'       => $request->user()->id,
                            'main_store_quantity'      => $request->input('quantity'),
                            'grand_quantity'      => $request->input('quantity'),
                            'added'         => $request->input('quantity'),
                            'removed'       => 0,
                            'description'   => 'book added'
                      ]);
                });

                return ApiResponse::success([], 'Book created successfully');
            }catch(\Exception $e){
                Log::error('Create Book Error', ['exception' => $e->getMessage() ]);
                return ApiResponse::error('An Error has occurred',500);
            }
        }


    public function update($id, Request $request, Books $books)
    {
        $validator = Validator::make($request->all(),[
            'title'=>'string:255',
            'quantity'=>'integer|min:1',
            'price'=>'integer|min:1',
            'added_by' => 'integer',
        ]);

        if ($validator->fails())
        {
            return ApiResponse::error('validation error',$validator->errors()->all(), 422);
        }

        try{

            $path = null;

            //TODO remove old image

            if($request->hasFile('image'))
            {
                $path = $request->file('image')->store('photos', 'public');
            }

            $request->merge([
                'tags' => $request->input('tags'),
                'image_url' => $path
            ]);



            $book = $books->where('id', $id)->first();
            $book->update($request->all());
            return ApiResponse::success([], 'Book updated successfully');
        }catch(\Exception $e){
            Log::error('Update Book Error', ['exception' => $e->getMessage() ]);
            return ApiResponse::error('An Error has occurred',500);
        }
    }


    public function shelf($book_id)
    {
        try{
            $book = Books::where('id', $book_id)->firstOrFail();

            $status = $book->available ? 'unshelved' : 'shelved';
            $book->available = !$book->available;
            $book->save();
            return ApiResponse::success([], "Book is $status successfully");
        }catch(\Exception $e){
            Log::error('Book shelve status unchanged', ['exception' => $e->getMessage() ]);
            return ApiResponse::error('Book shelf was not changed',500);
        }
    }




    public function destroy(int $id): JsonResponse
    {
        try {
            $book = Books::Where('id', $id)->first();
            $book->delete();
            return ApiResponse::success([], 'Book deleted successfully');
        }catch (\Exception $e) {
            Log::error('delete single book error', ['exception' => $e->getMessage()]);
            return ApiResponse::error('An Error has occurred', 500);
        }
    }





}
