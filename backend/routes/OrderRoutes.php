
<?php

/**
 * @OA\Tag(
 *   name="Orders",
 *   description="Order management endpoints"
 * )
 */
class OrderRoutesDocs {

    /**
     * @OA\Get(
     *     path="/orders",
     *     summary="Get all orders",
     *     tags={"Orders"},
     *     @OA\Response(response=200, description="List of orders")
     * )
     */
    public function getAllOrdersDoc() {}

    /**
     * @OA\Get(
     *     path="/orders/{id}",
     *     summary="Get order by ID",
     *     tags={"Orders"},
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\Response(response=200, description="Order data")
     * )
     */
    public function getOrderByIdDoc() {}

    /**
     * @OA\Post(
     *     path="/orders",
     *     summary="Add new order",
     *     tags={"Orders"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"user_id", "total_price", "status"},
     *             @OA\Property(property="user_id", type="integer", example=5),
     *             @OA\Property(property="total_price", type="number", format="float", example=49.99),
     *             @OA\Property(property="status", type="string", example="pending")
     *         )
     *     ),
     *     @OA\Response(response=200, description="Order created")
     * )
     */
    public function addOrderDoc() {}

    /**
     * @OA\Put(
     *     path="/orders/{id}",
     *     summary="Update order by ID",
     *     tags={"Orders"},
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"user_id", "total_price", "status"},
     *             @OA\Property(property="user_id", type="integer", example=5),
     *             @OA\Property(property="total_price", type="number", format="float", example=59.99),
     *             @OA\Property(property="status", type="string", example="shipped")
     *         )
     *     ),
     *     @OA\Response(response=200, description="Order updated")
     * )
     */
    public function updateOrderDoc() {}

    /**
     * @OA\Delete(
     *     path="/orders/{id}",
     *     summary="Delete order by ID",
     *     tags={"Orders"},
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\Response(response=200, description="Order deleted")
     * )
     */
    public function deleteOrderDoc() {}
}

// --- Actual route logic ---
Flight::route('GET /orders', function() {
    Flight::json(Flight::get('order_service')->get_all());
});

Flight::route('GET /orders/@id', function($id) {
    Flight::json(Flight::get('order_service')->get_by_id($id));
});

Flight::route('POST /orders', function() {
    $data = Flight::request()->data->getData();
    Flight::json(Flight::get('order_service')->add($data));
});

Flight::route('PUT /orders/@id', function($id) {
    $data = Flight::request()->data->getData();
    Flight::get('order_service')->update($data, $id);
    Flight::json(["message" => "Order updated"]);
});

Flight::route('DELETE /orders/@id', function($id) {
    Flight::get('order_service')->delete($id);
    Flight::json(["message" => "Order deleted"]);
});
