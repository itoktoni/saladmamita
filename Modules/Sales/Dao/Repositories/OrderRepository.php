<?php

namespace Modules\Sales\Dao\Repositories;

use Plugin\Notes;
use Plugin\Helper;
use Illuminate\Support\Facades\DB;
use App\Dao\Facades\CompanyFacades;
use Modules\Sales\Dao\Models\Order;
use App\Dao\Interfaces\MasterInterface;
use Illuminate\Database\QueryException;
use Modules\Sales\Dao\Models\OrderDetail;
use Modules\Crm\Dao\Facades\CustomerFacades;
use Modules\Item\Dao\Facades\ProductFacades;
use Modules\Sales\Dao\Facades\DeliveryDetailFacades;

class OrderRepository extends Order implements MasterInterface
{
    public $data;
    public function dataRepository()
    {
        $list = Helper::dataColumn($this->datatable, $this->getKeyName());
        return $this->select($list)
        ->leftJoin(CustomerFacades::getTable(), CustomerFacades::getKeyName(), 'sales_order_to_id')
        ->leftJoin(CompanyFacades::getTable(), CompanyFacades::getKeyName(), 'sales_order_from_id')
        ->where('sales_order_status', '>', 0);
    }

    public function deliveryRepository($id)
    {
        $list = Helper::dataColumn($this->datatable, $this->getKeyName());
        return $this->select([
                DB::raw('sum(sales_delivery_detail_out) as qty'),
                DB::raw('sum(sales_delivery_detail_discount_value) as discount'),
                DB::raw('sum(sales_delivery_detail_total) as total'),
                'item_product.*',
                'sales_delivery_detail.*'
             ])->leftJoin(DeliveryDetailFacades::getTable(), DeliveryDetailFacades::getOrderKey(), 'sales_order_id')
        ->leftJoin(ProductFacades::getTable(), ProductFacades::getKeyName(), DeliveryDetailFacades::getForeignKey())
        ->where($this->getKeyName(), $id)
        ->groupBy(['sales_delivery_detail_item_product_id','sales_delivery_detail_order_id']);
    }

    public function userRepository($id)
    {
        $list = Helper::dataColumn($this->datatable, 'order.*');
        return $this->dataRepository()->where('sales_order_to_email', $id);
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
}
