<?php
declare(strict_types=1);

namespace App\Modules\Foundation\Traits;

use Illuminate\Database\Eloquent\Builder;

trait Filterable
{
    public function scopeFilter(Builder $query, array $filters): Builder
    {
        foreach ($filters as $key => $value) {
            $method = 'filterBy' . ucfirst($key);
            if (method_exists($this, $method) && $value !== null && $value !== '') {
                $query = $this->{$method}($query, $value);
            }
        }

        return $query;
    }
}
