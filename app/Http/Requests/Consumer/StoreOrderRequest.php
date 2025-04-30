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
            'details' => ['nullable', 'array'],
        ];

        $selectedServiceIds = $this->input('services', []);
        if (!empty($selectedServiceIds)) {
            $services = Service::with('facility')->whereIn('id', $selectedServiceIds)->get();

            // Prevent ordering from multiple facilities at once
            if ($services->pluck('facility_id')->unique()->count() > 1) {
                $rules['services'][] = fn ($attribute, $value, $fail) => $fail('Cannot order services from multiple facilities at once.');
            }
            
            // Validate dynamically defined attributes from services
            foreach ($services as $service) {
                if (is_array($service->attributes)) {
                    foreach ($service->attributes as $attribute) {
                        $fieldName = 'details.' . $attribute['name'];
                        $fieldRules = [];
                        if ($attribute['required'] ?? false) {
                            $fieldRules[] = 'required';
                        } else {
                            $fieldRules[] = 'nullable';
                        }

                        switch ($attribute['type'] ?? 'text') {
                            case 'text':
                            case 'textarea':
                                $fieldRules[] = 'string';
                                $fieldRules[] = 'max:2000'; // Example max length
                                break;
                            case 'number':
                                $fieldRules[] = 'numeric';
                                break;
                            case 'select':
                                $fieldRules[] = Rule::in($attribute['options'] ?? []);
                                break;
                            case 'checkbox':
                                $fieldRules[] = 'boolean'; // Handles 0/1 from hidden input
                                break;
                            // Add other type validations as needed
                        }
                        $rules[$fieldName] = $fieldRules;
                    }
                }
            }
        }
        
        return $rules;
    }
}
