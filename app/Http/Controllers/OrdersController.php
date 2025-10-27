<?php

namespace App\Http\Controllers;

use App\Http\Resources\OrderResource;
use App\Http\Responses\ApiResponse;
use App\Jobs\SendOrderCompleteMailJob;
use App\Models\{Book, Order, OrderItem, StoreInventory};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class OrdersController extends Controller
{

    public function index()
    {
        $orders = Order::filter()->get();
        return ApiResponse::success(OrderResource::collection($orders));
    }

    public function createOrder(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'customer_id' => 'required|integer|exists:customers,id',
            'store_front_id' => 'required|integer|exists:store_fronts,id',
            'books' => 'required|array',
            'books.*.book_id' => 'required|exists:books,id',
            'books.*.quantity' => 'required|integer|min:1',
        ]);

        if ($validator->fails()) {
            return ApiResponse::error('validation error', $validator->errors()->all(), 422);
        }

        try {

            DB::transaction(function () use ($request) {

                $orderNumber = 'ORD-'.time();

                $order = Order::create([
                    'order_number' => $orderNumber,
                    'store_front_id' => $request->input('store_front_id'),
                    'customer_id' => $request->input('customer_id'),
                    'status' => 'completed',
                    'sold_by_id' => auth::user()->id,
                ]);

                $totalAmount = 0;
                foreach ($request->input('books') as $index => $book) {

                    $bookItem = Book::where('id', $book['book_id'])->first();

                    OrderItem::create([
                        'order_id' => $order->id,
                        'book_id' => $book['book_id'],
                        'quantity' => $book['quantity'],
                        'order_number' => $orderNumber,
                        'store_front_id' => $request->input('store_front_id'),
                        'unit_price' => $bookItem->price,
                        'sub_total' => $bookItem->price * $book['quantity'],
                    ]);

                    //deplete inventory stock

                    StoreInventory::where([
                        'book_id' => $book['book_id'], 'store_front_id' => $request->input('store_front_id')
                    ])->decrement('book_quantity', $book['quantity']);

                    //update main store stock
                    $bookItem->updateMainStock(0, $book['quantity'],
                        "{$book['quantity']} copies were sold ", true);

                    $totalAmount += $bookItem->price * $book['quantity'];
                }

                $order->update([
                    'total_amount' => $totalAmount,
                ]);

                SendOrderCompleteMailJob::dispatch($order);
            });


            return ApiResponse::success([], 'Order Completed Successfully', 200);

        } catch (\Exception $exception) {
            Log::error('An error occurred ', ['Exception' => $exception->getMessage()]);
            return ApiResponse::error($exception->getMessage());
        }
    }


    public function cancelOrder(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'order_id' => 'required|integer|exists:orders,id',
        ]);

        if ($validator->fails()) {
            return ApiResponse::error('validation error', $validator->errors()->all(), 422);
        }

        try {
            DB::transaction(function () use ($request) {

                $order = Order::where('id', $request->input('order_id'))->update(['status' => 'cancelled']);;

                OrderItem::where('order_id', $request->input('order_id'))->update(['status' => 'cancelled']);

                $orderItems = OrderItem::where('order_id', $request->input('order_id'))->get();
                foreach ($orderItems as $orderItem) {
                    StoreInventory::where([
                        'book_id' => $orderItem->book_id, 'store_front_id' => $orderItem->store_front_id
                    ])->increment('book_quantity', $orderItem->quantity);

                    $book = Book::where('id', $orderItem->book_id)->first();

                    $book->updateMainStock($orderItem->quantity, 0,
                        "{$orderItem->quantity} restocked from cancelled order ", true);
                }
            });

            return ApiResponse::success([], 'Order Cancelled Successfully', 200);

        } catch (\Exception $exception) {
            Log::error('cancel order error ', ['Exception' => $exception->getMessage()]);
            return ApiResponse::error('cannot cancel order', [], 500);
        }
    }

}
