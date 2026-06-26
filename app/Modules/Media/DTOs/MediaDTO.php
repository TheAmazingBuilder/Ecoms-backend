<?php
declare(strict_types=1);

namespace App\Modules\Media\DTOs;

use App\Modules\Foundation\DTOs\BaseDTO;

class MediaDTO extends BaseDTO
{
    public function __construct(
        public readonly string $mediable_type,
        public readonly string $mediable_id,
        public readonly string $collection = 'default',
        public readonly string $disk = 'public',
    ) {}
}
