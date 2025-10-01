<?php

namespace App\Http\Controllers\Swagger;


/**
 * @OA\Tag(
 *     name="StoreFronts",
 *     description="Store Front management endpoints"
 * )
 */


class StoreFront
{

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



    /**
     * @OA\Get(
     *     path="/api/storefronts",
     *     operationId="getStoreFronts",
     *     tags={"StoreFronts"},
     *     summary="Get a paginated list of store fronts",
     *     description="Returns a paginated list of store fronts",
     *     security={{"sanctum":{}}},
     *     @OA\Parameter(
     *         name="page",
     *         in="query",
     *         description="Page number for pagination",
     *         required=false,
     *         @OA\Schema(
     *             type="integer",
     *             default=1
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="data", type="array",
     *                 @OA\Items(ref="#/components/schemas/StoreFrontResource")
     *             ),
     *             @OA\Property(property="links", type="object"),
     *             @OA\Property(property="meta", type="object")
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Server error",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="Could not get store fronts")
     *         )
     *     )
     * )
     */

    public function index(){}


    /**
     * @OA\Get(
     *     path="/api/storefronts/{id}",
     *     operationId="getStoreFrontById",
     *     tags={"StoreFronts"},
     *     summary="Get a single store front by ID",
     *     description="Returns a single store front resource",
     *     security={{"sanctum":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the store front",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *             example=1
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example=""),
     *             @OA\Property(property="data", ref="#/components/schemas/StoreFrontResource")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Store front not found",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="Store front not found")
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Server error",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="Could not get store front")
     *         )
     *     )
     * )
     */

    public function show(){}


    /**
     * @OA\Post(
     *     path="/api/storefronts",
     *     operationId="createStoreFront",
     *     tags={"StoreFronts"},
     *     summary="Create a new store front",
     *     description="Stores a new store front record",
     *     security={{"sanctum":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="user_id", type="integer", nullable=true, example=1),
     *             @OA\Property(property="store_name", type="string", example="Main Street Store"),
     *             @OA\Property(property="store_address", type="string", example="123 Main Street"),
     *             @OA\Property(property="store_country", type="string", example="Nigeria"),
     *             @OA\Property(property="store_city", type="string", nullable=true, example="Lagos"),
     *             @OA\Property(property="store_phone", type="string", example="+2348012345678"),
     *             @OA\Property(property="store_email", type="string", nullable=true, example="store@example.com"),
     *             @OA\Property(property="store_status", type="string", enum={"active","inactive"}, example="active")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Store front created successfully"),
     *             @OA\Property(property="data", ref="#/components/schemas/StoreFrontResource")
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=false),
     *             @OA\Property(property="errors", type="object")
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Server error",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="Could not create store front")
     *         )
     *     )
     * )
     */

    public function store(){}


    /**
     * @OA\Put(
     *     path="/api/storefronts/{id}",
     *     operationId="updateStoreFront",
     *     tags={"StoreFronts"},
     *     summary="Update a store front",
     *     description="Updates an existing store front. Only fields provided in the request will be updated.",
     *     security={{"sanctum":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the store front to update",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *             example=1
     *         )
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="store_name", type="string", example="Updated Store Name"),
     *             @OA\Property(property="store_address", type="string", example="456 New Street"),
     *             @OA\Property(property="store_country", type="string", example="Nigeria"),
     *             @OA\Property(property="store_city", type="string", nullable=true, example="Lagos"),
     *             @OA\Property(property="store_phone", type="string", example="+2348012345678"),
     *             @OA\Property(property="store_email", type="string", nullable=true, example="newstore@example.com"),
     *             @OA\Property(property="store_status", type="string", enum={"active","inactive"}, example="active")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful update",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Store front updated successfully"),
     *             @OA\Property(property="data", ref="#/components/schemas/StoreFrontResource")
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=false),
     *             @OA\Property(property="errors", type="object")
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Server error",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="Could not update store front")
     *         )
     *     )
     * )
     */

    public function update(){}


    /**
     * @OA\Delete(
     *     path="/api/storefronts/{id}",
     *     operationId="deleteStoreFront",
     *     tags={"StoreFronts"},
     *     summary="Delete a store front",
     *     description="Deletes a store front by ID",
     *     security={{"sanctum":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the store front to delete",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *             example=1
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful deletion",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="StoreFront deleted successfully"),
     *
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Store front not found",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="Store not found")
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Server error",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="Could not delete store front")
     *         )
     *     )
     * )
     */

    public function destroy(){}


}
