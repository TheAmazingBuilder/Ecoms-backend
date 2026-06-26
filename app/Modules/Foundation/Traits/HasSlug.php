<?php
declare(strict_types=1);

namespace App\Modules\Foundation\Traits;

use Illuminate\Support\Str;

trait HasSlug
{
    protected string $slugSource = 'name';

    public static function bootHasSlug(): void
    {
        static::creating(function ($model) {
            $source = $model->slugSource ?? 'name';
            if (empty($model->slug) && !empty($model->{$source})) {
                $model->slug = static::generateUniqueSlug($model->{$source});
            }
        });

        static::updating(function ($model) {
            $source = $model->slugSource ?? 'name';
            if ($model->isDirty($source)) {
                $model->slug = static::generateUniqueSlug($model->{$source}, $model->getKey());
            }
        });
    }

    protected static function generateUniqueSlug(string $value, ?string $excludeId = null): string
    {
        $slug = Str::slug($value);
        $count = 1;
        $originalSlug = $slug;

        while (
            static::where('slug', $slug)
                ->when($excludeId, fn ($q) => $q->where('id', '!=', $excludeId))
                ->exists()
        ) {
            $slug = $originalSlug . '-' . $count++;
        }

        return $slug;
    }
}
