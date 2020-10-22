<?php

namespace Modules\Sales\Dao\Repositories;

use App\Dao\Facades\CompanyFacades;
use Plugin\Helper;
use Plugin\Notes;
use Illuminate\Support\Facades\DB;
use Modules\Sales\Dao\Models\Quotation;
use App\Dao\Interfaces\MasterInterface;
use Illuminate\Database\QueryException;
use Modules\Crm\Dao\Facades\CustomerFacades;
use Modules\Sales\Dao\Models\QuotationDetail;

class QuotationRepository extends Quotation implements MasterInterface
{
    public $data;
    public function dataRepository()
    {
        $list = Helper::dataColumn($this->datatable, $this->getKeyName());
        return $this->select($list)
        ->leftJoin(CustomerFacades::getTable(),CustomerFacades::getKeyName(),'sales_quotation_to_id')
        ->leftJoin(CompanyFacades::getTable(),CompanyFacades::getKeyName(),'sales_quotation_from_id');
    }

    public function userRepository($id)
    {
        $list = Helper::dataColumn($this->datatable, $this->getKeyName());
        return $this->select($list)->where('sales_quotation_core_user_id', $id);
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

    public function findRepository($id, $relation = null)
    {
        if ($relation) {
            return $this->with($relation)->find($id);
        }
        return $this->find($id);
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
        $detail = new QuotationDetail();

        try {
            $activity =  $detail->where($detail->getKeyName(), $primary)
        ->where($detail->getForeignKey(), $foreign)->delete();

            $data_total = $detail->where($detail->getKeyName(), $primary);
            $total = $data_total->get()->sum('sales_quotation_detail_total') ?? 0;
            $order = $this->showRepository($primary, false);

            $disc_percent = $order->sales_quotation_discount_percent;
            $disc_value = $disc_percent * $total / 100;
            $sum_discount = $total - $disc_value;
                
            $tax_percent = $order->sales_quotation_tax_percent;
            $tax_value = $tax_percent * $sum_discount / 100;
            $sum_tax =  $sum_discount - $tax_value;

            $sum_total = $sum_tax;

            $activity = $this->$activity = $this->findOrFail($primary)->update([

            'sales_quotation_discount_value' => $disc_value,
            'sales_quotation_tax_value' => $tax_value,
            'sales_quotation_discount_value' => $disc_value,
            'sales_quotation_sum_product' => $total,
            'sales_quotation_sum_discount' => $sum_discount,
            'sales_quotation_sum_tax' => $sum_tax,
            'sales_quotation_sum_total' => $sum_total,
        ]);

            dd($activity);
        
            return Notes::delete($activity);
        } catch (\Illuminate\Database\QueryException $ex) {
            return Notes::error($ex->getMessage());
        }
    }

    public function split($id)
    {
        $query = DB::table($this->getTable())->where('sales_quotation_detail_sales_quotation_id', $id)
            ->select([
                'sales_quotation_detail.*',
                'item_product_id',
                'item_product_name',
                'production_vendor_id',
                'production_vendor_name',
            ])
            ->join('sales_quotation_detail', 'sales_quotation_detail_sales_quotation_id', 'sales_quotation_id')
            ->join('item_product', 'item_product_id', 'sales_quotation_detail_item_product_id')
            ->leftJoin('production_vendor', 'production_vendor_id', 'item_product_production_vendor_id')
            ->groupBy('sales_quotation_detail_sales_quotation_id', 'sales_quotation_detail_item_product_id');

        return $query;
    }

    public function getStatusCreate()
    {
        return $this->statusCreate()->get()->pluck($this->getRouteKeyName(), $this->getRouteKeyName())->prepend('- Select Sales Quotation -', '');
    }
}
