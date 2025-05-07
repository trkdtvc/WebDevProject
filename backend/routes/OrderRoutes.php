<?php
require_once __DIR__ . '/../services/OrderService.php';

/**
 * @OA\Get(
 *     path="/order",
 *     summary="Get all order",
 *     @OA\Response(response=200, description="List of order")
 * )
 */
Flight::route('GET /order', function() {
    Flight::json(Flight::get('order_service')->get_all());
});

/**
 * @OA\Get(
 *     path="/order/{{id}}",
 *     summary="Get order by ID",
 *     @OA\Parameter(in="path", name="id", required=true, @OA\Schema(type="integer")),
 *     @OA\Response(response=200, description="Order data")
 * )
 */
Flight::route('GET /order/@id', function($id) {
    Flight::json(Flight::get('order_service')->get_by_id($id));
});

/**
 * @OA\Post(
 *     path="/order",
 *     summary="Add a new order",
 *     @OA\RequestBody(required=true, @OA\JsonContent()),
 *     @OA\Response(response=200, description="Order added")
 * )
 */
Flight::route('POST /order', function() {
    $data = Flight::request()->data->getData();
    Flight::json(Flight::get('order_service')->add($data));
});

/**
 * @OA\Put(
 *     path="/order/{{id}}",
 *     summary="Update a order",
 *     @OA\Parameter(in="path", name="id", required=true, @OA\Schema(type="integer")),
 *     @OA\RequestBody(required=true, @OA\JsonContent()),
 *     @OA\Response(response=200, description="Order updated")
 * )
 */
Flight::route('PUT /order/@id', function($id) {
    $data = Flight::request()->data->getData();
    Flight::json(Flight::get('order_service')->update($id, $data));
});

/**
 * @OA\Delete(
 *     path="/order/{{id}}",
 *     summary="Delete a order",
 *     @OA\Parameter(in="path", name="id", required=true, @OA\Schema(type="integer")),
 *     @OA\Response(response=200, description="Order deleted")
 * )
 */
Flight::route('DELETE /order/@id', function($id) {
    Flight::json(Flight::get('order_service')->delete($id));
});
