<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use App\Http\Responses\ApiResponse;

class AuthController extends Controller
{


    public function login(Request $request) : JsonResponse
    {
        try{
            $validator = Validator::make($request->all(), [
                'email' => 'required|string|email|max:255',
                'password' => 'required|string|min:6',
            ]);
            if ($validator->fails())
            {
                return ApiResponse::error('validation error',$validator->errors()->all(), 422);
            }

            $user = User::where('email', $request->email)->first();
            if ($user) {
                if (Hash::check($request->password, $user->password)) {
                    $token = $user->createToken('API TOKEN')->plainTextToken;
                    $data = ['user' => $user, 'token' => $token];
                    return ApiResponse::success($data, 'Logged in Successfully');
                } else {
                    return ApiResponse::error('invalid credentials',[],401);
                }
            } else {
                    return ApiResponse::error('invalid credentials',[],401);
            }
        }catch (\Exception $e) {
            Log::error('Login Error', ['exception' => $e->getMessage() ]);
            return ApiResponse::error('An Error has occurred');
        }
    }


}
