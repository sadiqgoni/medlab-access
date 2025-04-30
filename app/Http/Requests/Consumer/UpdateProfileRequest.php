<?php

namespace App\Http\Requests\Consumer;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class UpdateProfileRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // Ensure the logged-in user is making the request
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:20'], // Basic phone validation, consider more specific regex if needed
            'address' => ['required', 'string', 'max:1000'],
            'communication_preference' => ['nullable', 'array'], // Validate it's an array if present
            'communication_preference.*' => ['string', Rule::in(['email', 'sms'])], // Validate allowed values
        ];
    }
}
