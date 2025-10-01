<?php

namespace App\Http\Controllers\Swagger\Schemas;

/**
* @OA\Schema(
*     schema="StoreFrontResource",
*     type="object",
*     @OA\Property(property="id", type="integer"),
*     @OA\Property(property="store_name", type="string"),
*     @OA\Property(property="store_address", type="string"),
*     @OA\Property(property="store_country", type="string"),
*     @OA\Property(property="store_city", type="string"),
*     @OA\Property(property="store_phone", type="string"),
*     @OA\Property(property="store_email", type="string"),
*     @OA\Property(property="store_status", type="string", enum={"active","inactive"}),
*     @OA\Property(property="created_at", type="string", format="date-time"),
*     @OA\Property(property="updated_at", type="string", format="date-time")
* )
*/

class StoreFrontResourceSchema
{
    // This class is just a placeholder for Swagger annotations.
}
