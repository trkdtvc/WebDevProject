
<?php
require_once __DIR__ . '/../data/roles.php';

/**
 * @OA\Get(
 *     path="/categories/{id}",
 *     tags={"Categories"},
 *     summary="Get category by ID",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="Category ID",
 *         @OA\Schema(type="integer", example=1)
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Category data"
 *     )
 * )
 */
Flight::route('GET /categories/@id', function($id){
    Flight::json(Flight::categoryService()->get_by_id($id));
});

/**
 * @OA\Get(
 *     path="/categories",
 *     tags={"Categories"},
 *     summary="Get all categories",
 *     @OA\Response(
 *         response=200,
 *         description="List of categories"
 *     )
 * )
 */
Flight::route('GET /categories', function(){
    Flight::json(Flight::categoryService()->get_all());
});

/**
 * @OA\Post(
 *     path="/categories",
 *     tags={"Categories"},
 *     summary="Add a new category",
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             required={"name"},
 *             @OA\Property(property="name", type="string", example="Science Fiction")
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Category created"
 *     )
 * )
 */
Flight::route('POST /categories', function(){
    AuthMiddleware::authorizeRole(Roles::ADMIN);
    $data = Flight::request()->data->getData();
    Flight::json(Flight::categoryService()->add($data));
});

/**
 * @OA\Put(
 *     path="/categories/{id}",
 *     tags={"Categories"},
 *     summary="Update a category by ID",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="Category ID",
 *         @OA\Schema(type="integer", example=1)
 *     ),
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             @OA\Property(property="name", type="string", example="Updated Category Name")
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Category updated"
 *     )
 * )
 */
Flight::route('PUT /categories/@id', function($id){
    AuthMiddleware::authorizeRole(Roles::ADMIN);
    $data = Flight::request()->data->getData();
    Flight::json(Flight::categoryService()->update($data, $id));
});

/**
 * @OA\Delete(
 *     path="/categories/{id}",
 *     tags={"Categories"},
 *     summary="Delete a category by ID",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="Category ID",
 *         @OA\Schema(type="integer", example=1)
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Category deleted"
 *     )
 * )
 */
Flight::route('DELETE /categories/@id', function($id){
    AuthMiddleware::authorizeRole(Roles::ADMIN);
    Flight::json(Flight::categoryService()->delete($id));
});
