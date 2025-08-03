<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateOrderRequest extends FormRequest
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
            'user_id' => 'sometimes|required|exists:users,id',
            'status' => 'sometimes|required|string|in:pending,processing,completed,cancelled',
            'total_price' => 'sometimes|required|numeric|min:0|max:999999.99',
            'order_items' => 'sometimes|required|array|min:1',
            'order_items.*.product_id' => 'sometimes|required|exists:products,id',
            'order_items.*.quantity' => 'sometimes|required|integer|min:1|max:99999',
            'order_items.*.price_per_unit' => 'sometimes|required|numeric|min:0|max:999999.99',
        ];
    }
}
