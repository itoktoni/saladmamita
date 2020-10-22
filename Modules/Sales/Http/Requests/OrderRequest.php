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

class OrderRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */

    private static $model;

    public function __construct(OrderRepository $models)
    {
        self::$model = $models;
    }

    public function prepareForValidation()
    {
        $autonumber = Helper::autoNumber(self::$model->getTable(), self::$model->getKeyName(), 'SO' . date('Ym'), config('website.autonumber'));
        if (!empty($this->code)  && config('module') == 'sales_order') {
            $autonumber = $this->code;
        }
        $map = collect($this->detail)->map(function ($item) use ($autonumber) {
            $product = new ProductRepository();
            $data_product = $product->showRepository($item['temp_id'])->first();
            $total = $item['temp_qty'] * Helper::filterInput($item['temp_price']) ?? 0;
            $discount = Helper::filterInput($item['temp_disc']) ?? 0;
            $discount_total = $discount * $total / 100;
            $data['sales_order_detail_order_id'] = $autonumber;
            $data['sales_order_detail_item_product_id'] = $item['temp_id'];
            $data['sales_order_detail_item_product_description'] = $item['temp_notes'] ?? '';
            $data['sales_order_detail_item_product_price'] = $data_product->item_product_sell ?? '';
            $data['sales_order_detail_item_product_weight'] = $data_product->item_product_weight ?? '';
            $data['sales_order_detail_qty'] = Helper::filterInput($item['temp_qty']);
            $data['sales_order_detail_price'] = Helper::filterInput($item['temp_price']) ?? 0;
            $data['sales_order_detail_total'] = $total - $discount_total;
            $data['sales_order_detail_discount_name'] = $item['temp_desc'];
            $data['sales_order_detail_discount_percent'] = Helper::filterInput($item['temp_disc']) ?? 0;
            $data['sales_order_detail_discount_value'] = $discount_total ?? 0;
            return $data;
        });

        $this->merge([
            'sales_order_id' => $autonumber,
            'sales_order_discount_value' => Helper::filterInput($this->sales_order_discount_value) ?? 0,
            'sales_order_tax_value' => Helper::filterInput($this->sales_order_tax_value) ?? 0,
            'sales_order_sum_product' => Helper::filterInput($this->sales_order_sum_product) ?? 0,
            'sales_order_sum_discount' => Helper::filterInput($this->sales_order_sum_discount) ?? 0,
            'sales_order_sum_tax' => Helper::filterInput($this->sales_order_sum_tax) ?? 0,
            'sales_order_sum_total' => Helper::filterInput($this->sales_order_sum_total) ?? 0,
            'detail' => array_values($map->toArray()),
            ]);
    }
        
    public function rules()
    {
        if (request()->isMethod('POST')) {
            return [
                'sales_order_from_id' => 'required',
                'sales_order_from_name' => 'required',
                'sales_order_to_id' => 'required',
                'sales_order_to_name' => 'required',
                'sales_order_term_top' => 'required',
                'sales_order_term_valid' => 'required|numeric',
                'detail' => 'required',
            ];
        }
        return [];
    }

    public function attributes()
    {
        return [
            'sales_order_from_id' => 'Company',
        ];
    }

    public function messages()
    {
        return [
            'detail.required' => 'Please input detail product !'
        ];
    }
}
