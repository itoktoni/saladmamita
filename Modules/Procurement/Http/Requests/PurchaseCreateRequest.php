<?php

namespace Modules\Procurement\Http\Requests;

use App\User;
use Plugin\Helper;
use App\Rules\Upload;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Modules\Procurement\Dao\Models\Purchase;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Exceptions\HttpResponseException;

class PurchaseCreateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */

    public static $model;

    public function __construct(Purchase $models)
    {
        if (self::$model == null) {
            self::$model = $models;
        }
    }

    public function prepareForValidation()
    {
        $autonumber = Helper::autoNumber(self::$model->getTable(), self::$model->getKeyName(), self::$model->prefix, config('website.autonumber'));
        $map = collect($this->detail)->map(function ($item) use ($autonumber) {
            $data['purchase_detail_purchase_id'] = $autonumber;
            $data['purchase_detail_option'] = $item['temp_id'];
            $data['purchase_detail_item_product_id'] = $item['temp_product'];
            $data['purchase_detail_qty_order'] = Helper::filterInput($item['temp_qty']);
            $data['purchase_detail_price_order'] = Helper::filterInput($item['temp_price']) ?? 0;
            $data['purchase_detail_total_order'] = $item['temp_qty'] * Helper::filterInput($item['temp_price']) ?? 0;
            return $data;
        });
        $this->merge([
            'purchase_id' => $autonumber,
            'detail' => array_values($map->toArray()),
        ]);
    }

    public function rules()
    {
        if (request()->isMethod('POST')) {
            return array_merge([
                'temp_id' => 'required',
                'detail' => 'array',
                'detail.*.temp_price' => 'required',
                'detail.*.temp_qty' => 'required',
            ], self::$model->rules);
        }
        return [];
    }

    public function attributes()
    {
        return [
            'purchase_procurement_vendor_id' => 'Vendor',
        ];
    }

    public function messages()
    {
        return [
            'temp_id.required' => 'Please input detail product !'
        ];
    }
}
