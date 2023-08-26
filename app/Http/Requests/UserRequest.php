<?php

namespace App\Http\Requests;

use App\Rules\ExistingAndNotSoftDeleted;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class UserRequest extends FormRequest
{
    const REGEX = '/^(?=.[a-z])(?=.[A-Z])(?=.\d)(?=.[@$!%?&])[A-Za-z\d@$!%?&]{15,30}$/';
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json($validator->errors(), 422));
    }
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'user_name' => 'required|string|unique:users',
            "full_name" => 'required|string|min:2|max:55',
            "email" => 'required|email|max:255|unique:users',
            'password' => 'required|regex:'.self::REGEX,
            "role_id" => ['required', new ExistingAndNotSoftDeleted('roles')],
        ];
    }
}
