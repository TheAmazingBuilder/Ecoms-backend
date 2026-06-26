<?php
declare(strict_types=1);

namespace App\Modules\Media\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UploadMediaRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        return [
            'file'          => ['required', 'file', 'max:10240', 'mimes:jpg,jpeg,png,gif,webp,pdf,mp4'],
            'mediable_type' => ['required', 'string'],
            'mediable_id'   => ['required', 'uuid'],
            'collection'    => ['sometimes', 'string', 'max:100'],
        ];
    }
}
