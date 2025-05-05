<?php
require_once __DIR__ . '/../services/OrderItemService.php';

/**
 * @OA\Get(
 *     path="/orderitem",
 *     summary="Get all orderitem",
 *     @OA\Response(response=200, description="List of orderitem")
 * )
 */
Flight::route('GET /orderitem', function() {
    Flight::json(Flight::get('orderitem_service')->get_all());
});

/**
 * @OA\Get(
 *     path="/orderitem/{{id}}",
 *     summary="Get orderitem by ID",
 *     @OA\Parameter(in="path", name="id", required=true, @OA\Schema(type="integer")),
 *     @OA\Response(response=200, description="OrderItem data")
 * )
 */
Flight::route('GET /orderitem/@id', function($id) {
    Flight::json(Flight::get('orderitem_service')->get_by_id($id));
});

/**
 * @OA\Post(
 *     path="/orderitem",
 *     summary="Add a new orderitem",
 *     @OA\RequestBody(required=true, @OA\JsonContent()),
 *     @OA\Response(response=200, description="OrderItem added")
 * )
 */
Flight::route('POST /orderitem', function() {
    $data = Flight::request()->data->getData();
    Flight::json(Flight::get('orderitem_service')->add($data));
});

/**
 * @OA\Put(
 *     path="/orderitem/{{id}}",
 *     summary="Update a orderitem",
 *     @OA\Parameter(in="path", name="id", required=true, @OA\Schema(type="integer")),
 *     @OA\RequestBody(required=true, @OA\JsonContent()),
 *     @OA\Response(response=200, description="OrderItem updated")
 * )
 */
Flight::route('PUT /orderitem/@id', function($id) {
    $data = Flight::request()->data->getData();
    Flight::json(Flight::get('orderitem_service')->update($id, $data));
});

/**
 * @OA\Delete(
 *     path="/orderitem/{{id}}",
 *     summary="Delete a orderitem",
 *     @OA\Parameter(in="path", name="id", required=true, @OA\Schema(type="integer")),
 *     @OA\Response(response=200, description="OrderItem deleted")
 * )
 */
Flight::route('DELETE /orderitem/@id', function($id) {
    Flight::json(Flight::get('orderitem_service')->delete($id));
});
