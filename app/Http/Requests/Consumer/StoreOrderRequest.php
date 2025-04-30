<?php

namespace App\Http\Requests\Consumer;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class StoreOrderRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $rules = [
            'order_type' => ['required', 'string', Rule::in(['test', 'blood'])],
            'facility_id' => ['required', 'integer', 'exists:facilities,id'], // Ensure facility exists
            'delivery_address' => ['required', 'string', 'max:1000'],
            'scheduled_time' => ['nullable', 'date', 'after_or_equal:now'],
            'payment_method' => ['required', 'string', Rule::in(['paystack', 'cash'])], // Assuming cash might be an option
            // 'total_amount' => ['required', 'numeric', 'min:0'], // Might be calculated server-side
        ];

        if ($this->input('order_type') === 'test') {
            $rules = array_merge($rules, [
                'tests' => ['required', 'array', 'min:1'],
                'tests.*' => ['string', 'max:50'], // Validate each selected test identifier
                'test_notes' => ['nullable', 'string', 'max:2000'],
            ]);
        } elseif ($this->input('order_type') === 'blood') {
            $rules = array_merge($rules, [
                'blood_service' => ['required', 'string', Rule::in(['donate', 'request'])],
                'blood_group' => ['required', 'string', Rule::in(['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-'])],
            ]);

            if ($this->input('blood_service') === 'request') {
                $rules = array_merge($rules, [
                    'blood_units' => ['required', 'integer', 'min:1'],
                    'urgency' => ['required', 'string', Rule::in(['normal', 'urgent', 'emergency'])],
                    'blood_purpose' => ['required', 'string', 'max:2000'],
                ]);
            }
        }

        return $rules;
    }
}
