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
            'post_id'       => 'nullable|numeric',
            'subject'       => 'bail|required|string|max:60',
            'attachment'    => 'bail|required|string|in:text,drawing,url,video,image',
            'text'          => 'bail|required_without_all:drawing,url|required_if:attachment,text|max:255',
            'drawing'       => 'required_without_all:text,url|required_if:attachment,drawing|between:0,16777215',
            'url'           => 'required_without_all:drawing,text|required_if:attachment,url|required_if:attachment,video|required_if:attachment,image|max:255',
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
