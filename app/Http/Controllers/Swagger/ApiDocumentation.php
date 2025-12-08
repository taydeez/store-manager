<?php

namespace App\Http\Controllers\Swagger;

/**
 * @OA\Info(
 *     title="Bookstore Api",
 *     version="1.0.0",
 *     description="API documentation for Books Sales shop",
 *     @OA\Contact(
 *         email="demioyewusi@gmail.com"
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
