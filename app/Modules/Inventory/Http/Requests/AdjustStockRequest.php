<?php
declare(strict_types=1);

namespace App\Modules\Inventory\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdjustStockRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        return [
            'quantity' => ['required', 'integer'],
            'reason'   => ['sometimes', 'nullable', 'string', 'max:255'],
        ];
    }
}
