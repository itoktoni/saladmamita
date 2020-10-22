<?php

namespace App\Http\Requests;

use Illuminate\Http\JsonResponse;
use Illuminate\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;

class ActionCreateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */

    public function prepareForValidation()
    {

        $this->merge([
            // 'content' => ''
        ]);
    }

    public function rules()
    {
        if (request()->isMethod('POST')) {
            return [
                'action_code' => 'required|unique:core_actions',
                'action_name' => 'required|min:3',
            ];
        }
        return [];
    }
}
