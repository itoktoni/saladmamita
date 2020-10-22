<?php

namespace Modules\Rajaongkir\Http\Controllers;

use Plugin\Helper;
use Plugin\Response;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Services\MasterService;
use App\Http\Requests\GeneralRequest;
use Modules\Rajaongkir\Dao\Repositories\AreaRepository;
use Modules\Rajaongkir\Dao\Repositories\CityRepository;
use Modules\Rajaongkir\Dao\Repositories\ProvinceRepository;

class AreaController extends Controller
{
    public $template;
    public static $model;

    public function __construct()
    {
        if (self::$model == null) {
            self::$model = new AreaRepository();
        }
        $this->template  = Helper::getTemplate(__CLASS__);
    }

    public function index()
    {
        return redirect()->route($this->getModule() . '_data');
    }

    private function share($data = [])
    {
        $cities = Helper::shareOption((new CityRepository()),false, true,false);
        $data_city = $cities->mapWithKeys(function($item){
            return [$item['rajaongkir_city_id'] => $item['rajaongkir_city_province_name'].' - '.$item['rajaongkir_city_name']];
        });
        $view = [
            'key'      => self::$model->getKeyName(),
            'template' => $this->template,
            'cities' => $data_city,
        ];

        return array_merge($view, $data);
    }

    public function create(MasterService $service, GeneralRequest $request)
    {
        if (request()->isMethod('POST')) {
            $data = $service->save(self::$model, $request->all());
            return Response::redirectBack($data);
        }
        return view(Helper::setViewCreate())->with($this->share());
    }

    public function update(MasterService $service, GeneralRequest $request)
    {
        if (request()->isMethod('POST')) {
            $data = $service->update(self::$model, $request->all());
            return Response::redirectBack($data);
        }
        $data = $service->show(self::$model);
        return view(Helper::setViewUpdate())->with($this->share([
            'model'        => $data,
        ]));
    }

    public function delete(MasterService $service)
    {
        $service->delete(self::$model);
        return Response::redirectBack();
    }

    public function data(MasterService $service)
    {
        if (request()->isMethod('POST')) {
            $datatable = $service->datatable(self::$model);
            return $datatable->make(true);
        }

        return view(Helper::setViewData())->with([
            'fields'   => Helper::listData(self::$model->datatable),
            'template' => $this->template,
        ]);
    }

    public function show(MasterService $service)
    {
        $data = $service->show(self::$model);
        return view(Helper::setViewShow())->with($this->share([
            'fields' => Helper::listData(self::$model->datatable),
            'model'   => $data,
            'key'   => self::$model->getKeyName()
        ]));
    }

    public function popup(MasterService $service)
    {
        if (request()->isMethod('POST')) {
            $datatable = $service->datatable(self::$model)->addColumn('action', function($model){
                $data = '\''.$model->rajaongkir_area_name.' - '.$model->rajaongkir_area_type.' '.$model->rajaongkir_area_city_name.' - '.$model->rajaongkir_area_province_name.'\'';
                return '<h6 class="btn btn-primary btn-xs btn-block text-center" onclick="setID('.$model->rajaongkir_area_id.','.$data.');">Select</h6>';
            });

            return $datatable->make(true);
        }

        return view(Helper::setViewPopup())->with([
            'fields'   => Helper::listData(self::$model->datatable),
            'template' => $this->template,
        ]);
    }
}
