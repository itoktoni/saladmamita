<?php

namespace Modules\Rajaongkir\Http\Requests;

use App\Rules\Upload;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Exceptions\HttpResponseException;
use Modules\Rajaongkir\Dao\Repositories\PaketRepository;
use Modules\Rajaongkir\Dao\Repositories\ProvinceRepository;

class PaketRequest extends FormRequest
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
                'rajaongkir_paket_estimasi' => 'required|numeric',
                'rajaongkir_paket_name' => 'required',
                'rajaongkir_paket_code' => 'required|size:3',
            ];
        }
        return [];
    }
}
