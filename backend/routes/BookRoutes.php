
<?php
require_once __DIR__ . '/../data/roles.php';

/**
 * @OA\Get(
 *     path="/books/{id}",
 *     tags={"Books"},
 *     summary="Get book by ID",
 *     security={{"bearerAuth":{}}},
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="Book ID",
 *         @OA\Schema(type="integer", example=1)
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Book data"
 *     )
 * )
 */
Flight::route('GET /books/@id', function($id){
    Flight::json(Flight::bookService()->get_by_id($id));
});

/**
 * @OA\Get(
 *     path="/books",
 *     tags={"Books"},
 *     summary="Get all books",
 *     security={{"bearerAuth":{}}},
 *     @OA\Response(
 *         response=200,
 *         description="List of books"
 *     )
 * )
 */
Flight::route('GET /books', function(){
    Flight::json(Flight::bookService()->get_all());
});

/**
 * @OA\Post(
 *     path="/books",
 *     tags={"Books"},
 *     summary="Add a new book",
 *     security={{"bearerAuth":{}}},
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             required={"title", "author", "price", "stock"},
 *             @OA\Property(property="title", type="string", example="The Hobbit"),
 *             @OA\Property(property="author", type="string", example="J.R.R. Tolkien"),
 *             @OA\Property(property="category_id", type="integer", example=2),
 *             @OA\Property(property="price", type="number", format="float", example=14.99),
 *             @OA\Property(property="stock", type="integer", example=12),
 *             @OA\Property(property="description", type="string", example="A fantasy adventure novel.")
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Book created"
 *     )
 * )
 */
Flight::route('POST /books', function(){
    AuthMiddleware::authorizeRole(Roles::ADMIN);
    $data = Flight::request()->data->getData();
    Flight::json(Flight::bookService()->add($data));
});

/**
 * @OA\Put(
 *     path="/books/{id}",
 *     tags={"Books"},
 *     summary="Update a book by ID",
 *     security={{"bearerAuth":{}}},
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="Book ID",
 *         @OA\Schema(type="integer", example=1)
 *     ),
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             @OA\Property(property="title", type="string", example="Updated Title"),
 *             @OA\Property(property="author", type="string", example="Updated Author"),
 *             @OA\Property(property="category_id", type="integer", example=2),
 *             @OA\Property(property="price", type="number", format="float", example=19.99),
 *             @OA\Property(property="stock", type="integer", example=8),
 *             @OA\Property(property="description", type="string", example="Updated description.")
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Book updated"
 *     )
 * )
 */
Flight::route('PUT /books/@id', function($id){
    AuthMiddleware::authorizeRole(Roles::ADMIN);
    $data = Flight::request()->data->getData();
    Flight::json(Flight::bookService()->update($data, $id));
});

/**
 * @OA\Delete(
 *     path="/books/{id}",
 *     tags={"Books"},
 *     summary="Delete a book by ID",
 *     security={{"bearerAuth":{}}},
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="Book ID",
 *         @OA\Schema(type="integer", example=1)
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Book deleted"
 *     )
 * )
 */
Flight::route('DELETE /books/@id', function($id){
    AuthMiddleware::authorizeRole(Roles::ADMIN);
    Flight::json(Flight::bookService()->delete($id));
});
