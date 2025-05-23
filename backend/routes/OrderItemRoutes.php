
<?php

/**
 * @OA\Tag(
 *   name="OrderItems",
 *   description="Order item management endpoints"
 * )
 */
class OrderItemRoutesDocs {

    /**
     * @OA\Get(
     *     path="/order_items",
     *     summary="Get all order items",
     *     tags={"OrderItems"},
     *     @OA\Response(response=200, description="List of order items")
     * )
     */
    public function getAllOrderItemsDoc() {}

    /**
     * @OA\Get(
     *     path="/order_items/{id}",
     *     summary="Get order item by ID",
     *     tags={"OrderItems"},
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\Response(response=200, description="Order item data")
     * )
     */
    public function getOrderItemByIdDoc() {}

    /**
     * @OA\Post(
     *     path="/order_items",
     *     summary="Add new order item",
     *     tags={"OrderItems"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"order_id", "book_id", "quantity"},
     *             @OA\Property(property="order_id", type="integer", example=1),
     *             @OA\Property(property="book_id", type="integer", example=3),
     *             @OA\Property(property="quantity", type="integer", example=2)
     *         )
     *     ),
     *     @OA\Response(response=200, description="Order item created")
     * )
     */
    public function addOrderItemDoc() {}

    /**
     * @OA\Put(
     *     path="/order_items/{id}",
     *     summary="Update order item by ID",
     *     tags={"OrderItems"},
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"order_id", "book_id", "quantity"},
     *             @OA\Property(property="order_id", type="integer", example=1),
     *             @OA\Property(property="book_id", type="integer", example=3),
     *             @OA\Property(property="quantity", type="integer", example=4)
     *         )
     *     ),
     *     @OA\Response(response=200, description="Order item updated")
     * )
     */
    public function updateOrderItemDoc() {}

    /**
     * @OA\Delete(
     *     path="/order_items/{id}",
     *     summary="Delete order item by ID",
     *     tags={"OrderItems"},
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\Response(response=200, description="Order item deleted")
     * )
     */
    public function deleteOrderItemDoc() {}
}

// --- Actual route logic ---
Flight::route('GET /order_items', function() {
    Flight::json(Flight::get('order_item_service')->get_all());
});

Flight::route('GET /order_items/@id', function($id) {
    Flight::json(Flight::get('order_item_service')->get_by_id($id));
});

Flight::route('POST /order_items', function() {
    $data = Flight::request()->data->getData();
    Flight::json(Flight::get('order_item_service')->add($data));
});

Flight::route('PUT /order_items/@id', function($id) {
    $data = Flight::request()->data->getData();
    Flight::get('order_item_service')->update($data, $id);
    Flight::json(["message" => "Order item updated"]);
});

Flight::route('DELETE /order_items/@id', function($id) {
    Flight::get('order_item_service')->delete($id);
    Flight::json(["message" => "Order item deleted"]);
});
