<?php

namespace App\Http\Requests\Backoffice;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Auth;

class UpdateMyAccountRequest extends FormRequest
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
        $user = Auth::user();

        $rules = [
            'full_name' => 'required',
            'email' => [
                    'bail',
                    'email',
                    'required',
                    Rule::unique('users')->ignore($user->id),
                ], 
            'password' => [
                    'nullable',
                    'confirmed',
                ],
        ];
        
        return $rules;
    }
}
