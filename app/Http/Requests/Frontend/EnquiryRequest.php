<?php

namespace App\Http\Requests\Frontend;

use Illuminate\Foundation\Http\FormRequest;

class EnquiryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name'       => 'required|string|max:100',
            'email'      => 'required|email|max:150',
            'phone'      => 'required|string|max:20',
            'subject'    => 'nullable|string|max:200',
            'event_type' => 'nullable|string|max:50',
            'event_date' => 'nullable|date',
            'message'    => 'required|string|min:10|max:2000',
            'source'     => 'nullable|string|max:50',
        ];
    }
}
