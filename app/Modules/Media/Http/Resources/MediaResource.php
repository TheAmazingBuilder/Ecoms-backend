<?php
declare(strict_types=1);

namespace App\Modules\Media\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MediaResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'         => $this->id,
            'filename'   => $this->filename,
            'mime_type'  => $this->mime_type,
            'size'       => $this->size,
            'collection' => $this->collection,
            'url'        => $this->url,
            'created_at' => $this->created_at?->toIso8601String(),
        ];
    }
}
