<?php

namespace App\Http\Controllers\Swagger;

/**
 * @OA\Info(
 *     title="Your API Name",
 *     version="1.0.0",
 *     description="API documentation for your Laravel application",
 *     @OA\Contact(
 *         email="your-email@example.com"
 *     )
 * )
 *
 * @OA\Server(
 *     url=L5_SWAGGER_CONST_HOST,
 *     description="API Server"
 * )
 *
 * @OA\SecurityScheme(
 *     securityScheme="sanctum",
 *     type="http",
 *     scheme="bearer",
 *     bearerFormat="JWT"
 * )
 */
class ApiDocumentation
{
    // This class is just for documentation
}
