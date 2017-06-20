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
            'subject'       => 'bail|required|max:255',
            'attachment'    => 'bail|required|numeric|min:0|max:4',
            'drawing'       => 'required_without_all:text,url|required_if:attachment,0',
            'text'          => 'required_without_all:drawing,url|required_if:attachment,1|max:255',
            'url'           => 'required_without_all:drawing,text|required_if:attachment,2|required_if:attachment,3|required_if:attachment,4|active_url',
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
