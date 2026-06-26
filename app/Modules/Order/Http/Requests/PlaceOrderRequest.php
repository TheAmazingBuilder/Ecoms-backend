<?php
declare(strict_types=1);

namespace App\Modules\Order\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PlaceOrderRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        return [
            'items'                      => ['required', 'array', 'min:1'],
            'items.*.product_id'         => ['required', 'uuid', 'exists:products,id'],
            'items.*.quantity'           => ['required', 'integer', 'min:1'],
            'shipping_address'           => ['required', 'array'],
            'shipping_address.name'      => ['required', 'string'],
            'shipping_address.address'   => ['required', 'string'],
            'shipping_address.city'      => ['required', 'string'],
            'shipping_address.zip'       => ['required', 'string'],
            'shipping_address.country'   => ['required', 'string'],
            'billing_address'            => ['sometimes', 'array'],
            'payment_method'             => ['sometimes', 'string', 'in:cash,card,paypal,stripe'],
            'notes'                      => ['sometimes', 'nullable', 'string'],
            'shipping_amount'            => ['sometimes', 'numeric', 'min:0'],
            'discount_amount'            => ['sometimes', 'numeric', 'min:0'],
        ];
    }
}
