
<?php

/**
 * @OA\Tag(
 *   name="Users",
 *   description="User management endpoints"
 * )
 */
class UserRoutesDocs {

    /**
     * @OA\Get(
     *     path="/users",
     *     summary="Get all users",
     *     tags={"Users"},
     *     @OA\Response(response=200, description="List of users")
     * )
     */
    public function getAllUsersDoc() {}

    /**
     * @OA\Get(
     *     path="/users/{id}",
     *     summary="Get user by ID",
     *     tags={"Users"},
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\Response(response=200, description="User data")
     * )
     */
    public function getUserByIdDoc() {}

    /**
     * @OA\Post(
     *     path="/users",
     *     summary="Add new user",
     *     tags={"Users"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"first_name", "last_name", "email", "password", "role"},
     *             @OA\Property(property="first_name", type="string", example="John"),
     *             @OA\Property(property="last_name", type="string", example="Doe"),
     *             @OA\Property(property="email", type="string", example="john.doe@example.com"),
     *             @OA\Property(property="password", type="string", example="securepassword"),
     *             @OA\Property(property="role", type="string", example="user")
     *         )
     *     ),
     *     @OA\Response(response=200, description="User created")
     * )
     */
    public function addUserDoc() {}

    /**
     * @OA\Put(
     *     path="/users/{id}",
     *     summary="Update user by ID",
     *     tags={"Users"},
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"first_name", "last_name", "email", "password", "role"},
     *             @OA\Property(property="first_name", type="string", example="John"),
     *             @OA\Property(property="last_name", type="string", example="Doe"),
     *             @OA\Property(property="email", type="string", example="john.doe@example.com"),
     *             @OA\Property(property="password", type="string", example="updatedpassword"),
     *             @OA\Property(property="role", type="string", example="admin")
     *         )
     *     ),
     *     @OA\Response(response=200, description="User updated")
     * )
     */
    public function updateUserDoc() {}

    /**
     * @OA\Delete(
     *     path="/users/{id}",
     *     summary="Delete user by ID",
     *     tags={"Users"},
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\Response(response=200, description="User deleted")
     * )
     */
    public function deleteUserDoc() {}
}

// --- Actual route logic ---
Flight::route('GET /users', function() {
    Flight::json(Flight::get('user_service')->get_all());
});

Flight::route('GET /users/@id', function($id) {
    Flight::json(Flight::get('user_service')->get_by_id($id));
});

Flight::route('POST /users', function() {
    $data = Flight::request()->data->getData();
    Flight::json(Flight::get('user_service')->add($data));
});

Flight::route('PUT /users/@id', function($id) {
    $data = Flight::request()->data->getData();
    Flight::get('user_service')->update($data, $id);
    Flight::json(["message" => "User updated"]);
});

Flight::route('DELETE /users/@id', function($id) {
    Flight::get('user_service')->delete($id);
    Flight::json(["message" => "User deleted"]);
});
