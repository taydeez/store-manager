<?php

namespace App\Http\Controllers;

use App\Http\Resources\CustomerResource;
use App\Http\Responses\ApiResponse;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class CustomerController extends Controller
{
    //

    public function index()
    {
        $customers = Customer::filter()->get();
        return ApiResponse::success(CustomerResource::collection($customers));
    }


    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string:255',
            'phone' => 'required|string|unique:customers|confirmed',
            'location' => 'required|string',
            'email' => 'string|email|max:255|unique:customers',
        ]);

        if ($validator->fails()) {
            return ApiResponse::error('validation error', $validator->errors()->all(), 422);
        }

        try {
            Customer::create([
                'name' => $request->get('name'),
                'phone' => $request->get('phone'),
                'location' => $request->get('location'),
                'email' => $request->get('email') || null,
            ]);
            return ApiResponse::success([], 'Customer created successfully', 201);
        } catch (\Exception $e) {
            Log::error('store customer', ['exception' => $e->getMessage()]);
            return ApiResponse::error('Something went wrong');
        }
    }


    public function show($phone_number)
    {
        $customer = Customer::where('phone', $phone_number)->first();
        return ApiResponse::success(new CustomerResource($customer));
    }


    public function destroy($id)
    {
        Customer::destroy($id);
        return ApiResponse::success([], 'Customer deleted successfully');
    }


}
