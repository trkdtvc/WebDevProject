
<?php
require_once __DIR__ . '/../data/roles.php';

/**
 * @OA\Get(
 *     path="/reviews/{id}",
 *     tags={"Reviews"},
 *     summary="Get review by ID",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="Review ID",
 *         @OA\Schema(type="integer", example=1)
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Review data"
 *     )
 * )
 */
Flight::route('GET /reviews/@id', function($id){
    Flight::json(Flight::reviewService()->get_by_id($id));
});

/**
 * @OA\Get(
 *     path="/reviews",
 *     tags={"Reviews"},
 *     summary="Get all reviews",
 *     @OA\Response(
 *         response=200,
 *         description="List of reviews"
 *     )
 * )
 */
Flight::route('GET /reviews', function(){
    Flight::json(Flight::reviewService()->get_all());
});

/**
 * @OA\Post(
 *     path="/reviews",
 *     tags={"Reviews"},
 *     summary="Add a new review",
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             required={"user_id", "book_id", "rating"},
 *             @OA\Property(property="user_id", type="integer", example=2),
 *             @OA\Property(property="book_id", type="integer", example=5),
 *             @OA\Property(property="rating", type="integer", example=4, minimum=1, maximum=5),
 *             @OA\Property(property="comment", type="string", example="Excellent read!")
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Review created"
 *     )
 * )
 */
Flight::route('POST /reviews', function(){
    AuthMiddleware::authorizeRole(Roles::ADMIN);
    $data = Flight::request()->data->getData();
    Flight::json(Flight::reviewService()->add($data));
});

/**
 * @OA\Put(
 *     path="/reviews/{id}",
 *     tags={"Reviews"},
 *     summary="Update a review by ID",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="Review ID",
 *         @OA\Schema(type="integer", example=1)
 *     ),
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             @OA\Property(property="user_id", type="integer", example=2),
 *             @OA\Property(property="book_id", type="integer", example=5),
 *             @OA\Property(property="rating", type="integer", example=5, minimum=1, maximum=5),
 *             @OA\Property(property="comment", type="string", example="Updated review comment")
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Review updated"
 *     )
 * )
 */
Flight::route('PUT /reviews/@id', function($id){
    AuthMiddleware::authorizeRole(Roles::ADMIN);
    $data = Flight::request()->data->getData();
    Flight::json(Flight::reviewService()->update($data, $id));
});

/**
 * @OA\Delete(
 *     path="/reviews/{id}",
 *     tags={"Reviews"},
 *     summary="Delete a review by ID",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="Review ID",
 *         @OA\Schema(type="integer", example=1)
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Review deleted"
 *     )
 * )
 */
Flight::route('DELETE /reviews/@id', function($id){
    AuthMiddleware::authorizeRole(Roles::ADMIN);
    Flight::json(Flight::reviewService()->delete($id));
});
