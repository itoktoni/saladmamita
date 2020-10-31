<?php

namespace Modules\Sales\Http\Services;

use Plugin\Alert;
use Plugin\Helper;
use Darryldecode\Cart\Facades\CartFacade as Cart;
use App\Dao\Facades\BranchFacades;
use Illuminate\Support\Facades\DB;
use App\Http\Services\MasterService;
use App\Dao\Interfaces\MasterInterface;
use Modules\Sales\Dao\Facades\OrderFacades;
use Modules\Crm\Dao\Facades\CustomerFacades;
use Modules\Sales\Dao\Facades\OrderDetailFacades;
use Modules\Sales\Dao\Facades\DeliveryDetailFacades;
use Modules\Sales\Dao\Facades\OrderDetailVariantFacades;

class PublicService extends MasterService
{
    public function save(MasterInterface $repository, $request)
    {
        $check = false;
        try {
            $autonumber = Helper::autoNumber(OrderFacades::getTable(), OrderFacades::getKeyName(), 'SO' . date('Ym'), config('website.autonumber'));
            $request['sales_order_id'] = $autonumber;
            $request['sales_order_status'] = 1;

            $branch = BranchFacades::find($request['sales_order_from_id']);

            $request['sales_order_from_name'] = $branch->branch_name;
            $request['sales_order_from_name'] = $branch->branch_name;
            $request['sales_order_from_phone'] = $branch->branch_phone;
            $request['sales_order_from_email'] = $branch->branch_email;
            $request['sales_order_from_address'] = $branch->branch_address;
            $request['sales_order_from_area'] = $branch->branch_rajaongkir_area_id;

            $sub_total = Cart::getSubTotal();
            $total = Cart::getTotal();
            $discount_value = 0;  
            $discount_name = $discount_percent = '';

            if($disc = Cart::getConditions()->first()){
                $discount_value = $disc->getValue(); 
                $discount_name = $disc->getAttributes()['name'] ?? '';
            }   
            
            $request['sales_order_discount_name'] = $discount_name;
            $request['sales_order_discount_value'] = abs($discount_value);
            
            $request['sales_order_sum_product'] = $sub_total;
            $request['sales_order_sum_discount'] = $total;
            $request['sales_order_sum_total'] = $total;

            $check = $repository->saveRepository($request);

            foreach ($request['detail'] as $array) {
                $detail = OrderDetailFacades::saveRepository($array);
                $detail_id = DB::getPdo()->lastInsertId();
                if (isset($array['variant'])) {
                    foreach ($array['variant'] as $variants) {
                        $variants['sales_order_detail_variant_order_id'] = $autonumber;
                        $variants['sales_order_detail_variant_order_detail_id'] = $detail_id;
                        OrderDetailVariantFacades::insert($variants);
                    }
                }
            }

            if ($check && empty(request()->get('sales_order_to_id'))) {

                $name = request()->get('sales_order_to_name');
                $address = request()->get('sales_order_to_address');
                $email = request()->get('sales_order_to_email');
                $phone = request()->get('sales_order_to_phone');
                $area = request()->get('sales_order_to_area');

                if ($customer = CustomerFacades::where('crm_customer_contact_person', $name)->where('crm_customer_contact_email', $email)->first()) {
                    $customer_id = $customer->crm_customer_id;

                } else {

                    if (!empty($name)) {
                        $customer = CustomerFacades::saveRepository([
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
                        $customer_id = DB::getPdo()->lastInsertId();
                    } else {
                        $customer_id = null;
                    }

                }
                $order = OrderFacades::find($request['sales_order_id']);
                $order->sales_order_to_id = $customer_id;
                $order->save();

                Cart::clear();
                Cart::clearCartConditions();
            }

        } catch (\Throwable $th) {
            Alert::error($th->getMessage());
            return $th->getMessage();
        }

        return $check;
    }

    public function update(MasterInterface $repository, $request)
    {
        $id = request()->query('code');
        $check = $repository->updateRepository($id, $request);
        if (!empty($request['detail'])) {
            foreach ($request['detail'] as $item) {
                $where = [
                    'sales_order_detail_order_id' => $item['sales_order_detail_order_id'],
                    OrderDetailFacades::getForeignKey() => $item[OrderDetailFacades::getForeignKey()],
                ];
                OrderDetailFacades::updateOrInsert($where, $item);
            }
            foreach ($request['variant'] as $variant) {
                foreach ($variant as $single) {
                    $data = $single;
                    unset($single['sales_order_detail_variant_qty']);
                    OrderDetailVariantFacades::updateOrInsert($single, $data);
                }
            }
        }

        if ($check['status']) {
            Alert::update();
        } else {
            Alert::error($check['data']);
        }
    }

    public function delivery(MasterInterface $repository, $request)
    {
        $check = false;
        try {
            $check = $repository->saveRepository($request);
            DeliveryDetailFacades::insert($request['detail']);
            Alert::create();
        } catch (\Throwable $th) {
            Alert::error($th->getMessage());
            return $th->getMessage();
        }

        return $check;
    }

    public function updated(MasterInterface $repository, $request)
    {
        $id = request()->query('code');
        $check = $repository->updateRepository($id, $request);
        foreach ($request['detail'] as $item) {
            $where = [
                DeliveryDetailFacades::getKeyName() => $item[DeliveryDetailFacades::getKeyName()],
                DeliveryDetailFacades::getForeignKey() => $item[DeliveryDetailFacades::getForeignKey()],
            ];
            DeliveryDetailFacades::updateOrInsert($where, $item);
        }

        if ($check['status']) {
            Alert::update();
        } else {
            Alert::error($check['data']);
        }
    }

}
