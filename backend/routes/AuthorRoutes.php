<?php
require_once __DIR__ . '/../services/AuthorService.php';

/**
 * @OA\Get(
 *     path="/author",
 *     summary="Get all author",
 *     @OA\Response(response=200, description="List of author")
 * )
 */
Flight::route('GET /author', function() {
    Flight::json(Flight::get('author_service')->get_all());
});

/**
 * @OA\Get(
 *     path="/author/{{id}}",
 *     summary="Get author by ID",
 *     @OA\Parameter(in="path", name="id", required=true, @OA\Schema(type="integer")),
 *     @OA\Response(response=200, description="Author data")
 * )
 */
Flight::route('GET /author/@id', function($id) {
    Flight::json(Flight::get('author_service')->get_by_id($id));
});

/**
 * @OA\Post(
 *     path="/author",
 *     summary="Add a new author",
 *     @OA\RequestBody(required=true, @OA\JsonContent()),
 *     @OA\Response(response=200, description="Author added")
 * )
 */
Flight::route('POST /author', function() {
    $data = Flight::request()->data->getData();
    Flight::json(Flight::get('author_service')->add($data));
});

/**
 * @OA\Put(
 *     path="/author/{{id}}",
 *     summary="Update a author",
 *     @OA\Parameter(in="path", name="id", required=true, @OA\Schema(type="integer")),
 *     @OA\RequestBody(required=true, @OA\JsonContent()),
 *     @OA\Response(response=200, description="Author updated")
 * )
 */
Flight::route('PUT /author/@id', function($id) {
    $data = Flight::request()->data->getData();
    Flight::json(Flight::get('author_service')->update($id, $data));
});

/**
 * @OA\Delete(
 *     path="/author/{{id}}",
 *     summary="Delete a author",
 *     @OA\Parameter(in="path", name="id", required=true, @OA\Schema(type="integer")),
 *     @OA\Response(response=200, description="Author deleted")
 * )
 */
Flight::route('DELETE /author/@id', function($id) {
    Flight::json(Flight::get('author_service')->delete($id));
});
