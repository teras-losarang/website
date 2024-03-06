<?php

namespace App\Http\Requests\Store;

use App\Facades\TerasMessage;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;

class UpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            "name" => "required",
            "address" => "required",
            "description" => "required",
            "file_thumbnail" => "image|mimes:png,jpg,jpeg",
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $response = new JsonResponse([
            'status' => TerasMessage::WARNING,
            'status_code' => TerasMessage::HTTP_UNPROCESSABLE_ENTITY,
            'message' => $validator->errors()
        ], TerasMessage::HTTP_UNPROCESSABLE_ENTITY);

        throw new ValidationException($validator, $response);
    }
}
