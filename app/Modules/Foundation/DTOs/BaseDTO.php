<?php
declare(strict_types=1);

namespace App\Modules\Foundation\DTOs;

abstract class BaseDTO
{
    /**
     * Convert DTO to array, filtering null values.
     */
    public function toArray(): array
    {
        return array_filter(
            get_object_vars($this),
            fn ($value) => $value !== null
        );
    }

    /**
     * Convert DTO to array including null values.
     */
    public function toRawArray(): array
    {
        return get_object_vars($this);
    }
}
