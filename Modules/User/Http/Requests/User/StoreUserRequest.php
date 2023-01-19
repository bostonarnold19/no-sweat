<?php

namespace Modules\User\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;

class StoreUserRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'first_name' => ['required', 'string'],
            'middle_name' => ['string', 'nullable'],
            'last_name' => ['required', 'string'],
            'username' => ['required', Rule::unique('users', 'username'), 'string'],
            'email' => ['required', Rule::unique('users', 'email'), 'email'],
        ];
    }

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
     * Modify input data
     *
     * @return array
     */
    public function getSanitized()
    {
        $sanitized = $this->validated();

        if(!isset($sanitized['password'])) {
            $sanitized['password'] = bcrypt(Str::random(10));
        }

        //Add your code for manipulation with request data here

        return $sanitized;
    }
}
