<?php
declare(strict_types=1);

namespace App\Modules\Media\Services;

use App\Modules\Foundation\Abstracts\BaseService;
use App\Modules\Media\Models\Media;
use App\Modules\Media\Repositories\Contracts\MediaRepositoryInterface;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class MediaService extends BaseService
{
    public function __construct(
        private readonly MediaRepositoryInterface $mediaRepository,
    ) {}

    public function upload(
        UploadedFile $file,
        string $mediableType,
        string $mediableId,
        string $collection = 'default',
        string $disk = 'public'
    ): Media {
        $path = $file->store("media/{$mediableType}/{$collection}", $disk);

        return $this->mediaRepository->create([
            'mediable_type' => $mediableType,
            'mediable_id'   => $mediableId,
            'disk'          => $disk,
            'path'          => $path,
            'filename'      => $file->getClientOriginalName(),
            'mime_type'     => $file->getMimeType(),
            'size'          => $file->getSize(),
            'collection'    => $collection,
        ]);
    }

    public function delete(string $id): void
    {
        $media = $this->mediaRepository->findOrFail($id);
        Storage::disk($media->disk)->delete($media->path);
        $this->mediaRepository->delete($media);
    }
}
