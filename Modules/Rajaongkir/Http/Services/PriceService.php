<?php

namespace Modules\Rajaongkir\Http\Services;

use Plugin\Alert;
use Plugin\Helper;
use App\Http\Services\MasterService;
use App\Dao\Interfaces\MasterInterface;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class PriceService extends MasterService
{
    public function save(MasterInterface $repository, $request)
    {
        $check = false;
        try {
            $check = $repository->insertOrIgnore($request);
            Alert::create();
        } catch (\Throwable $th) {
            Alert::error($th->getMessage());
            return $th->getMessage();
        }

        return $check;
    }

    public function update(MasterInterface $repository, $request)
    {
        $master = $request;
        $data = collect($request);
        $where = $data->pull('rajaongkir_price_value');
        foreach ($request as $value) {
            $harga = $value['rajaongkir_price_value'];
            unset($value['rajaongkir_price_value']);
            $check = $repository->updateOrInsert($value, ['rajaongkir_price_value' => $harga]);
        }
        
        Alert::update();
    }
}
