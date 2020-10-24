<?php

namespace Modules\Rajaongkir\Dao\Repositories;

use Plugin\Notes;
use Plugin\Helper;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use App\Dao\Interfaces\MasterInterface;
use Modules\Rajaongkir\Dao\Models\Price;

class PriceRepository extends Price implements MasterInterface
{
    public function dataRepository()
    {
        $list = Helper::dataColumn($this->datatable, $this->getKeyName());
        
        return $this->select([DB::raw('rajaongkir_price.*'), 'finance_top_name', 'rajaongkir_paket_name', DB::raw('from.rajaongkir_area_name as from_name'), DB::raw('from.rajaongkir_area_city_name as from_city'), DB::raw('to.rajaongkir_area_city_name as to_city'), DB::raw('to.rajaongkir_area_name as to_name'), DB::raw('to.rajaongkir_area_postcode as postcode')])
        ->leftJoin('finance_top', 'finance_top_code', '=', 'rajaongkir_price_top')
        ->leftJoin('rajaongkir_paket', 'rajaongkir_paket_code', '=', 'rajaongkir_price_paket')
        ->leftJoin('rajaongkir_areas as from', DB::raw('from.rajaongkir_area_id'), '=', 'rajaongkir_price_from')
        ->leftJoin('rajaongkir_areas as to', DB::raw('to.rajaongkir_area_id'), '=', 'rajaongkir_price_to');
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
        } catch (QueryExceptionAlias $ex) {
            return Notes::error($ex->getMessage());
        }
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

    public function showRepository($id, $relation = false)
    {
        if ($relation) {
            return $this->with($relation)->findOrFail($id);
        }
        return $this->findOrFail($id);
    }

    public function getDataIn($in)
    {
        return $this->whereIn($this->getKeyName(), $in)->get();
    }
}
