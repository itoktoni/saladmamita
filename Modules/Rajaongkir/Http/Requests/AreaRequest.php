<?php

namespace Modules\Rajaongkir\Http\Requests;

use App\Rules\Upload;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Exceptions\HttpResponseException;
use Modules\Rajaongkir\Dao\Repositories\CityRepository;
use Modules\Rajaongkir\Dao\Repositories\ProvinceRepository;

class AreaRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */

    public function prepareForValidation()
    {
        if (request()->has('rajaongkir_area_city_id')) {
            $id = request()->get('rajaongkir_area_city_id');
            $city = CityRepository::find($id);
            if ($city) {
                $this->merge([
                    'rajaongkir_city_province_id' => $city->rajaongkir_city_name,
                    'rajaongkir_city_province_name' => $city->rajaongkir_city_name,
                ]);
            }
        }
    }

    public function rules()
    {
        if (request()->isMethod('POST')) {
            return [
                'rajaongkir_city_province_id'  => 'required',
                'rajaongkir_city_province_name'      => 'required',
                'rajaongkir_city_type' => 'required',
                'rajaongkir_city_name' => 'required',
                'rajaongkir_city_postal_code' => 'required|size:5|numeric',
            ];
        }
        return [];
    }
}
