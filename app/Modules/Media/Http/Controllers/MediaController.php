<?php
declare(strict_types=1);

namespace App\Modules\Media\Http\Controllers;

use App\Modules\Foundation\Helpers\ApiResponse;
use App\Modules\Media\Actions\DeleteMediaAction;
use App\Modules\Media\Actions\UploadMediaAction;
use App\Modules\Media\Http\Requests\UploadMediaRequest;
use App\Modules\Media\Http\Resources\MediaResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;

class MediaController extends Controller
{
    public function store(UploadMediaRequest $request, UploadMediaAction $action): JsonResponse
    {
        $media = $action->execute(
            $request->file('file'),
            $request->validated('mediable_type'),
            $request->validated('mediable_id'),
            $request->validated('collection', 'default'),
        );

        return ApiResponse::created(new MediaResource($media));
    }

    public function destroy(string $id, DeleteMediaAction $action): JsonResponse
    {
        $action->execute($id);
        return ApiResponse::noContent();
    }
}
