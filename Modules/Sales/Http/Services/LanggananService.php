<?php

namespace Modules\Sales\Http\Services;

use App\Dao\Facades\BranchFacades;
use App\Dao\Interfaces\MasterInterface;
use App\Http\Services\MasterService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Modules\Crm\Dao\Facades\CustomerFacades;
use Modules\Sales\Dao\Facades\DeliveryDetailFacades;
use Modules\Sales\Dao\Facades\OrderDetailFacades;
use Modules\Sales\Dao\Facades\OrderDetailVariantFacades;
use Modules\Sales\Dao\Facades\OrderFacades;
use Modules\Sales\Dao\Facades\SubscribeFacades;
use Modules\Sales\Dao\Repositories\OrderRepository;
use Plugin\Alert;
use Plugin\Helper;

class LanggananService extends MasterService
{
    public function save(MasterInterface $repository, $request)
    {
        $check = false;
        try {
            $autonumber = Helper::autoNumber(SubscribeFacades::getTable(), SubscribeFacades::getKeyName(), 'SB' . date('Ym'), config('website.autonumber'));
            $request['sales_langganan_id'] = $autonumber;
            $request['sales_langganan_status'] = 1;
            $request['sales_langganan_token'] = Str::uuid();

            $branch = BranchFacades::find($request['sales_langganan_from_id']);

            $request['sales_langganan_from_name'] = $branch->branch_name;
            $request['sales_langganan_from_name'] = $branch->branch_name;
            $request['sales_langganan_from_phone'] = $branch->branch_phone;
            $request['sales_langganan_from_email'] = $branch->branch_email;
            $request['sales_langganan_from_address'] = $branch->branch_address;
            $request['sales_langganan_from_area'] = $branch->branch_rajaongkir_area_id;

            $customer_id = null;
            $name = request()->get('sales_langganan_to_name');
            $address = request()->get('sales_langganan_to_address');
            $email = request()->get('sales_langganan_to_email');
            $phone = request()->get('sales_langganan_to_phone');
            $area = request()->get('sales_langganan_to_area');

            if ($customer = CustomerFacades::where('crm_customer_contact_person', $name)->where('crm_customer_contact_phone', $phone)->first()) {
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
            $check = $repository->saveRepository($request);
            foreach ($request['detail'] as $order) {

                $order_id = Helper::autoNumber(OrderFacades::getTable(), OrderFacades::getKeyName(), 'SO' . date('Ym'), config('website.autonumber'));
                $order['sales_order_id'] = $order_id;
                $order['sales_order_status'] = 1;
                $order['sales_order_date_order'] = $order['langganan_date'];
                $order['sales_langganan_date_email'] = date('Y-m-d H:i:s');
                $order['sales_order_code_reference'] = $autonumber;

                $order['sales_order_from_id'] = $branch->branch_id;
                $order['sales_order_from_name'] = $branch->branch_name;
                $order['sales_order_from_phone'] = $branch->branch_phone;
                $order['sales_order_from_email'] = $branch->branch_email;
                $order['sales_order_from_address'] = $branch->branch_address;
                $order['sales_order_from_area'] = $branch->branch_rajaongkir_area_id;

                $order['sales_order_to_id'] = $customer_id;
                $order['sales_order_to_name'] = $request['sales_langganan_to_name'];
                $order['sales_order_to_email'] = $request['sales_langganan_to_email'];
                $order['sales_order_to_phone'] = $request['sales_langganan_to_phone'];
                $order['sales_order_to_address'] = $request['sales_langganan_to_address'];
                $order['sales_order_to_area'] = $request['sales_langganan_to_area'];

                $orderFacase = new OrderRepository();
                $orderFacase->saveRepository($order);

                foreach ($order['product'] as $detail) {

                    if (isset($detail['variant'])) {
                        $quantity = collect($detail['variant'])->map(function ($item) {
                            return $item['sales_order_detail_variant_qty'] ? intval($item['sales_order_detail_variant_qty']) : 0;
                        })->sum();
                    } else {
                        $quantity = intval($detail['sales_order_detail_qty']);
                    }

                    if ($quantity > 0) {

                        $price = $detail['sales_order_detail_price'];
                        $total = $quantity * $price;
                        $detail['sales_order_detail_order_id'] = $order_id;
                        $detail['sales_order_detail_qty'] = $quantity;
                        $detail['sales_order_detail_total'] = $total;
                        OrderDetailFacades::saveRepository($detail);

                        $detail_id = DB::getPdo()->lastInsertId();
                        if (isset($detail['variant'])) {
                            foreach ($detail['variant'] as $variants) {
                                $variants['sales_order_detail_variant_order_id'] = $order_id;
                                $variants['sales_order_detail_variant_item_product_id'] = $detail['sales_order_detail_item_product_id'];
                                $variants['sales_order_detail_variant_order_detail_id'] = $detail_id;
                                OrderDetailVariantFacades::insert($variants);
                            }
                        }
                    }
                }

                $ord = OrderFacades::find($order_id);
                $sub_ord = $ord->detail->sum('sales_order_detail_total');
                $ord->sales_order_sum_product = $sub_ord;
                $ord->sales_order_sum_total = $sub_ord;
                $ord->save();
            }

            $lang = SubscribeFacades::find($autonumber);
            $sum_lang = $lang->order->sum('sales_order_sum_total');
            $lang->sales_langganan_sum_product = $sum_lang;
            $lang->sales_langganan_sum_total = $sum_lang;
            $lang->save();

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
                    'sales_langganan_detail_order_id' => $item['sales_langganan_detail_order_id'],
                    OrderDetailFacades::getForeignKey() => $item[OrderDetailFacades::getForeignKey()],
                ];
                OrderDetailFacades::updateOrInsert($where, $item);
            }
            foreach ($request['variant'] as $variant) {
                foreach ($variant as $single) {
                    $data = $single;
                    unset($single['sales_langganan_detail_variant_qty']);
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
