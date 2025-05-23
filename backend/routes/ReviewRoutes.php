
<?php

/**
 * @OA\Tag(
 *   name="Reviews",
 *   description="Review management endpoints"
 * )
 */
class ReviewRoutesDocs {

    /**
     * @OA\Get(
     *     path="/reviews",
     *     summary="Get all reviews",
     *     tags={"Reviews"},
     *     @OA\Response(response=200, description="List of reviews")
     * )
     */
    public function getAllReviewsDoc() {}

    /**
     * @OA\Get(
     *     path="/reviews/{id}",
     *     summary="Get review by ID",
     *     tags={"Reviews"},
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\Response(response=200, description="Review data")
     * )
     */
    public function getReviewByIdDoc() {}

    /**
     * @OA\Post(
     *     path="/reviews",
     *     summary="Add new review",
     *     tags={"Reviews"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"user_id", "book_id", "rating", "comment"},
     *             @OA\Property(property="user_id", type="integer", example=2),
     *             @OA\Property(property="book_id", type="integer", example=4),
     *             @OA\Property(property="rating", type="integer", example=5),
     *             @OA\Property(property="comment", type="string", example="Excellent book!")
     *         )
     *     ),
     *     @OA\Response(response=200, description="Review created")
     * )
     */
    public function addReviewDoc() {}

    /**
     * @OA\Put(
     *     path="/reviews/{id}",
     *     summary="Update review by ID",
     *     tags={"Reviews"},
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"user_id", "book_id", "rating", "comment"},
     *             @OA\Property(property="user_id", type="integer", example=2),
     *             @OA\Property(property="book_id", type="integer", example=4),
     *             @OA\Property(property="rating", type="integer", example=4),
     *             @OA\Property(property="comment", type="string", example="Still good but not perfect")
     *         )
     *     ),
     *     @OA\Response(response=200, description="Review updated")
     * )
     */
    public function updateReviewDoc() {}

    /**
     * @OA\Delete(
     *     path="/reviews/{id}",
     *     summary="Delete review by ID",
     *     tags={"Reviews"},
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\Response(response=200, description="Review deleted")
     * )
     */
    public function deleteReviewDoc() {}
}

// --- Actual route logic ---
Flight::route('GET /reviews', function() {
    Flight::json(Flight::get('review_service')->get_all());
});

Flight::route('GET /reviews/@id', function($id) {
    Flight::json(Flight::get('review_service')->get_by_id($id));
});

Flight::route('POST /reviews', function() {
    $data = Flight::request()->data->getData();
    Flight::json(Flight::get('review_service')->add($data));
});

Flight::route('PUT /reviews/@id', function($id) {
    $data = Flight::request()->data->getData();
    Flight::get('review_service')->update($data, $id);
    Flight::json(["message" => "Review updated"]);
});

Flight::route('DELETE /reviews/@id', function($id) {
    Flight::get('review_service')->delete($id);
    Flight::json(["message" => "Review deleted"]);
});
