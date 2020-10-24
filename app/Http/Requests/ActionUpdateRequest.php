<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ActionUpdateRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        if (request()->isMethod('POST')) {
            return [
                'username'  => 'required',
                'email'      => 'required|email',
                'group_user' => 'required',
            ];
        }
        return [];
    }
}
