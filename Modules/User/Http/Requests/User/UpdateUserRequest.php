<?php

namespace Modules\User\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

class UpdateUserRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'first_name' => ['sometimes', 'string'],
            'middle_name' => ['string', 'nullable'],
            'last_name' => ['sometimes', 'string'],
            'username' => ['sometimes', Rule::unique('users', 'username')->ignore($this->user->getKey(), $this->user->getKeyName()), 'string'],
            'email' => ['sometimes', Rule::unique('users', 'email')->ignore($this->user->getKey(), $this->user->getKeyName()), 'email'],
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

        //Add your code for manipulation with request data here

        return $sanitized;
    }
}
