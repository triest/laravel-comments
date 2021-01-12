<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class RComment extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if(!Auth::user()){
            return  false;
        }
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
                'text' => 'required|max:255',
                'parent_id' => 'exists:comments,id',
        ];
    }

    public function messages()
    {
        return [
                'text.required' => 'Введите текст комментария!',
                'parent_id.exists' => 'Не найден комментария, на который вы отвечаете',
        ];
    }
}
