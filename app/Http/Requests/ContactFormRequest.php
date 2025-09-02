<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContactFormRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required|string|max:255|min:2',
            'email' => 'required|email:rfc,dns|max:255',
            'phone' => 'nullable|string|max:20|regex:/^[\+]?[0-9\s\-\(\)]+$/',
            'subject' => 'required|string|max:255|min:5',
            'message' => 'required|string|max:2000|min:10'
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Nama lengkap wajib diisi.',
            'name.min' => 'Nama minimal 2 karakter.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'phone.regex' => 'Format nomor telepon tidak valid.',
            'subject.required' => 'Subject wajib diisi.',
            'subject.min' => 'Subject minimal 5 karakter.',
            'message.required' => 'Pesan wajib diisi.',
            'message.min' => 'Pesan minimal 10 karakter.',
            'message.max' => 'Pesan maksimal 2000 karakter.'
        ];
    }
}