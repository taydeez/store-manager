<?php

namespace App\Http\Controllers;

use App\Http\Resources\StoreFrontResource;
use App\Http\Responses\ApiResponse;
use App\Models\StoreFront;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class StoreFrontController extends Controller
{
    public function index()
    {
        return StoreFrontResource::collection(StoreFront::all());
    }

    public function show($id, StoreFront $storefront)
    {
        $front = StoreFront::where('id', $id)->first();
        return ApiResponse::success(new StoreFrontResource($front));
    }

    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'user_id' => 'exists:users,id',
                'store_name' => 'required|string|max:255',
                'store_address' => 'required|string|max:255',
                'store_country' => 'required|string|max:255',
                'store_city' => 'nullable|string|max:255',
                'store_phone' => 'required|string|max:50',
                'store_email' => 'nullable|email|max:255',
            ]);

            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }

            $StoreFront = StoreFront::create($validator->validated());
            $front = new StoreFrontResource($StoreFront);

            return ApiResponse::success($front);

        } catch (\Exception $e) {
            Log::error('store front create error', ['exception' => $e->getMessage()]);
            return ApiResponse::error('Could not create store front');
        }

    }

    public function update(Request $request, int $id)
    {
        try {
            $validator = Validator::make($request->all(), [
                'store_name' => 'sometimes|string|max:255',
                'store_address' => 'sometimes|string|max:255',
                'store_country' => 'sometimes|string|max:255',
                'store_city' => 'nullable|string|max:255',
                'store_phone' => 'sometimes|string|max:50',
                'store_email' => 'nullable|email|max:255',
                'is_active' => 'sometimes|boolean',
                'user_id' => 'exists:users,id'
            ]);

            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }

            $storefront = StoreFront::find($id);
            $storefront->update($validator->validated());
            $front = new StoreFrontResource($storefront);


            return ApiResponse::success($front);

        } catch (\Exception $e) {
            Log::error('store front update error :: '.$storefront->id, ['exception' => $e->getMessage()]);
            return ApiResponse::error('Could not update store front');
        }

    }

    public function destroy(int $id)
    {
        $storefront = StoreFront::find($id);

        if (!$storefront) {
            return ApiResponse::error('Store not found', 404);
        }
        $storefront->delete();
        return ApiResponse::success([], 'StoreFront deleted successfully');

    }

}
