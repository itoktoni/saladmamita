<?php

namespace Modules\Sales\Dao\Repositories;

use App\User;
use Plugin\Notes;
use Plugin\Helper;
use Illuminate\Support\Facades\DB;
use Modules\Sales\Dao\Models\Order;
use Modules\Crm\Dao\Models\Customer;
use App\Dao\Interfaces\MasterInterface;
use Illuminate\Database\QueryException;
use Modules\Forwarder\Dao\Models\Vendor;
use Modules\Sales\Dao\Models\OrderDetail;
use Modules\Sales\Dao\Models\DeliveryDetail;

class DeliveryDetailRepository extends DeliveryDetail implements MasterInterface
{
    public $data;
    public static $customer;
    public static $vendor;

    public function dataRepository()
    {
        if (self::$customer == null) {
            self::$customer = new User();
        }
        if (self::$vendor == null) {
            self::$vendor = new Vendor();
        }

        $list = Helper::dataColumn($this->datatable, $this->getKeyName());
        return $this->select($list);
    }

    public function userRepository($id)
    {
        $list = Helper::dataColumn($this->datatable, $this->getKeyName());
        return $this->select($list)->where('sales_order_core_user_id', $id);
    }

    public function saveRepository($request)
    {
        try {
            $activity = $this->create($request);
            return Notes::create($activity);
        } catch (\Illuminate\Database\QueryException $ex) {
            return Notes::error($ex->getMessage());
        }
    }

    public function updateRepository($id, $request)
    {
        try {
            $activity = $this->findOrFail($id)->update($request);
            return Notes::update($activity);
        } catch (QueryException $ex) {
            return Notes::error($ex->getMessage());
        }
    }

    public function showRepository($id, $relation = null)
    {
        if ($relation) {
            return $this->with($relation)->findOrFail($id);
        }
        return $this->findOrFail($id);
    }

    public function deleteRepository($data)
    {
        try {
            $activity = $this->Destroy(array_values($data));
            return Notes::delete($activity);
        } catch (\Illuminate\Database\QueryException $ex) {
            return Notes::error($ex->getMessage());
        }
    }

    public function deleteDetailRepository($primary, $foreign)
    {
        $detail = new OrderDetail();

        try {
            $activity =  $detail->where($detail->getKeyName(), $primary)
        ->where($detail->getForeignKey(), $foreign)->delete();

            $data_total = $detail->where($detail->getKeyName(), $primary);
            $total = $data_total->get()->sum('sales_order_detail_order_total') ?? 0;
            $order = $this->showRepository($primary, false);

            $disc_percent = $order->sales_order_discount_percent;
            $disc_value = $disc_percent * $total / 100;
            $sum_discount = $total - $disc_value;
                
            $tax_percent = $order->sales_order_tax_percent;
            $tax_value = $tax_percent * $sum_discount / 100;
            $sum_tax =  $sum_discount - $tax_value;

            $sum_total = $sum_tax;

            $activity = $this->$activity = $this->findOrFail($primary)->update([

            'sales_order_discount_value' => $disc_value,
            'sales_order_tax_value' => $tax_value,
            'sales_order_discount_value' => $disc_value,
            'sales_order_sum_product' => $total,
            'sales_order_sum_discount' => $sum_discount,
            'sales_order_sum_tax' => $sum_tax,
            'sales_order_sum_total' => $sum_total,
        ]);

            dd($activity);
        
            return Notes::delete($activity);
        } catch (\Illuminate\Database\QueryException $ex) {
            return Notes::error($ex->getMessage());
        }
    }

    public function split($id)
    {
        $query = DB::table($this->getTable())->where('sales_order_detail_sales_order_id', $id)
            ->select([
                'sales_order_detail.*',
                'item_product_id',
                'item_product_name',
                'production_vendor_id',
                'production_vendor_name',
            ])
            ->join('sales_order_detail', 'sales_order_detail_sales_order_id', 'sales_order_id')
            ->join('item_product', 'item_product_id', 'sales_order_detail_item_product_id')
            ->leftJoin('production_vendor', 'production_vendor_id', 'item_product_production_vendor_id')
            ->groupBy('sales_order_detail_sales_order_id', 'sales_order_detail_item_product_id');

        return $query;
    }

    public function getStatusCreate()
    {
        return $this->statusCreate()->get()->pluck($this->getRouteKeyName(), $this->getRouteKeyName())->prepend('- Select Sales Order -', '');
    }
}
