<?php

namespace App\Http\Controllers;

use App\Http\Resources\userResource;
use App\Http\Responses\ApiResponse;
use App\Jobs\SendNewAccountMail;
use App\Jobs\SendPasswordResetCodeJob;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class AuthController extends Controller
{


    public function index()
    {
        //$users = User::all();
        $users = User::cachedAll();
        return ApiResponse::success(userResource::collection($users));
    }

    public function createUser(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string:255',
            'email' => 'required|email|string:255|unique:users,email',
            'role' => 'required|string|exists:roles,name',
        ]);

        if ($validator->fails()) {
            return ApiResponse::error('validation error', $validator->errors()->all(), 422);
        }

        try {
            $password = Str::random(8);

            $user = User::create([
                'name' => $request->get('name'),
                'email' => $request->get('email'),
                'password' => Hash::make($password),
            ]);

            $user->assignRole($request->get('role'));

            $mailDetails = [
                'name' => $request->get('name'),
                'email' => $request->get('email'),
                'password' => $password,
                'is_active' => true
            ];

            dispatch(new SendNewAccountMail($mailDetails));

            return ApiResponse::success(['message' => 'User created successfully'], 201);
        } catch (\Exception $e) {
            Log::error('Create user Error', ['exception' => $e->getMessage()]);
            return ApiResponse::error('An Error has occurred', 500);
        }
    }


    public function updateUser(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|exists:users,id',
            'name' => 'sometimes|string:255',
            'role' => 'sometimes|string|exists:roles,name',
            'is_active' => 'sometimes|boolean',
            'current_password' => ['required_with:password', 'string'],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
        ]);

        if ($validator->fails()) {
            return ApiResponse::error('validation error', $validator->errors()->all(), 422);
        }

        try {
            $user = User::where('id', $request->get('id'))->first();

            if (!empty($request->current_password)) {
                // Verify current password
                if (!Hash::check($request->current_password, $user->password)) {
                    return ApiResponse::error("Current password does not match", 422);
                }
                // Update password
                $user->password = Hash::make($request->current_password);

                $user->save();
            }

            if ($request->get('role')) {
                $user->syncRoles([]);
                $user->assignRole($request->get('role'));
            }

            $user->update($validator->validated());

            return ApiResponse::success(['message' => 'User updated successfully'], 201);
        } catch (\Exception $e) {
            Log::error('Update user Error', ['exception' => $e->getMessage()]);
            return ApiResponse::error('An Error has occurred', 500);
        }
    }


    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (!$token = auth('api')->attempt($credentials)) {
            return response()->json(['error' => 'Invalid email/password'], 401);
        }

        return $this->respondWithToken($token);
    }

    protected function respondWithToken($token)
    {
        $user = auth('api')->user();

        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth('api')->factory()->getTTL() * 60,
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'store_front_id' => $user->store_front_id,
                'roles' => $user->getRoleNames(),
                'permissions' => $user->getAllPermissions()->pluck('name'),
            ],
        ]);
    }

    public function removeUser(Request $request)
    {
        try {
            $user = User::where('id', $request->get('id'))->first();
            $user->delete();
            return ApiResponse::success(['message' => 'User deleted successfully'], 201);
        } catch (\Exception $e) {
            Log::error('Delete user Error', ['exception' => $e->getMessage()]);
            return ApiResponse::error('An Error has occurred', 500);
        }
    }

    public function getUser()
    {
        try {
            $id = auth('api')->user()->id;
            //$user = User::where('id', $id)->firstOrFail();
            $user = User::cachedFind($id);
            return ApiResponse::success(new userResource($user));
        } catch (\Exception $e) {
            Log::error('Get user Error', ['exception' => $e->getMessage()]);
            return ApiResponse::error('An Error has occurred', 500);
        }
    }

    public function logout()
    {
        auth('api')->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    public function refresh()
    {
        $token = auth('api')->refresh();

        return $this->respondWithToken($token);
    }

    public function sendCode(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $user = User::where('email', $request->email)->first();
        if (!$user) {
            return ApiResponse::error('we do not have this email in our records', 404);
        }

        $code = rand(100000, 999999);
        try {
            DB::table('password_reset_tokens')->updateOrInsert(
                ['email' => $request->email],
                [
                    'token' => $code,
                    'expires_at' => now()->addMinutes(10),
                    'updated_at' => now(),
                ]
            );

            // Dispatch email via job
            SendPasswordResetCodeJob::dispatch($request->email, $code);

            return ApiResponse::success([], 'verification code sent to email', 201);
        } catch (\Exception $e) {
            Log::error('SendCode Error', ['exception' => $e->getMessage()]);
            return ApiResponse::error('An error occurred ', [], 500);
        }
    }

    public function verifyCode(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'code' => 'required|string|size:6',
        ]);

        $record = DB::table('password_reset_tokens')
            ->where('email', $request->email)
            ->where('token', $request->code)
            ->first();

        if (!$record || Carbon::parse($record->expires_at)->isPast()) {
            return ApiResponse::error('invalid or expired code', [], 422);
        }

        return ApiResponse::success([], 'code verified successfully', 201);
    }

    public function resetPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'code' => 'required|string|size:6',
            'password' => 'required|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return ApiResponse::error('validation error', $validator->errors()->all(), 422);
        }


        $record = DB::table('password_reset_tokens')
            ->where('email', $request->email)
            ->where('token', $request->code)
            ->first();

        if (!$record || Carbon::parse($record->expires_at)->isPast()) {
            return response()->json(['message' => 'Invalid or expired code.'], 400);
        }

        $user = User::where('email', $request->email)->first();
        if (!$user) {
            return ApiResponse::error('we do not have this email in our records', [], 404);
        }

        $user->update(['password' => Hash::make($request->password)]);

        // Cleanup
        DB::table('password_reset_tokens')->where('email', $request->email)->delete();

        return ApiResponse::success([], 'password reset successfully', 201);
    }


}
