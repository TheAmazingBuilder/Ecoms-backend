<?php
declare(strict_types=1);

namespace App\Modules\Order\DTOs;

use App\Modules\Foundation\DTOs\BaseDTO;

class OrderDTO extends BaseDTO
{
    public function __construct(
        public readonly string $user_id,
        public readonly array $items,
        public readonly array $shipping_address,
        public readonly array $billing_address,
        public readonly string $payment_method = 'cash',
        public readonly ?string $notes = null,
        public readonly float $shipping_amount = 0.0,
        public readonly float $discount_amount = 0.0,
    ) {}

    public static function fromRequest(array $data, string $userId): self
    {
        return new self(
            user_id:          $userId,
            items:            $data['items'],
            shipping_address: $data['shipping_address'],
            billing_address:  $data['billing_address'] ?? $data['shipping_address'],
            payment_method:   $data['payment_method'] ?? 'cash',
            notes:            $data['notes'] ?? null,
            shipping_amount:  (float) ($data['shipping_amount'] ?? 0),
            discount_amount:  (float) ($data['discount_amount'] ?? 0),
        );
    }
}
