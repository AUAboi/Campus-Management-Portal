<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user()->can('create', User::class);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'father_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'cnic' => 'required|max:13|unique:users',
            'phone' => 'required|string|max:12',
            'password' => 'required|string|min:8|confirmed',
            'gender' => 'required|string',
            'date_of_birth' => 'required|date'
        ];
    }
}
