<?php

namespace Modules\Marketing\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LanggananRequest extends FormRequest
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
