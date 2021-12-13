<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Services\JWTService;
use Auth;
use Illuminate\Http\JsonResponse;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class JWTController extends Controller
{
    /**
     * @var JWTService
     */
    private $JWTService;

    /**
     * Create a new AuthController instance.
     *
     * @param JWTService $JWTService
     */
    public function __construct(JWTService $JWTService)
    {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
        $this->JWTService = $JWTService;
    }

    /**
     * Register user.
     *
     * @param Request $request
     * @param Account $account
     *
     * @return JsonResponse
     */
    public function register(Request $request, Account $account): JsonResponse
    {

        $validator   = $this->JWTService->validateAPIUser($request->all(), $account);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $user = User::create(
            [
                'name'       => $request->name,
                'email'      => $request->email,
                'password'   => Hash::make($request->password),
                'account_id' => $request->input('account_id'),
            ]
        );

        return response()->json(
            [
                'message' => sprintf('User successfully registered on account with id %d',  $request->input('account_id')),
                'user'    => $user,
            ],
            201
        );
    }

    /**
     * login user
     *
     * @param Request $request
     *
     * @return JsonResponse
     * @throws ValidationException
     */
    public function login(Request $request): JsonResponse
    {
        $validator = Validator::make(
            $request->all(),
            [
                'email'    => 'required|email',
                'password' => 'required|string|min:6',
            ]
        );

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        if (!$token = auth()->attempt($validator->validated())) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $this->respondWithToken($token);
    }

    /**
     * Logout user
     *
     * @return JsonResponse
     */
    public function logout(): JsonResponse
    {
        auth()->logout();

        return response()->json(['message' => 'User successfully logged out.']);
    }

    /**
     * Refresh token.
     *
     * @return JsonResponse
     */
    public function refresh(): JsonResponse
    {
        return $this->respondWithToken(auth()->refresh());
    }


    /**
     * Get the token array structure.
     *
     * @param string $token
     *
     * @return JsonResponse
     */
    protected function respondWithToken(string $token): JsonResponse
    {
        return response()->json(
            [
                'access_token' => $token,
                'token_type'   => 'bearer',
                'expires_in'   => auth()->factory()->getTTL() * 60,
            ]
        );
    }
}
