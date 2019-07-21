<?php

namespace App\Http\Requests\Pages\Articles;

use Illuminate\Foundation\Http\FormRequest;

class CreateArticleRequest extends FormRequest
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
            'category_id' => 'required',
            'title' => 'required|string|min:10',
            'article' => 'required|min: 100',
            'comment' => 'required',
            'sendEmail' => 'required'
        ];
    }
}
