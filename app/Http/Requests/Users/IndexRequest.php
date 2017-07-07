<?php

namespace App\Http\Requests\Users;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class CreateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        
        if (!Auth::check()) {
            return false;
        }
        if (Auth::user()->isAdmin()) {
            return true;
        }
        return true;
    }

   
   
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules() {
        return [
            'title' => 'required|max:191',
            'weight_global' => 'required',

        ];
    }

    public function messages() {
        if(config('app.locale')=='en'){
            return [

                'title.max' => 'Максимальная длина Названия 191 символов',
                'title.required' => "Поле Название  обязательно для заполнения",
                'weight_global.required' => "Поле Вес обязательно для заполнения",

            ];
        }
        if(config('app.locale')=='uk'){
            return [

                'title.max' => 'Максимальная длина Названия 191 символов',
                'title.required' => "Поле Название  обязательно для заполнения",
                'weight_global.required' => "Поле Вес обязательно для заполнения",

            ];
        }
        if(config('app.locale')=='ru'){
        return [

            'title.max' => 'Максимальная длина Названия 191 символов',
            'title.required' => "Поле Название  обязательно для заполнения",
            'weight_global.required' => "Поле Вес обязательно для заполнения",

        ];
        }
    }
}
