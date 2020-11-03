<?php

namespace Modules\Sales\Http\Requests;

use App\Http\Services\MasterService;
use Illuminate\Foundation\Http\FormRequest;
use Modules\Crm\Dao\Facades\CustomerFacades;
use Modules\Crm\Dao\Repositories\CustomerRepository;
use Modules\Item\Dao\Repositories\ProductRepository;
use Modules\Sales\Dao\Repositories\OrderRepository;
use Plugin\Helper;

class OrderRequestUpdate extends FormRequest
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

            $qty = Helper::filterInput($item['temp_qty']);
            if(isset($item['variant'])){
                $total = collect($item['variant'])->sum('sales_order_detail_variant_qty');
                $qty = $total;
                
                // if(intval($item['temp_qty']) != $total){
                //     abort(403, 'Qty Variant Tidak Sama Dengan Qty Total !');
                // }

                $data['variant'] = $item['variant'];
            }

            $data['sales_order_detail_qty'] = $qty;
            $total = $qty * Helper::filterInput($item['temp_price']) ?? 0;
            $data['sales_order_detail_order_id'] = $autonumber;
            $data['sales_order_detail_item_product_id'] = $item['temp_id'];
            $data['sales_order_detail_notes'] = $item['temp_notes'] ?? '';
            $data['sales_order_detail_item_product_price'] = $data_product->item_product_sell ?? '';
            $data['sales_order_detail_item_product_weight'] = $data_product->item_product_weight ?? '';
            $data['sales_order_detail_price'] = Helper::filterInput($item['temp_price']) ?? 0;
            $data['sales_order_detail_total'] = $total;

            return $data;
        });

        $this->merge([
            'sales_order_id' => $autonumber,
            'sales_order_discount_value' => Helper::filterInput($this->sales_order_discount_value) ?? 0,
            'sales_order_sum_product' => Helper::filterInput($this->sales_order_sum_product) ?? 0,
            'sales_order_sum_discount' => Helper::filterInput($this->sales_order_sum_discount) ?? 0,
            'sales_order_sum_total' => Helper::filterInput($this->sales_order_sum_total) ?? 0,
            'sales_order_sum_ongkir' => Helper::filterInput($this->sales_order_sum_ongkir) ?? 0,
            'detail' => array_values($map->toArray()),
        ]);
            

        // return redirect()->route('sales_order_update', ['code' => request()->get('code')])->withErrors('error');
    }

    public function rules()
    {
        if (request()->isMethod('POST')) {
            return [
                'sales_order_from_id' => 'required',
                'sales_order_from_name' => 'required',
                'sales_order_to_id' => 'required',
                'sales_order_to_name' => 'required',
                // 'sales_order_term_top' => 'required',
                // 'sales_order_term_valid' => 'required|numeric',
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
            'detail.required' => 'Please input detail product !',
        ];
    }
}
