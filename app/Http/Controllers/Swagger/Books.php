<?php


namespace App\Http\Controllers\Swagger;


/**
 * @OA\Tag(
 *     name="Books",
 *     description="Books Endpoints"
 * )
 */



class Books{

    /**
     * @OA\Get(
     *     path="/api/books",
     *     summary="Get a paginated list of books",
     *     tags={"Books"},
     *     @OA\Parameter(
     *         name="page",
     *         in="query",
     *         description="Page number for pagination",
     *         required=false,
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\Parameter(
     *         name="filters",
     *         in="query",
     *         description="Filtering parameters (using Abbasudo Purity)",
     *         required=false,
     *         @OA\Schema(
     *             type="object",
     *             additionalProperties=true,
     *             example={
     *                 "id": {"$eq": 1},
     *                 "available": {"$eq": true}
     *             }
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Paginated books list",
     *         @OA\JsonContent(
     *             @OA\Property(property="data", type="object",
     *                 @OA\Property(property="current_page", type="integer", example=1),
     *                 @OA\Property(property="data", type="array",
     *                     @OA\Items(
     *                         @OA\Property(property="id", type="integer", example=1),
     *                         @OA\Property(property="title", type="string", example="Book Title"),
     *                         @OA\Property(property="quantity", type="integer", example=10),
     *                         @OA\Property(property="price", type="integer", example=5000),
     *                         @OA\Property(property="tags", type="string", example="[fiction, bestseller]"),
     *                         @OA\Property(property="available", type="boolean", example=true),
     *                         @OA\Property(property="added_by", type="integer", example=1)
     *                     )
     *                 ),
     *                 @OA\Property(property="last_page", type="integer", example=3),
     *                 @OA\Property(property="per_page", type="integer", example=10),
     *                 @OA\Property(property="total", type="integer", example=30)
     *             ),
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="")
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Server error",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="Something went wrong")
     *         )
     *     )
     * )
     */


    public function index(){}


    /**
     * @OA\Get(
     *     path="/api/books/{id}",
     *     summary="Get a single book by ID",
     *     tags={"Books"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the book to retrieve",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful response",
     *         @OA\JsonContent(
     *             @OA\Property(property="data", type="object",
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="added_by", type="integer", example=1),
     *                 @OA\Property(property="title", type="string", example="second book added from my api updated"),
     *                 @OA\Property(property="quantity", type="integer", example=20),
     *                 @OA\Property(property="price", type="number", example=4000),
     *                 @OA\Property(property="tags", type="string", example="main_store,new]"),
     *                 @OA\Property(property="available", type="string", example="true"),
     *             ),
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Book not found"
     *     )
     * )
     */

    public function show(){}

    /**
     * @OA\Post(
     *     path="/api/books",
     *     summary="Create a new book",
     *     tags={"Books"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"title", "quantity", "price", "added_by"},
     *             @OA\Property(property="title", type="string", example="The Pragmatic Programmer"),
     *             @OA\Property(property="quantity", type="integer", minimum=1, example=5),
     *             @OA\Property(property="price", type="integer", minimum=1, example=2000),
     *             @OA\Property(property="added_by", type="integer", example=1),
     *             @OA\Property(property="available", type="boolean", example=true),
     *             @OA\Property(property="image_url", type="string", example="http://example.com/image.jpg"),
     *             @OA\Property(
     *                 property="tags",
     *                 type="array",
     *                 @OA\Items(type="string"),
     *                 example={"fiction", "bestseller"}
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Book created successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="data", type="array", @OA\Items(), example={}),
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Book created successfully")
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="validation error"),
     *             @OA\Property(property="data", type="array", @OA\Items(type="string"), example={"The title field is required."})
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Server error",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="An Error has occurred")
     *         )
     *     )
     * )
     */

    public function store(){}


    /**
     * @OA\Put(
     *     path="/api/books/{id}",
     *     summary="Update an existing book",
     *     tags={"Books"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="Book ID",
     *         required=true,
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="title", type="string", example="Updated Book Title"),
     *             @OA\Property(property="quantity", type="integer", minimum=1, example=10),
     *             @OA\Property(property="price", type="integer", minimum=1, example=3000),
     *             @OA\Property(property="added_by", type="integer", example=1),
     *             @OA\Property(property="available", type="boolean", example=true)
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Book updated successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="data", type="array", @OA\Items(), example={}),
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Book updated successfully")
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="validation error"),
     *             @OA\Property(property="data", type="array", @OA\Items(type="string"), example={"The quantity must be at least 1."})
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Server error",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="An Error has occurred")
     *         )
     *     )
     * )
     */


    public function update(){}


    /**
     * @OA\Delete(
     *     path="/api/books/{id}",
     *     summary="Delete a book by ID",
     *     tags={"Books"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the book to delete",
     *         required=true,
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Book deleted successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="data", type="array", @OA\Items(), example={}),
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Book deleted successfully")
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Server error",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="An Error has occurred")
     *         )
     *     )
     * )
     */


    public function destroy(){}






}
