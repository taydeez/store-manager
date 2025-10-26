<?php

namespace App\Http\Controllers\Swagger\Schemas;

/**
 * @OA\Schema(
 *     schema="OrderResource",
 *     title="Order Resource",
 *     description="Order data structure returned in API responses",
 *
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="order_number", type="string", example="ORD-20251021-001"),
 *     @OA\Property(property="customer_id", type="integer", example=23),
 *     @OA\Property(property="customer_name", type="string", example="John Doe"),
 *     @OA\Property(property="status", type="string", example="completed"),
 *     @OA\Property(property="total_amount", type="number", format="float", example=15000.50),
 *     @OA\Property(property="payment_method", type="string", example="card"),
 *     @OA\Property(property="payment_status", type="string", example="paid"),
 *     @OA\Property(property="notes", type="string", nullable=true, example="Deliver before 5 PM"),
 *
 *
 *     @OA\Property(property="created_at", type="string", format="date-time", example="2025-10-21T14:45:00Z"),
 *     @OA\Property(property="updated_at", type="string", format="date-time", example="2025-10-21T15:10:00Z")
 * )
 */
class OrderResourceSchema
{

}
