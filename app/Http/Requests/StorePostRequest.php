<?php

namespace App\Http\Requests;

use Auth;
use Illuminate\Http\Response;
use Illuminate\Foundation\Http\FormRequest;

class StorePostRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'subject' => 'bail|required|max:255',
            'text' => 'required',
        ];
    }

    /**
     * Returns formatted response on error.
     */
    public function response(array $errors)
    {
        return response($errors, 422);
    }
}
