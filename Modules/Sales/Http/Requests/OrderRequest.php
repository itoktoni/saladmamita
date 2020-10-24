<?php

namespace Modules\Sales\Http\Requests;

use App\Dao\Facades\CompanyFacades;
use App\Http\Services\MasterService;
use Illuminate\Foundation\Http\FormRequest;
use Modules\Crm\Dao\Facades\CustomerFacades;
use Modules\Crm\Dao\Repositories\CustomerRepository;
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

        if(!request()->has('sales_order_from_id')){

            $company = CompanyFacades::find(auth()->user()->company);
            $from['sales_order_from_id'] = $company->company_id ?? null;
            $from['sales_order_from_name'] = $company->company_contact_person ?? null;
            $from['sales_order_from_phone'] = $company->company_contact_phone ?? null;
            $from['sales_order_from_email'] = $company->company_contact_email ?? null;
            $from['sales_order_from_address'] = $company->company_contact_address ?? null;
            $from['sales_order_from_area'] = $company->company_contact_rajaongkir_area_id ?? null;

            $this->merge($from);
        }

        if (empty(request()->get('sales_order_from_id'))) {

            $name = request()->get('sales_order_to_name');
            $address = request()->get('sales_order_to_address');
            $email = request()->get('sales_order_to_email');
            $phone = request()->get('sales_order_to_phone');
            $area = request()->get('sales_order_to_area');

            if($customer = CustomerFacades::where('crm_customer_contact_person', $name)->where('crm_customer_contact_phone', $phone)->first()){
                $to = $customer;
            }
            else{
                $customer = self::$service->save(new CustomerRepository(), [
                    'crm_customer_name' => $name,
                    'crm_customer_contact_description' => $name,
                    'crm_customer_contact_address' => $address,
                    'crm_customer_contact_email' => $email,
                    'crm_customer_contact_phone' => $phone,
                    'crm_customer_contact_person' => $name,
                    'crm_customer_contact_rajaongkir_area_id' => $area,
                    'crm_customer_delivery_name' => $name,
                    'crm_customer_delivery_address' => $address,
                    'crm_customer_delivery_email' => $email,
                    'crm_customer_delivery_phone' => $phone,
                    'crm_customer_delivery_person' => $name,
                    'crm_customer_delivery_rajaongkir_area_id' => $area,
                    'crm_customer_invoice_name' => $name,
                    'crm_customer_invoice_address' => $address,
                    'crm_customer_invoice_email' => $email,
                    'crm_customer_invoice_phone' => $phone,
                    'crm_customer_invoice_person' => $name,
                    'crm_customer_invoice_rajaongkir_area_id' => $area,
                ]);

                $to = $customer['data'];
            }

            $cust['sales_order_to_id'] = $to->crm_customer_id;
            $cust['sales_order_to_name'] = $to->crm_customer_name;
            $cust['sales_order_to_phone'] = $to->crm_customer_contact_phone;
            $cust['sales_order_to_email'] = $to->crm_customer_contact_email;
            $cust['sales_order_to_address'] = $to->crm_customer_contact_address;
            $cust['sales_order_to_area'] = $to->crm_customer_contact_rajaongkir_area_id;

            $this->merge($cust);
        }

        $map = collect($this->detail)->map(function ($item) use ($autonumber) {
            $product = new ProductRepository();
            $data_product = $product->showRepository($item['temp_id'])->first();
            $total = $item['temp_qty'] * Helper::filterInput($item['temp_price']) ?? 0;
            // $discount = Helper::filterInput($item['temp_disc']) ?? 0;
            // $discount_total = $discount * $total / 100;
            $data['sales_order_detail_order_id'] = $autonumber;
            $data['sales_order_detail_item_product_id'] = $item['temp_id'];
            $data['sales_order_detail_item_product_description'] = $item['temp_notes'] ?? '';
            $data['sales_order_detail_item_product_price'] = $data_product->item_product_sell ?? '';
            $data['sales_order_detail_item_product_weight'] = $data_product->item_product_weight ?? '';
            $data['sales_order_detail_qty'] = Helper::filterInput($item['temp_qty']);
            $data['sales_order_detail_price'] = Helper::filterInput($item['temp_price']) ?? 0;
            $data['sales_order_detail_total'] = $total;
            // $data['sales_order_detail_total'] = $total - $discount_total;
            // $data['sales_order_detail_discount_name'] = $item['temp_desc'];
            // $data['sales_order_detail_discount_percent'] = Helper::filterInput($item['temp_disc']) ?? 0;
            // $data['sales_order_detail_discount_value'] = $discount_total ?? 0;
            return $data;
        });

        $this->merge([
            'sales_order_id' => $autonumber,
            'sales_order_discount_value' => Helper::filterInput($this->sales_order_discount_value) ?? 0,
            // 'sales_order_tax_value' => Helper::filterInput($this->sales_order_tax_value) ?? 0,
            'sales_order_sum_product' => Helper::filterInput($this->sales_order_sum_product) ?? 0,
            'sales_order_sum_discount' => Helper::filterInput($this->sales_order_sum_discount) ?? 0,
            // 'sales_order_sum_tax' => Helper::filterInput($this->sales_order_sum_tax) ?? 0,
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
