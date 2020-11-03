<?php

namespace Modules\Sales\Http\Requests;

use App\Http\Services\MasterService;
use Illuminate\Foundation\Http\FormRequest;
use Modules\Item\Dao\Repositories\ProductRepository;
use Modules\Sales\Dao\Repositories\OrderRepository;
use Plugin\Helper;

class OrderRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */

    private static $model;
    private static $service;

    public function __construct(OrderRepository $models, MasterService $services)
    {
        self::$model = $models;
        self::$service = $services;
    }

    public function prepareForValidation()
    {
        $autonumber = Helper::autoNumber(self::$model->getTable(), self::$model->getKeyName(), 'SO' . date('Ym'), config('website.autonumber'));
        if (!empty($this->code) && config('module') == 'sales_order') {
            $autonumber = $this->code;
        }

        $map = collect($this->detail)->map(function ($item) use ($autonumber) {
            $product = new ProductRepository();
            $data_product = $product->showRepository($item['temp_id'])->first();
            $total = $item['temp_qty'] * Helper::filterInput($item['temp_price']) ?? 0;
            // $discount = Helper::filterInput($item['temp_disc']) ?? 0;
            // $discount_total = $discount * $total / 100;
            $data['sales_order_detail_order_id'] = $autonumber;
            $data['sales_order_detail_item_product_id'] = $item['temp_id'];
            $data['sales_order_detail_notes'] = $item['temp_notes'] ?? '';
            $data['sales_order_detail_item_product_price'] = $data_product->item_product_sell ?? '';
            $data['sales_order_detail_item_product_weight'] = $data_product->item_product_weight ?? '';
            $data['sales_order_detail_qty'] = Helper::filterInput($item['temp_qty']);
            $data['sales_order_detail_price'] = Helper::filterInput($item['temp_price']) ?? 0;
            $data['sales_order_detail_total'] = $total;
            // $data['sales_order_detail_total'] = $total - $discount_total;
            // $data['sales_order_detail_discount_name'] = $item['temp_desc'];
            // $data['sales_order_detail_discount_percent'] = Helper::filterInput($item['temp_disc']) ?? 0;
            // $data['sales_order_detail_discount_value'] = $discount_total ?? 0;

            if ($data_product->variant()->count() > 0) {

                foreach ($data_product->variant() as $variants) {
                    $variant[] = [
                        'sales_order_detail_variant_order_id' => $autonumber,
                        'sales_order_detail_variant_item_product_id' => $item['temp_id'],
                        'sales_order_detail_variant_item_variant_id' => $variants->item_variant_id,
                        'sales_order_detail_variant_qty' => 0,
                    ];
                }
            }

            return [
                'detail' => $data,
                'variant' => $variant,
            ];
        });

        $this->merge([
            'sales_order_id' => $autonumber,
            'sales_order_discount_value' => Helper::filterInput($this->sales_order_discount_value) ?? 0,
            // 'sales_order_tax_value' => Helper::filterInput($this->sales_order_tax_value) ?? 0,
            'sales_order_sum_product' => Helper::filterInput($this->sales_order_sum_product) ?? 0,
            'sales_order_sum_discount' => Helper::filterInput($this->sales_order_sum_discount) ?? 0,
            // 'sales_order_sum_tax' => Helper::filterInput($this->sales_order_sum_tax) ?? 0,
            'sales_order_sum_total' => Helper::filterInput($this->sales_order_sum_total) ?? 0,
            'detail' => $map->toArray(),
        ]);
    }

    public function rules()
    {
        if (request()->isMethod('POST')) {
            return [
                'sales_order_from_id' => 'required',
                'sales_order_from_name' => 'required',
                'sales_order_to_name' => 'required',
                'detail' => 'required',
            ];
        }
        return [];
    }

    public function attributes()
    {
        return [
            'sales_order_to_name' => 'Customer',
            'sales_order_from_name' => 'Branch',
            'sales_order_from_id' => 'Location',
        ];
    }

    public function messages()
    {
        return [
            'detail.required' => 'Please input detail product !',
        ];
    }
}
