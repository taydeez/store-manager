<?php

namespace App\Http\Controllers\Swagger;


/**
* @OA\Tag(
*     name="Stocks",
*     description="Stock management endpoints"
* )
*/


class Stocks{


/**
 * @OA\Post(
 *     path="/api/stock/update",
 *     tags={"Stocks"},
 *     summary="Update stock for a book",
 *     description="Adds or removes stock for a specific book and records the change in stock history.",
 *     security={{"sanctum":{}}},
 *
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             required={"book_id","add","remove","description"},
 *             @OA\Property(property="book_id", type="integer", example=1, description="ID of the book"),
 *             @OA\Property(property="add", type="integer", example=5, description="Number of items to add"),
 *             @OA\Property(property="remove", type="integer", example=0, description="Number of items to remove"),
 *             @OA\Property(property="description", type="string", example="Stock adjustment from main store", description="Reason for stock update")
 *         )
 *     ),
 *
 *     @OA\Response(
 *         response=200,
 *         description="Stock updated successfully",
 *         @OA\JsonContent(
 *             @OA\Property(property="success", type="boolean", example=true),
 *             @OA\Property(property="message", type="string", example="Stock updated successfully"),
 *             @OA\Property(property="data", type="object")
 *         )
 *     ),
 *     @OA\Response(
 *         response=422,
 *         description="Validation error",
 *         @OA\JsonContent(
 *             @OA\Property(property="success", type="boolean", example=false),
 *             @OA\Property(property="message", type="string", example="validation error"),
 *             @OA\Property(
 *                 property="errors",
 *                 type="array",
 *                 @OA\Items(type="string", example="The book_id field is required.")
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response=500,
 *         description="Server error",
 *         @OA\JsonContent(
 *             @OA\Property(property="success", type="boolean", example=false),
 *             @OA\Property(property="message", type="string", example="Could not update stock")
 *         )
 *     )
 * )
 */

public function updateStock(){}

}


