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
            'text' => 'required_without_all:drawing,url|max:255',
            'drawing' => 'required_without_all:text,url',
            'url' => 'required_without_all:drawing,text|active_url',
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
