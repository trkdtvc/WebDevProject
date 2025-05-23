
<?php

/**
 * @OA\Tag(
 *   name="Books",
 *   description="Book management endpoints"
 * )
 */
class BookRoutesDocs {

    /**
     * @OA\Get(
     *     path="/books",
     *     summary="Get all books",
     *     tags={"Books"},
     *     @OA\Response(response=200, description="List of books")
     * )
     */
    public function getBooksDoc() {}

    /**
     * @OA\Get(
     *     path="/books/{id}",
     *     summary="Get book by ID",
     *     tags={"Books"},
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\Response(response=200, description="Book data")
     * )
     */
    public function getBookByIdDoc() {}

    /**
     * @OA\Post(
     *     path="/books",
     *     summary="Add new book",
     *     tags={"Books"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"title", "author", "category_id"},
     *             @OA\Property(property="title", type="string", example="The Alchemist"),
     *             @OA\Property(property="author", type="string", example="Paulo Coelho"),
     *             @OA\Property(property="category_id", type="integer", example=1)
     *         )
     *     ),
     *     @OA\Response(response=200, description="Book created")
     * )
     */
    public function addBookDoc() {}

    /**
     * @OA\Put(
     *     path="/books/{id}",
     *     summary="Update book by ID",
     *     tags={"Books"},
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"title", "author", "category_id"},
     *             @OA\Property(property="title", type="string", example="Updated Title"),
     *             @OA\Property(property="author", type="string", example="Updated Author"),
     *             @OA\Property(property="category_id", type="integer", example=2)
     *         )
     *     ),
     *     @OA\Response(response=200, description="Book updated")
     * )
     */
    public function updateBookDoc() {}

    /**
     * @OA\Delete(
     *     path="/books/{id}",
     *     summary="Delete book by ID",
     *     tags={"Books"},
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\Response(response=200, description="Book deleted")
     * )
     */
    public function deleteBookDoc() {}
}

// Actual route logic
Flight::route('GET /books', function () {
    Flight::json(Flight::get('book_service')->get_all());
});

Flight::route('GET /books/@id', function($id) {
    Flight::json(Flight::get('book_service')->get_by_id($id));
});

Flight::route('POST /books', function() {
    $data = Flight::request()->data->getData();
    Flight::json(Flight::get('book_service')->add($data));
});

Flight::route('PUT /books/@id', function($id) {
    $data = Flight::request()->data->getData();
    Flight::get('book_service')->update($data, $id);
    Flight::json(["message" => "Book updated"]);
});

Flight::route('DELETE /books/@id', function($id) {
    Flight::get('book_service')->delete($id);
    Flight::json(["message" => "Book deleted"]);
});
