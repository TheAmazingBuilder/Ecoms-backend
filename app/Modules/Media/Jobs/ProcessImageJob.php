<?php
declare(strict_types=1);

namespace App\Modules\Media\Jobs;

use App\Modules\Media\Models\Media;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class ProcessImageJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(private readonly Media $media) {}

    public function handle(): void
    {
        // Image resize, thumbnail generation, optimization, etc.
        Log::info('Processing image', ['media_id' => $this->media->id, 'path' => $this->media->path]);
    }
}
