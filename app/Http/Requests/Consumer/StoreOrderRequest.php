<?php

namespace App\Http\Requests\Consumer;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use App\Models\Service;

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
            'facility_id' => ['required', 'integer', 'exists:facilities,id'],
            'delivery_address' => ['required', 'string', 'max:1000'],
            'scheduled_time' => ['nullable', 'date', 'after_or_equal:now'],
            'payment_method' => ['required', 'string', Rule::in(['paystack', 'cash'])],
            'services' => ['required', 'array', 'min:1'],
            'services.*' => ['integer', 'exists:services,id'],
        ];

        $selectedServiceIds = $this->input('services', []);
        if (!empty($selectedServiceIds)) {
            $selectedServiceTypes = Service::whereIn('id', $selectedServiceIds)->pluck('type')->unique();
            
            if ($selectedServiceTypes->contains('test')) {
                $rules['test_notes'] = ['nullable', 'string', 'max:2000'];
            }
            
            if ($selectedServiceTypes->contains('blood_donation') || $selectedServiceTypes->contains('blood_request')) {
                 $rules['blood_group'] = ['required', 'string', Rule::in(['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-'])];
            }

            if ($selectedServiceTypes->contains('blood_request')) {
                 $rules['blood_units'] = ['required', 'integer', 'min:1'];
                 $rules['urgency'] = ['required', 'string', Rule::in(['normal', 'urgent', 'emergency'])];
                 $rules['blood_purpose'] = ['required', 'string', 'max:2000'];
            }

            // Custom rule using closure to prevent mixing service types
            $rules['services'][] = function ($attribute, $value, $fail) use ($selectedServiceTypes) {
                $containsTest = $selectedServiceTypes->contains('test');
                $containsBlood = $selectedServiceTypes->contains('blood_request') || $selectedServiceTypes->contains('blood_donation');
                
                if ($containsTest && $containsBlood) {
                    $fail('Cannot mix Lab Tests and Blood Services in the same order.');
                }
            };
        }
        
        return $rules;
    }
}
