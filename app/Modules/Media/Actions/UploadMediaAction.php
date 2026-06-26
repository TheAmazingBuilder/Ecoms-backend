<?php
declare(strict_types=1);

namespace App\Modules\Media\Actions;

use App\Modules\Media\Models\Media;
use App\Modules\Media\Services\MediaService;
use Illuminate\Http\UploadedFile;

class UploadMediaAction
{
    public function __construct(private readonly MediaService $mediaService) {}

    public function execute(
        UploadedFile $file,
        string $mediableType,
        string $mediableId,
        string $collection = 'default'
    ): Media {
        return $this->mediaService->upload($file, $mediableType, $mediableId, $collection);
    }
}
