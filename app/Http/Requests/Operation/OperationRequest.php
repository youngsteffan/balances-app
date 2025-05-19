<?php

namespace App\Http\Requests\Operation;

use App\Enums\Operation\OperationType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class OperationRequest extends FormRequest
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
        $operationTypes = array_map(callback: fn ($type) => $type->value, array: OperationType::cases());

        return [
            'login' => 'required|string|exists:users,login',
            'amount' => 'required|numeric|min:0.01',
            'type' => ['required', 'string', Rule::in($operationTypes)],
            'description' => 'required|string',
        ];
    }
}
