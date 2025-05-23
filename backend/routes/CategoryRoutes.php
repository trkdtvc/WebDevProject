
<?php

/**
 * @OA\Tag(
 *   name="Categories",
 *   description="Category management endpoints"
 * )
 */
class CategoryRoutesDocs {

    /**
     * @OA\Get(
     *     path="/categories",
     *     summary="Get all categories",
     *     tags={"Categories"},
     *     @OA\Response(response=200, description="List of categories")
     * )
     */
    public function getAllCategoriesDoc() {}

    /**
     * @OA\Get(
     *     path="/categories/{id}",
     *     summary="Get category by ID",
     *     tags={"Categories"},
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\Response(response=200, description="Category data")
     * )
     */
    public function getCategoryByIdDoc() {}

    /**
     * @OA\Post(
     *     path="/categories",
     *     summary="Add new category",
     *     tags={"Categories"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name"},
     *             @OA\Property(property="name", type="string", example="Fiction")
     *         )
     *     ),
     *     @OA\Response(response=200, description="Category created")
     * )
     */
    public function addCategoryDoc() {}

    /**
     * @OA\Put(
     *     path="/categories/{id}",
     *     summary="Update category by ID",
     *     tags={"Categories"},
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name"},
     *             @OA\Property(property="name", type="string", example="Updated Category")
     *         )
     *     ),
     *     @OA\Response(response=200, description="Category updated")
     * )
     */
    public function updateCategoryDoc() {}

    /**
     * @OA\Delete(
     *     path="/categories/{id}",
     *     summary="Delete category by ID",
     *     tags={"Categories"},
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\Response(response=200, description="Category deleted")
     * )
     */
    public function deleteCategoryDoc() {}
}

// --- Actual route logic ---
Flight::route('GET /categories', function() {
    Flight::json(Flight::get('category_service')->get_all());
});

Flight::route('GET /categories/@id', function($id) {
    Flight::json(Flight::get('category_service')->get_by_id($id));
});

Flight::route('POST /categories', function() {
    $data = Flight::request()->data->getData();
    Flight::json(Flight::get('category_service')->add($data));
});

Flight::route('PUT /categories/@id', function($id) {
    $data = Flight::request()->data->getData();
    Flight::get('category_service')->update($data, $id);
    Flight::json(["message" => "Category updated"]);
});

Flight::route('DELETE /categories/@id', function($id) {
    Flight::get('category_service')->delete($id);
    Flight::json(["message" => "Category deleted"]);
});
