<?php

namespace App\Http\Controllers;

use App\Http\Responses\ApiResponse;
use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class StockController extends Controller
{
    //

    public function updateStock(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'book_id' => 'required|integer|exists:books,id',
            'add' => 'required|integer|min:0',
            'remove' => 'required|integer|min:0',
            'description' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return ApiResponse::error('validation error', $validator->errors()->all(), 422);
        }

        try {
            $book = Book::where('id', $request->book_id)->first();

            $book->updateStock(
                add: (int) $request->add,
                remove: (int) $request->remove,
                description: $request->description ?? 'Stock adjustment from main store',
                update_grand: true
            );

            return ApiResponse::success([], 'Stock updated successfully');

        } catch (\Exception $e) {
            Log::error('update stock error', ['exception' => $e->getMessage()]);
            return ApiResponse::error('Could not update stock', 500);
        }
    }
}
