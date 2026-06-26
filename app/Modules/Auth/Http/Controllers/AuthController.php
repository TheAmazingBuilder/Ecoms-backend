<?php
declare(strict_types=1);

namespace App\Modules\Auth\Http\Controllers;

use App\Modules\Auth\Actions\LoginAction;
use App\Modules\Auth\Actions\LogoutAction;
use App\Modules\Auth\Actions\RegisterAction;
use App\Modules\Auth\DTOs\LoginDTO;
use App\Modules\Auth\DTOs\RegisterDTO;
use App\Modules\Auth\Http\Requests\LoginRequest;
use App\Modules\Auth\Http\Requests\RegisterRequest;
use App\Modules\Foundation\Helpers\ApiResponse;
use App\Modules\User\Http\Resources\UserResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class AuthController extends Controller
{
    public function login(LoginRequest $request, LoginAction $action): JsonResponse
    {
        $result = $action->execute(LoginDTO::fromRequest($request->validated()));

        return ApiResponse::success([
            'user'         => new UserResource($result['user']),
            'access_token' => $result['token'],
            'token_type'   => 'Bearer',
        ], 'Login successful');
    }

    public function register(RegisterRequest $request, RegisterAction $action): JsonResponse
    {
        $result = $action->execute(RegisterDTO::fromRequest($request->validated()));

        return ApiResponse::created([
            'user'         => new UserResource($result['user']),
            'access_token' => $result['token'],
            'token_type'   => 'Bearer',
        ], 'Registration successful');
    }

    public function logout(Request $request, LogoutAction $action): JsonResponse
    {
        $action->execute($request->user());
        return ApiResponse::success(null, 'Logged out successfully');
    }

    public function me(Request $request): JsonResponse
    {
        return ApiResponse::success(new UserResource($request->user()));
    }
}
