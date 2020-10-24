<?php

namespace App\Http\Requests;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\Validator;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Exceptions\HttpResponseException;

class GeneralRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    private $rules;
    private $model;

    public function __construct()
    {
        // dd(request()->all());
        $this->model = request()->route()->getController()::$model ?? false;
        $this->rules = request()->route()->getController()::$model->rules ?? [];
        $collection = collect($this->rules)->map(function ($item, $key) {
            if (strpos($item, 'unique') !== false) {
                $string = explode('|', $item);
                $builder = '';
                foreach ($string as $value) {
                    if (strpos($value, 'unique') === false) {
                        $builder = $builder.$value.'|';
                    }
                }
                $key = rtrim($builder, "|");
            } else {
                $key = $item;
            }
            return $key;
        });
        if (request()->segment(3) == 'update') {
            $this->rules = $collection->toArray();
        }
    }

    public function prepareForValidation()
    {
        $this->merge([
            // 'content' => ''
        ]);
    }

    public function rules()
    {
        if (request()->isMethod('POST')) {
            return $this->rules;
        }
       
        return [];
    }
}
