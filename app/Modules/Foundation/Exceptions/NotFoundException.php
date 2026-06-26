<?php
declare(strict_types=1);

namespace App\Modules\Foundation\Exceptions;

use Exception;

class NotFoundException extends Exception
{
    public function __construct(string $resource = 'Resource', string $id = '')
    {
        parent::__construct(
            "{$resource} not found" . ($id ? " with ID: {$id}" : ''),
            404
        );
    }
}
