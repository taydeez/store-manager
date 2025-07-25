<?php

namespace App\Http\Controllers;

use App\Http\Responses\ApiResponse;
use App\Models\Books;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class BooksController extends Controller
{

        public function index(): JsonResponse
        {
            try{
                $books = Books::filter()->paginate(10);
                return ApiResponse::success($books);
            }catch(\Exception $e){
                Log::error('get all books',['exception' =>$e->getMessage()]);
                return ApiResponse::error('Something went wrong');
            }
        }


        public function show(int $id): JsonResponse
        {
            try {
                $book = Books::Where('id', $id)->first();
                return ApiResponse::success($book);
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
                    'available' => 'boolean',
                    'image_url' => 'string',
                    'tags'     => 'array'
            ]);

            if ($validator->fails())
            {
                return ApiResponse::error('validation error',$validator->errors()->all(), 422);
            }

            try{

                //$tags = explode(',', $request->input('tags')); // turns "php,laravel" into ['php', 'laravel']
                $request->merge([
                    'tags' => json_encode($request->input('tags'))
                ]);

                Books::create($request->all());
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
            'available' => 'boolean'
        ]);

        if ($validator->fails())
        {
            return ApiResponse::error('validation error',$validator->errors()->all(), 422);
        }

        try{
            $book = $books->where('id', $id)->first();
            $book->update($request->all());
            return ApiResponse::success([], 'Book updated successfully');
        }catch(\Exception $e){
            Log::error('Update Book Error', ['exception' => $e->getMessage() ]);
            return ApiResponse::error('An Error has occurred',500);
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
