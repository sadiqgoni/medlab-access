<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', Rule::unique('users')->ignore($this->user()->id)],
            'phone' => ['required', 'string', 'max:20', Rule::unique('users')->ignore($this->user()->id)],
            'address' => ['required', 'string', 'max:1000'],
            'latitude' => ['nullable', 'numeric', 'between:-90,90'],
            'longitude' => ['nullable', 'numeric', 'between:-180,180'],
            
            // Personal Information
            'date_of_birth' => ['nullable', 'date', 'before:today'],
            'gender' => ['nullable', 'string', 'in:male,female,other,prefer_not_to_say'],
            'blood_group' => ['nullable', 'string', 'in:A+,A-,B+,B-,AB+,AB-,O+,O-'],
            'occupation' => ['nullable', 'string', 'max:255'],
            
            // Contact Information
            'emergency_contact' => ['nullable', 'string', 'max:20'],
            
            // Medical Information
            'allergies' => ['nullable', 'string', 'max:1000'],
            'current_medications' => ['nullable', 'string', 'max:1000'],
            'medical_conditions' => ['nullable', 'string', 'max:1000'],
            
            // Medical Preferences
            'willing_to_donate_blood' => ['nullable', 'boolean'],
            'emergency_contact_consent' => ['nullable', 'boolean'],
            'health_reminders' => ['nullable', 'boolean'],
            
            // Privacy Settings
            'marketing_consent' => ['nullable', 'boolean'],
            'data_sharing_consent' => ['nullable', 'boolean'],
            'location_tracking' => ['nullable', 'boolean'],
            
            // Communication Preference
            'communication_preference' => ['nullable', 'string', 'in:email,sms,app'],
            
            // Password Change (optional)
            'current_password' => ['nullable', 'string', 'current_password'],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
            'password_confirmation' => ['nullable', 'string'],
        ];
    }
}
