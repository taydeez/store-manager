<?php

namespace App\Http\Controllers\Swagger;


/**
 * @OA\Tag(
 *     name="Auth",
 *     description="Authentication Endpoints"
 * )
 */
class Auth
{

    /**
     * @OA\Get(
     *     path="/api/users",
     *     summary="Get all users",
     *     tags={"Users"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Response(
     *         response=200,
     *         description="List of users",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(
     *                 property="data",
     *                 type="array",
     *                 @OA\Items(
     *                     @OA\Property(property="id", type="integer", example=1),
     *                     @OA\Property(property="name", type="string", example="John Doe"),
     *                     @OA\Property(property="email", type="string", example="john@example.com"),
     *                     @OA\Property(property="role", type="string", example="admin"),
     *                     @OA\Property(property="is_active", type="boolean", example=true)
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Server error",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="An error occurred")
     *         )
     *     )
     * )
     */
    public function index()
    {
    }


    /**
     * @OA\Post(
     *     path="/api/users/create",
     *     summary="Create a new user",
     *     tags={"Users"},
     *     security={{"bearerAuth": {}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name", "email", "role"},
     *             @OA\Property(property="name", type="string", example="John Doe"),
     *             @OA\Property(property="email", type="string", example="john@example.com"),
     *             @OA\Property(property="role", type="string", example="editor")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="User created successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="User created successfully")
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="Validation error"),
     *             @OA\Property(
     *                 property="errors",
     *                 type="array",
     *                 @OA\Items(type="string", example="The email field is required.")
     *             )
     *         )
     *     )
     * )
     */
    public function createUser()
    {
    }


    /**
     * @OA\Patch(
     *     path="/api/users/update",
     *     summary="Update user details",
     *     tags={"Users"},
     *     security={{"bearerAuth": {}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"id"},
     *             @OA\Property(property="id", type="integer", example=1),
     *             @OA\Property(property="name", type="string", example="Jane Doe"),
     *             @OA\Property(property="role", type="string", example="admin"),
     *             @OA\Property(property="is_active", type="boolean", example=true)
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="User updated successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="User updated successfully")
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="Validation failed")
     *         )
     *     )
     * )
     */
    public function updateUser()
    {
    }


    /**
     * @OA\Delete(
     *     path="/api/users/remove",
     *     summary="Delete a user",
     *     tags={"Users"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="query",
     *         description="User ID",
     *         required=true,
     *         @OA\Schema(type="integer", example=3)
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="User deleted successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="User deleted successfully")
     *         )
     *     )
     * )
     */
    public function removeUser()
    {
    }


    /**
     * @OA\Get(
     *     path="/api/users/me",
     *     summary="Get authenticated user details",
     *     tags={"Users"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Response(
     *         response=200,
     *         description="Authenticated user data",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(
     *                 property="data",
     *                 type="object",
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="name", type="string", example="John Doe"),
     *                 @OA\Property(property="email", type="string", example="john@example.com"),
     *                 @OA\Property(property="role", type="string", example="editor")
     *             )
     *         )
     *     )
     * )
     */
    public function getUser()
    {
    }


    /**
     * @OA\Post(
     *     path="/api/auth/login",
     *     summary="Authenticate user and get token",
     *     tags={"Authentication"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"email","password"},
     *             @OA\Property(property="email", type="string", example="john@example.com"),
     *             @OA\Property(property="password", type="string", example="password123")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Login successful",
     *         @OA\JsonContent(
     *             @OA\Property(property="access_token", type="string", example="eyJhbGciOiJIUz..."),
     *             @OA\Property(property="token_type", type="string", example="bearer"),
     *             @OA\Property(property="expires_in", type="integer", example=3600)
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Invalid credentials",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="Invalid email/password")
     *         )
     *     )
     * )
     */
    public function login()
    {
    }


    /**
     * @OA\Post(
     *     path="/api/auth/logout",
     *     summary="Logout user",
     *     tags={"Authentication"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Response(
     *         response=200,
     *         description="Logout successful",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Successfully logged out")
     *         )
     *     )
     * )
     */
    public function logout()
    {
    }


    /**
     * @OA\Post(
     *     path="/api/auth/refresh",
     *     summary="Refresh JWT token",
     *     tags={"Authentication"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Response(
     *         response=200,
     *         description="Token refreshed successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="access_token", type="string", example="eyJhbGciOiJIUz..."),
     *             @OA\Property(property="token_type", type="string", example="bearer"),
     *             @OA\Property(property="expires_in", type="integer", example=3600)
     *         )
     *     )
     * )
     */
    public function refresh()
    {
    }


    /**
     * @OA\Post(
     *     path="/api/password/send-code",
     *     summary="Send password reset verification code",
     *     tags={"Password Reset"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"email"},
     *             @OA\Property(property="email", type="string", example="user@example.com")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Verification code sent to email",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Verification code sent")
     *         )
     *     )
     * )
     */
    public function sendCode()
    {
    }


    /**
     * @OA\Post(
     *     path="/api/password/verify-code",
     *     summary="Verify reset code",
     *     tags={"Password Reset"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"email", "code"},
     *             @OA\Property(property="email", type="string", example="user@example.com"),
     *             @OA\Property(property="code", type="string", example="123456")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Code verified successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Code verified successfully.")
     *         )
     *     )
     * )
     */
    public function verifyCode()
    {
    }


    /**
     * @OA\Post(
     *     path="/api/password/reset",
     *     summary="Reset password using verification code",
     *     tags={"Password Reset"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"email", "code", "password", "password_confirmation"},
     *             @OA\Property(property="email", type="string", example="user@example.com"),
     *             @OA\Property(property="code", type="string", example="123456"),
     *             @OA\Property(property="password", type="string", example="newpassword123"),
     *             @OA\Property(property="password_confirmation", type="string", example="newpassword123")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Password reset successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Password reset successfully")
     *         )
     *     )
     * )
     */
    public function resetPassword()
    {
    }
}
