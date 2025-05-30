
<?php
require_once __DIR__ . '/../data/roles.php';

/**
 * @OA\Tag(
 *     name="Orders",
 *     description="Order management endpoints"
 * )
 */

/**
 * @OA\Get(
 *     path="/orders/{id}",
 *     summary="Get order by ID",
 *     tags={"Orders"},
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Order data"
 *     )
 * )
 */
Flight::route('GET /orders/@id', function($id){
    Flight::json(Flight::orderService()->get_by_id($id));
});

/**
 * @OA\Get(
 *     path="/orders",
 *     summary="Get all orders",
 *     tags={"Orders"},
 *     @OA\Response(
 *         response=200,
 *         description="List of orders"
 *     )
 * )
 */
Flight::route('GET /orders', function(){
    Flight::json(Flight::orderService()->get_all());
});

/**
 * @OA\Post(
 *     path="/orders",
 *     summary="Create a new order",
 *     tags={"Orders"},
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             required={"user_id", "status", "total_price"},
 *             @OA\Property(property="user_id", type="integer", example=14),
 *             @OA\Property(property="status", type="string", example="pending"),
 *             @OA\Property(property="total_price", type="number", format="float", example=19.99)
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Order created"
 *     )
 * )
 */
Flight::route('POST /orders', function(){
    AuthMiddleware::authorizeRole(Roles::ADMIN);
    $data = Flight::request()->data->getData();
    Flight::json(Flight::orderService()->add($data));
});

/**
 * @OA\Put(
 *     path="/orders/{id}",
 *     summary="Update an order by ID",
 *     tags={"Orders"},
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             @OA\Property(property="user_id", type="integer", example=14),
 *             @OA\Property(property="status", type="string", example="shipped"),
 *             @OA\Property(property="total_price", type="number", format="float", example=25.50)
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Order updated"
 *     )
 * )
 */
Flight::route('PUT /orders/@id', function($id){
    AuthMiddleware::authorizeRole(Roles::ADMIN);
    $data = Flight::request()->data->getData();
    Flight::json(Flight::orderService()->update($data, $id));
});

/**
 * @OA\Delete(
 *     path="/orders/{id}",
 *     summary="Delete an order by ID",
 *     tags={"Orders"},
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Order deleted"
 *     )
 * )
 */
Flight::route('DELETE /orders/@id', function($id){
    AuthMiddleware::authorizeRole(Roles::ADMIN);
    Flight::json(Flight::orderService()->delete($id));
});
