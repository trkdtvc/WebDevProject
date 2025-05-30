
<?php
require_once __DIR__ . '/../data/roles.php';

/**
 * @OA\Get(
 *     path="/order-items/{id}",
 *     tags={"Order Items"},
 *     summary="Get order item by ID",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="Order item ID",
 *         @OA\Schema(type="integer", example=1)
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Order item data"
 *     )
 * )
 */
Flight::route('GET /order-items/@id', function($id){
    Flight::json(Flight::orderItemService()->get_by_id($id));
});

/**
 * @OA\Get(
 *     path="/order-items",
 *     tags={"Order Items"},
 *     summary="Get all order items",
 *     @OA\Response(
 *         response=200,
 *         description="List of order items"
 *     )
 * )
 */
Flight::route('GET /order-items', function(){
    Flight::json(Flight::orderItemService()->get_all());
});

/**
 * @OA\Post(
 *     path="/order-items",
 *     tags={"Order Items"},
 *     summary="Create a new order item",
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             required={"order_id", "book_id", "quantity", "price"},
 *             @OA\Property(property="order_id", type="integer", example=2),
 *             @OA\Property(property="book_id", type="integer", example=5),
 *             @OA\Property(property="quantity", type="integer", example=3),
 *             @OA\Property(property="price", type="number", format="float", example=29.99)
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Order item created"
 *     )
 * )
 */
Flight::route('POST /order-items', function(){
    AuthMiddleware::authorizeRole(Roles::ADMIN);
    $data = Flight::request()->data->getData();
    Flight::json(Flight::orderItemService()->add($data));
});

/**
 * @OA\Put(
 *     path="/order-items/{id}",
 *     tags={"Order Items"},
 *     summary="Update an order item by ID",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="Order item ID",
 *         @OA\Schema(type="integer", example=1)
 *     ),
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             @OA\Property(property="order_id", type="integer", example=2),
 *             @OA\Property(property="book_id", type="integer", example=5),
 *             @OA\Property(property="quantity", type="integer", example=4),
 *             @OA\Property(property="price", type="number", format="float", example=25.00)
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Order item updated"
 *     )
 * )
 */
Flight::route('PUT /order-items/@id', function($id){
    AuthMiddleware::authorizeRole(Roles::ADMIN);
    $data = Flight::request()->data->getData();
    Flight::json(Flight::orderItemService()->update($data, $id));
});

/**
 * @OA\Delete(
 *     path="/order-items/{id}",
 *     tags={"Order Items"},
 *     summary="Delete an order item by ID",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="Order item ID",
 *         @OA\Schema(type="integer", example=1)
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Order item deleted"
 *     )
 * )
 */
Flight::route('DELETE /order-items/@id', function($id){
    AuthMiddleware::authorizeRole(Roles::ADMIN);
    Flight::json(Flight::orderItemService()->delete($id));
});
