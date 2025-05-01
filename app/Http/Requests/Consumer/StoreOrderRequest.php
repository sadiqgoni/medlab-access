<?php

namespace App\Http\Requests\Consumer;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Models\Facility;
use App\Models\Service;
use Illuminate\Support\Facades\Auth;

class StoreOrderRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // Ensure the authenticated user is a consumer
        return Auth::check() && Auth::user()->role === 'consumer';
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
            'facility_id' => [
                'required',
                'integer',
                Rule::exists('facilities', 'id')->where(function ($query) {
                    $query->where('status', 'approved');
                }),
            ],
            'services' => ['required', 'array', 'min:1'],
            'services.*' => [
                'integer',
                Rule::exists('services', 'id')->where(function ($query) {
                    $query->where('is_active', true)
                          ->where('type', $this->input('order_type'));
                }),
                // Custom rule to check if service belongs to the selected facility
                function ($attribute, $value, $fail) {
                    $facility = Facility::find($this->input('facility_id'));
                    if ($facility && !$facility->services()->where('services.id', $value)->exists()) {
                        $fail("The selected service ({$value}) is not offered by the chosen facility.");
                    }
                },
            ],
            'delivery_address' => ['required', 'string', 'max:1000'],
            'scheduled_time' => ['nullable', 'date', 'after_or_equal:now'],
            'payment_method' => ['required', 'string', Rule::in(['card', 'bank', 'cash'])],
            'details' => ['nullable', 'array'], // Base rule for the details array itself
            'test_notes' => ['nullable', 'string', 'max:2000', Rule::requiredIf(fn() => $this->input('order_type') === 'test')], // Example: Make notes required for test orders
        ];

        // Dynamically add rules for service attributes within the 'details' array
        $selectedServiceIds = $this->input('services', []);
        if (!empty($selectedServiceIds)) {
            $services = Service::findMany($selectedServiceIds);
            
            foreach ($services as $service) {
                if (is_array($service->attributes)) {
                    foreach ($service->attributes as $attribute) {
                        if (!isset($attribute['name']) || !isset($attribute['type'])) continue; // Skip malformed attributes

                        $fieldName = 'details.' . $attribute['name'];
                        $fieldRules = [];

                        if ($attribute['required'] ?? false) {
                            $fieldRules[] = 'required';
                        } else {
                            $fieldRules[] = 'nullable';
                        }

                        switch ($attribute['type']) {
                            case 'text':
                            case 'textarea':
                                $fieldRules[] = 'string';
                                $fieldRules[] = 'max:2000'; // Adjust max length as needed
                                break;
                            case 'number':
                                $fieldRules[] = 'numeric';
                                break;
                            case 'select':
                                $fieldRules[] = 'string'; // Select values are usually strings
                                if (!empty($attribute['options']) && is_array($attribute['options'])) {
                                    $fieldRules[] = Rule::in($attribute['options']);
                                }
                                break;
                            case 'checkbox':
                                // Input will be '1' or '0' due to hidden input trick
                                $fieldRules[] = Rule::in(['0', '1']); 
                                break;
                            // Add other types like 'date', 'email', 'tel' if needed
                            default:
                                $fieldRules[] = 'string'; // Default to string
                                break;
                        }
                        $rules[$fieldName] = $fieldRules;
                    }
                }
            }
        }

        return $rules;
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages(): array
    {
        $messages = [
            'facility_id.exists' => 'The selected facility is invalid or not approved.',
            'services.*.exists' => 'One or more selected services are invalid, inactive, or do not match the order type.',
            'services.*' => 'Service validation failed.', // Generic message for the closure rule
            'details.*.required' => 'This field is required for the selected service(s).', // Generic required message
            'details.*.in' => 'The selected value for this field is invalid.', // Generic in message
            'details.*.numeric' => 'This field must be a number.',
            'details.*.string' => 'This field must be text.',
        ];

        // Dynamically add messages for specific detail fields if needed
        // Example: $messages['details.blood_units.required'] = 'Please specify the number of blood units.';

        return $messages;
    }
}
