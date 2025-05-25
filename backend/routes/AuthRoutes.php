
<?php
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

Flight::group('/auth', function () {

    /**
     * @OA\Post(
     *     path="/auth/register",
     *     summary="Register new user.",
     *     description="Add a new user to the database.",
     *     tags={"auth"},
     *     @OA\RequestBody(
     *         description="Add new user",
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 required={"password", "email"},
     *                 @OA\Property(property="name", type="string", example="Jane Doe"),
     *                 @OA\Property(property="email", type="string", example="demo@gmail.com"),
     *                 @OA\Property(property="password", type="string", example="some_password"),
     *                 @OA\Property(property="role", type="string", example="admin")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="User has been added."
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Validation or registration error."
     *     )
     * )
     */
    Flight::route('POST /register', function () {
        $data = Flight::request()->data->getData();
        $response = Flight::auth_service()->register($data);

        if (isset($response['error'])) {
            Flight::halt(400, $response['error']);
        } else {
            Flight::json($response);
        }
    });

    /**
     * @OA\Post(
     *     path="/auth/login",
     *     tags={"auth"},
     *     summary="Login to system using email and password",
     *     @OA\Response(
     *         response=200,
     *         description="User data and JWT"
     *     ),
     *     @OA\RequestBody(
     *         description="Credentials",
     *         @OA\JsonContent(
     *             required={"email", "password"},
     *             @OA\Property(property="email", type="string", example="demo@gmail.com"),
     *             @OA\Property(property="password", type="string", example="some_password")
     *         )
     *     )
     * )
     */
    Flight::route('POST /login', function () {
        $data = Flight::request()->data->getData();
        $response = Flight::auth_service()->login($data);

        if (isset($response['error'])) {
            Flight::halt(401, $response['error']);
        } else {
            Flight::json([
                'message' => 'User logged in successfully',
                'data' => $response['data']
            ]);
        }
    });
});
