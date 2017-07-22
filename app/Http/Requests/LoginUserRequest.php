<?php

namespace App\Http\Requests;

use Auth;
use Illuminate\Http\Response;
use Illuminate\Foundation\Http\FormRequest;

class LoginUserRequest extends FormRequest
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
            'email'         => 'required|email|max:255|exists:users',
            'password'      => 'required|min:6',
        ];
    }

    /**
     * Returns formatted response on error.
     */
    public function response(array $errors)
    {
        if ($this->ajax()) {
            return response($errors, 422);
        } else {
            return redirect('/settings')
                ->with('errors', $errors);
        }
    }
}