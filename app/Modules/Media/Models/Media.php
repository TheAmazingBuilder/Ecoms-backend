<?php
declare(strict_types=1);

namespace App\Modules\Media\Models;

use App\Modules\Foundation\Abstracts\BaseModel;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Media extends BaseModel
{
    protected $fillable = ['mediable_type', 'mediable_id', 'disk', 'path', 'filename', 'mime_type', 'size', 'collection', 'order'];

    protected function casts(): array
    {
        return array_merge(parent::casts(), [
            'size'  => 'integer',
            'order' => 'integer',
        ]);
    }

    public function mediable(): MorphTo
    {
        return $this->morphTo();
    }

    public function getUrlAttribute(): string
    {
        return \Illuminate\Support\Facades\Storage::disk($this->disk)->url($this->path);
    }
}
