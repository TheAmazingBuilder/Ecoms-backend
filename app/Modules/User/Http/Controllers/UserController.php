<?php
declare(strict_types=1);

namespace App\Modules\User\Http\Controllers;

use App\Modules\Foundation\Helpers\ApiResponse;
use App\Modules\User\Actions\CreateUserAction;
use App\Modules\User\Actions\UpdateUserAction;
use App\Modules\User\DTOs\UserDTO;
use App\Modules\User\Http\Requests\StoreUserRequest;
use App\Modules\User\Http\Requests\UpdateUserRequest;
use App\Modules\User\Http\Resources\UserResource;
use App\Modules\User\Services\UserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;

class UserController extends Controller
{
    public function __construct(private readonly UserService $userService) {}

    public function index(): JsonResponse
    {
        $users = $this->userService->list(request()->integer('per_page', 15));
        return ApiResponse::success(UserResource::collection($users));
    }

    public function store(StoreUserRequest $request, CreateUserAction $action): JsonResponse
    {
        $user = $action->execute(UserDTO::fromRequest($request->validated()));
        return ApiResponse::created(new UserResource($user));
    }

    public function show(string $id): JsonResponse
    {
        $user = $this->userService->show($id);
        return ApiResponse::success(new UserResource($user));
    }

    public function update(UpdateUserRequest $request, string $id, UpdateUserAction $action): JsonResponse
    {
        $user = $action->execute($id, UserDTO::fromRequest($request->validated()));
        return ApiResponse::success(new UserResource($user), 'User updated successfully');
    }

    public function destroy(string $id): JsonResponse
    {
        $this->userService->delete($id);
        return ApiResponse::noContent();
    }
}
