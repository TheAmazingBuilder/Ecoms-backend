<?php
declare(strict_types=1);

namespace App\Modules\Order\DTOs;

use App\Modules\Foundation\DTOs\BaseDTO;

class OrderItemDTO extends BaseDTO
{
    public function __construct(
        public readonly string $product_id,
        public readonly int $quantity,
        public readonly float $unit_price,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            product_id: $data['product_id'],
            quantity:   (int) $data['quantity'],
            unit_price: (float) $data['unit_price'],
        );
    }
}
