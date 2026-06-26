<?php
declare(strict_types=1);

namespace App\Modules\Inventory\DTOs;

use App\Modules\Foundation\DTOs\BaseDTO;

class InventoryDTO extends BaseDTO
{
    public function __construct(
        public readonly string $product_id,
        public readonly int $quantity,
        public readonly int $reserved_quantity = 0,
        public readonly int $low_stock_threshold = 5,
    ) {}

    public static function fromRequest(array $data): self
    {
        return new self(
            product_id:          $data['product_id'],
            quantity:            (int) $data['quantity'],
            reserved_quantity:   (int) ($data['reserved_quantity'] ?? 0),
            low_stock_threshold: (int) ($data['low_stock_threshold'] ?? 5),
        );
    }
}
