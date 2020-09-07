<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateQuizRequest extends FormRequest
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
            'content' => 'required|max:200',
            'level' => 'required|integer|between:1,5',
        ];
    }

    public function attributes()
    {
        return [
            'content'  => '問題文',
            'level' => '難易度',
        ];
    }
}
