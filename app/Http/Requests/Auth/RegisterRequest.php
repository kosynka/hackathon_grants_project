<?php

namespace App\Http\Requests\Auth;

use App\Http\Rules\Phone;
use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'iin' => ['required', 'string'],
            'phone' => ['required', new Phone],
            'email' => ['required', 'email'],
            'photo_path' => ['nullable', 'image'],
            'password' => ['required', 'confirmed', 'string', 'max:32'],
        ];
    }
}
