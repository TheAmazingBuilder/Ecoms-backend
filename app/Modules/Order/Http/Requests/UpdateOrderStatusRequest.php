<?php
declare(strict_types=1);

namespace App\Modules\Order\Http\Requests;

use App\Modules\Order\Models\Order;
use Illuminate\Foundation\Http\FormRequest;

class UpdateOrderStatusRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        return [
            'status' => ['required', 'string', 'in:' . implode(',', [
                Order::STATUS_CONFIRMED,
                Order::STATUS_PROCESSING,
                Order::STATUS_SHIPPED,
                Order::STATUS_DELIVERED,
                Order::STATUS_CANCELLED,
                Order::STATUS_REFUNDED,
            ])],
        ];
    }
}
