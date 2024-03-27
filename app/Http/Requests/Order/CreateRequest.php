<?php

namespace App\Http\Requests\Order;

use App\Facades\TerasMessage;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;

class CreateRequest extends FormRequest
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
            "address_id" => "required|exists:addresses,id",
            "cart_id" => "required|exists:carts,id",
            "shipping_cost" => "required|numeric",
            "service_fee" => "required|numeric",
            "total_cost" => "required|numeric",
            "payment_method" => "required",
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
