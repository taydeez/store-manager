<?php

namespace App\Http\Controllers;

use App\Http\Resources\BookResource;
use App\Http\Resources\StoreInventoryResource;
use App\Http\Responses\ApiResponse;
use App\Models\Books;
use App\Models\StoreInventory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class StoreInventoryController extends Controller
{
    //
    //get all inventories in a store
    public function index(Request $request)
    {
        $store_id = $request->query('store_id');
        $book_id = $request->query('book_id');


        try{
            if(!is_null($store_id)){
                $inventory = StoreInventory::with('book','storefront')->where('store_front_id', $store_id)->get();
            }elseif (!is_null($book_id)) {
                $inventory = StoreInventory::with('book','storefront')->where('book_id', $book_id)->get();
            }
            return ApiResponse::success(StoreInventoryResource::collection($inventory));
        }catch(\Exception $e){
            Log::error('failed to get inventory for store with id '.$store_id,['exception' =>$e->getMessage()]);
            return ApiResponse::error($e->getMessage());
        }
    }


    public function createInventory(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'book_id'=>'required|exists:books,id',
            'store_front_id'=>'required|exists:store_fronts,id',
            'book_quantity' => 'required|integer',
        ]);

        if ($validator->fails())
        {
            return ApiResponse::error('validation error',$validator->errors()->all(), 422);
        }

        if(StoreInventory::where(['book_id' => $request->book_id, 'store_front_id' => $request->store_front_id ])->exists())
        {
            return ApiResponse::error('this book already exists in this store ', 422);
        }

        try{
            DB::transaction(function () use ($request) {
                $book = Books::where('id', $request->book_id)->firstOrfail();

                $data = $request->all();
                $data['stocked_quantity'] = $request->book_quantity;

                $inventory = StoreInventory::create($data);

                //update main store stock
                $book->updateMainStock(0, $request->book_quantity, "{$request->book_quantity} copies were added to {$inventory->storefront->store_name} ");

            });

            return ApiResponse::success([], 'Inventory added successfully');

        }catch(\Exception $e){
            Log::error('failed to save inventory record for store with id '.$request->store_front_id,['exception' =>$e->getMessage()]);
            return ApiResponse::error($e->getMessage());
        }
    }


    public function updateInventory(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'book_id'=>'required|exists:books,id',
            'store_front_id'=>'required|exists:store_fronts,id',
            'book_quantity' => 'integer',
            'book_quantity_remove' => 'integer',

        ]);

        if ($validator->fails())
        {
            return ApiResponse::error('validation error',$validator->errors()->all(), 422);
        }

        try{
            DB::transaction(function () use ($request) {

                //
                $inventoryItem = StoreInventory::where(['book_id' => $request->book_id, 'store_front_id' => $request->store_front_id ])->first();
                $book = Books::where('id', $request->book_id)->firstOrfail();

                if($request->book_quantity > 0)
                {
                    $inventoryItem->stocked_quantity += $request->book_quantity;
                    $inventoryItem->book_quantity += $request->book_quantity;

                    //update main store quantity
                    $book->updateMainStock(0, $request->book_quantity, "{$request->book_quantity} copies were added to {$inventoryItem->storefront->store_name} ");

                }else{
                    $inventoryItem->stocked_quantity -= $request->book_quantity_remove;
                    $inventoryItem->book_quantity -= $request->book_quantity_remove;

                    //after removing from store quantity we don't add it back to the main store quantity because the removal can be due to different reasons
                    // if it's needed to be added back to main store this should be done manually
                    //in a future update we can add an option which if checked the books would be added to main store
                }

                $inventoryItem->save();
            });

            return ApiResponse::success([], 'Inventory updated successfully');

        }catch(\Exception $e){
            Log::error('failed to update inventory record for store with id '.$request->store_front_id,['exception' =>$e->getMessage()]);
            return ApiResponse::error($e->getMessage());
        }
    }


}
