<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\RedirectResponse;

class RegisterUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'username' => 'string|unique:users,username',
            'name' => 'string',
            'password' => 'string',
            'confirm_password' => 'same:password'
        ];
    }

    protected function failedValidation(Validator $validator): RedirectResponse
    {
        if (isset($validator->getMessageBag()->getMessages()['confirm_password'])) {
            return redirect('/register')->with('error', "Password yang anda masukan tidak sama");
        } else if (isset($validator->getMessageBag()->getMessages()['username'])) {
            return redirect('/register')->with('error', "Username yang anda masukan sudah teregistrasi");
        } else {
            return redirect('/register')->with('error', $validator->getMessageBag());
        }
    }
}
