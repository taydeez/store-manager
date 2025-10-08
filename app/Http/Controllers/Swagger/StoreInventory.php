<?php

namespace App\Http\Controllers\Swagger;


/**
 * @OA\Tag(
 *     name="StoreInventory",
 *     description="Store Front inventory management endpoints"
 * )
 */


class StoreInventory
{
    /**
     * @OA\Get(
     *     path="/api/storeinventory",
     *     summary="Get inventory by store or book",
     *     description="Returns a list of store inventories filtered by store_id or book_id",
     *     tags={"Inventory"},
     *
     *     @OA\Parameter(
     *         name="store_id",
     *         in="query",
     *         description="Filter inventory by store ID",
     *         required=false,
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\Parameter(
     *         name="book_id",
     *         in="query",
     *         description="Filter inventory by book ID",
     *         required=false,
     *         @OA\Schema(type="integer", example=12)
     *     ),
     *
     *     @OA\Response(
     *         response=200,
     *         description="Successful response",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(
     *                 property="data",
     *                 type="array",
     *                 @OA\Items(
     *                     type="object",
     *                     @OA\Property(property="id", type="integer", example=10),
     *                     @OA\Property(property="book_id", type="integer", example=12),
     *                     @OA\Property(property="book_title", type="string", example="Laravel Deep Dive"),
     *                     @OA\Property(property="store_front_id", type="integer", example=3),
     *                     @OA\Property(property="store_front_name", type="string", example="Main Street Store"),
     *                     @OA\Property(property="book_quantity", type="integer", example=150),
     *                     @OA\Property(property="stocked_quantity", type="integer", example=50),
     *                     @OA\Property(property="book_price", type="number", format="float", example=29.99),
     *                     @OA\Property(property="is_available", type="boolean", example=true),
     *                     @OA\Property(property="admin_disabled", type="boolean", example=false),
     *                     @OA\Property(property="created_at", type="string", format="date-time", example="2025-09-28T14:30:00Z")
     *                 )
     *             )
     *         )
     *     ),
     *
     *     @OA\Response(
     *         response=400,
     *         description="Bad Request"
     *     ),
     *
     *     @OA\Response(
     *         response=500,
     *         description="Internal Server Error"
     *     )
     * )
     */

    public function index(){}


    /**
     * @OA\Post(
     *     path="/api/inventory",
     *     summary="Create a new inventory record for a store",
     *     description="Adds a book to a store's inventory. Ensures unique (book_id, store_front_id) constraint.",
     *     tags={"Inventory"},
     *
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             required={"book_id","store_front_id","book_price","book_quantity","stocked_quantity"},
     *             @OA\Property(property="book_id", type="integer", example=12, description="ID of the book"),
     *             @OA\Property(property="store_front_id", type="integer", example=3, description="ID of the store front"),
     *             @OA\Property(property="book_quantity", type="integer", example=100, description="Total quantity of books in store inventory"),
     *         )
     *     ),
     *
     *     @OA\Response(
     *         response=200,
     *         description="Inventory created successfully",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Inventory added successfully"),
     *             @OA\Property(property="data", type="object", example={})
     *         )
     *     ),
     *
     *     @OA\Response(
     *         response=422,
     *         description="Validation error or duplicate inventory",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="success", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="validation error"),
     *             @OA\Property(
     *                 property="errors",
     *                 type="array",
     *                 @OA\Items(type="string", example="The book_id field is required.")
     *             )
     *         )
     *     ),
     *
     *     @OA\Response(
     *         response=500,
     *         description="Internal Server Error",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="success", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="failed to save inventory record for store with id 3")
     *         )
     *     )
     * )
     */


    public function createInventory(){}


}
