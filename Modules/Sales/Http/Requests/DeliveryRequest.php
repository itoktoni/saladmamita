<?php

namespace Modules\Sales\Http\Requests;

use Plugin\Helper;
use Modules\Sales\Dao\Models\Order;
use Nwidart\Modules\Facades\Module;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;
use Modules\Sales\Dao\Repositories\OrderRepository;
use Modules\Item\Dao\Repositories\ProductRepository;
use Modules\Sales\Dao\Models\OrderDetail;
use Modules\Sales\Dao\Repositories\DeliveryRepository;

class DeliveryRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */

    private static $model;

    public function __construct(DeliveryRepository $models)
    {
        self::$model = $models;
    }

    public function prepareForValidation()
    {
        $autonumber = Helper::autoNumber(self::$model->getTable(), self::$model->getKeyName(), 'DO' . date('Ym'), config('website.autonumber'));
        if (!empty($this->code) && config('module') == 'sales_delivery') {
            $autonumber = $this->code;
        }

        if ($this->sales_delivery_sales_order_id) {
            $this->code = $this->sales_delivery_sales_order_id;
        }

        $map = collect($this->detail)->map(function ($item) use ($autonumber) {
            $product = new ProductRepository();
            $data['sales_delivery_detail_delivery_id'] = $autonumber;
            $data['sales_delivery_detail_order_id'] = $this->code;
            $data['sales_delivery_detail_item_product_id'] = $item['temp_id'];
            
            $total = Helper::filterInput($item['temp_out']) * Helper::filterInput($item['temp_price']) ?? 0;
            $discount = Helper::filterInput($item['temp_dpercent']) ?? 0;
            $discount_total = $discount * $total / 100;

            $data['sales_delivery_detail_item_product_description'] = Helper::filterInput($item['temp_desc']);
            $data['sales_delivery_detail_qty'] = Helper::filterInput($item['temp_qty']);
            $data['sales_delivery_detail_out'] = Helper::filterInput($item['temp_out']);
            $data['sales_delivery_detail_notes'] = Helper::filterInput($item['temp_notes']);
            $data['sales_delivery_detail_price'] = Helper::filterInput($item['temp_price']);
            $data['sales_delivery_detail_total'] = $total - $discount_total;
            $data['sales_delivery_detail_discount_name'] = Helper::filterInput($item['temp_dname']);
            $data['sales_delivery_detail_discount_percent'] = Helper::filterInput($item['temp_dpercent']);
            $data['sales_delivery_detail_discount_value'] = $discount_total;
            return $data;
        });

        $this->merge([
            'sales_delivery_id' => $autonumber,
            'sales_delivery_sales_order_id' => $this->code,
            'detail' => array_values($map->toArray()),
            ]);
    }
        
    public function rules()
    {
        if (request()->isMethod('POST')) {
            return [
                'sales_delivery_from_id' => 'required',
                'sales_delivery_from_name' => 'required',
                'sales_delivery_to_id' => 'required',
                'sales_delivery_to_name' => 'required',
                'detail' => 'required',
            ];
        }
        return [];
    }

    public function attributes()
    {
        return [
            'sales_delivery_from_id' => 'Company',
        ];
    }

    public function messages()
    {
        return [
            'detail.required' => 'Please input detail product !'
        ];
    }
}