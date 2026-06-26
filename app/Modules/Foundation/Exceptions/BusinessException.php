<?php
declare(strict_types=1);

namespace App\Modules\Foundation\Exceptions;

use Exception;

class BusinessException extends Exception
{
    public function __construct(string $message, int $code = 422)
    {
        parent::__construct($message, $code);
    }
}
