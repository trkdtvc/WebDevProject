<?php
require_once __DIR__ . '/../services/BookService.php';

/**
 * @OA\Get(
 *     path="/book",
 *     summary="Get all book",
 *     @OA\Response(response=200, description="List of book")
 * )
 */
Flight::route('GET /book', function() {
    Flight::json(Flight::get('book_service')->get_all());
});

/**
 * @OA\Get(
 *     path="/book/{{id}}",
 *     summary="Get book by ID",
 *     @OA\Parameter(in="path", name="id", required=true, @OA\Schema(type="integer")),
 *     @OA\Response(response=200, description="Book data")
 * )
 */
Flight::route('GET /book/@id', function($id) {
    Flight::json(Flight::get('book_service')->get_by_id($id));
});

/**
 * @OA\Post(
 *     path="/book",
 *     summary="Add a new book",
 *     @OA\RequestBody(required=true, @OA\JsonContent()),
 *     @OA\Response(response=200, description="Book added")
 * )
 */
Flight::route('POST /book', function() {
    $data = Flight::request()->data->getData();
    Flight::json(Flight::get('book_service')->add($data));
});

/**
 * @OA\Put(
 *     path="/book/{{id}}",
 *     summary="Update a book",
 *     @OA\Parameter(in="path", name="id", required=true, @OA\Schema(type="integer")),
 *     @OA\RequestBody(required=true, @OA\JsonContent()),
 *     @OA\Response(response=200, description="Book updated")
 * )
 */
Flight::route('PUT /book/@id', function($id) {
    $data = Flight::request()->data->getData();
    Flight::json(Flight::get('book_service')->update($id, $data));
});

/**
 * @OA\Delete(
 *     path="/book/{{id}}",
 *     summary="Delete a book",
 *     @OA\Parameter(in="path", name="id", required=true, @OA\Schema(type="integer")),
 *     @OA\Response(response=200, description="Book deleted")
 * )
 */
Flight::route('DELETE /book/@id', function($id) {
    Flight::json(Flight::get('book_service')->delete($id));
});
