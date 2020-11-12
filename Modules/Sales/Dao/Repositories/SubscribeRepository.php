<?php

namespace Modules\Sales\Dao\Repositories;

use Plugin\Notes;
use Plugin\Helper;
use Illuminate\Support\Facades\DB;
use App\Dao\Facades\CompanyFacades;
use Modules\Sales\Dao\Models\Order;
use App\Dao\Interfaces\MasterInterface;
use Illuminate\Database\QueryException;
use Modules\Sales\Dao\Models\Subscribe;
use Modules\Sales\Dao\Models\OrderDetail;
use Modules\Crm\Dao\Facades\CustomerFacades;
use Modules\Item\Dao\Facades\ProductFacades;
use Modules\Sales\Dao\Facades\DeliveryDetailFacades;

class SubscribeRepository extends Subscribe implements MasterInterface
{
    public $data;
    public function dataRepository()
    {
        $list = Helper::dataColumn($this->datatable, $this->getKeyName());
        return $this->select($list);
    }

    public function userRepository($id)
    {
        $list = Helper::dataColumn($this->datatable, 'order.*');
        return $this->dataRepository()->where('sales_langganan_to_email', $id);
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
