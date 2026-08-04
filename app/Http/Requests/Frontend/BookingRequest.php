<?php

namespace App\Http\Requests\Frontend;

use Illuminate\Foundation\Http\FormRequest;

class BookingRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'client_name'          => 'required|string|max:100',
            'client_email'         => 'required|email|max:150',
            'client_phone'         => 'required|string|max:20',
            'event_type'           => 'required|string|max:50',
            'service_id'           => 'nullable|exists:services,id',
            'package_id'           => 'nullable|exists:packages,id',
            'event_date'           => 'required|date|after_or_equal:today',
            'event_time'           => 'nullable|string',
            'guest_count'          => 'nullable|integer|min:1',
            'event_location'       => 'required|string|max:255',
            'event_city'           => 'nullable|string|max:100',
            'special_requirements' => 'nullable|string|max:2000',
            'reference_images.*'   => 'nullable|image|max:10240',
        ];
    }
}
