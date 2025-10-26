<?php

namespace App\Http\Controllers\Swagger\Schemas;

/**
 * @OA\Schema(
 *     schema="CustomerResource",
 *     title="Customer Resource",
 *     description="Customer data structure returned in API responses",
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="name", type="string", example="John Doe"),
 *     @OA\Property(property="email", type="string", format="email", example="john@example.com"),
 *     @OA\Property(property="phone", type="string", example="+1 555 123 4567"),
 *     @OA\Property(property="location", type="string", example="Ibadan"),
 *     @OA\Property(property="created_at", type="string", format="date-time", example="2025-10-21T10:30:00Z"),
 *     @OA\Property(property="updated_at", type="string", format="date-time", example="2025-10-21T10:40:00Z")
 * )
 */
class CustomerResourceSchema
{
    // This class is just a placeholder for Swagger annotations.
}
