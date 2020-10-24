<?php

namespace App\Http\Requests;

use App\Rules\Upload;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;

class TeamCreateRequest extends FormRequest
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
                'username'  => 'required|min:3|unique:users',
                'email'      => 'required|email|unique:users',
                'group_user' => 'required',
                // 'testing' => new Upload()
            ];
        }
        return [];
    }
}
