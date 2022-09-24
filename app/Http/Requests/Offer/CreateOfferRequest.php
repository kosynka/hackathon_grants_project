<?php

namespace App\Http\Requests\Offer;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class CreateOfferRequest extends FormRequest
{
    public function authorize()
    {
        return Auth::check();
    }

    public function rules()
    {
        return [
            'title' => ['required', 'string'],
            'description' => ['required', 'string'],
            'document_path' => ['required', 'file'],
            'image_path' => ['nullable', 'image'],
        ];
    }
}
