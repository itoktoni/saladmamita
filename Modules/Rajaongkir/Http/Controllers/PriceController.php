<?php

namespace Modules\Rajaongkir\Http\Controllers;

use Plugin\Helper;
use Plugin\Response;
use App\Http\Controllers\Controller;
use App\Http\Services\MasterService;
use App\Http\Requests\GeneralRequest;
use Modules\Rajaongkir\Http\Services\PriceService;
use Modules\Finance\Dao\Repositories\TopRepository;
use Modules\Rajaongkir\Dao\Repositories\AreaRepository;
use Modules\Rajaongkir\Dao\Repositories\CityRepository;
use Modules\Rajaongkir\Dao\Repositories\PaketRepository;
use Modules\Rajaongkir\Dao\Repositories\PriceRepository;
use Modules\Rajaongkir\Http\Requests\PriceCreateRequest;

class PriceController extends Controller
{
    public $template;
    public static $model;
    public $folder;

    public function __construct()
    {
        if (self::$model == null) {
            self::$model = new PriceRepository();
        }
        $this->template  = Helper::getTemplate(__CLASS__);
        $this->folder = 'rajaongkir';

    }

    public function index()
    {
        return redirect()->route($this->getModule() . '_data');
    }

    private function share($data = [])
    {
        $tops = Helper::shareOption((new TopRepository()), false);
        $paket = Helper::shareOption((new PaketRepository()), false);
        $view = [
            'key'      => self::$model->getKeyName(),
            'template' => $this->template,
            'tops' => $tops,
            'paket' => $paket,
        ];
        return array_merge($view, $data);
    }
    
    public function create(PriceService $service, PriceCreateRequest $request)
    {
        if (request()->isMethod('POST')) {
            $metode = request()->get('metode');
            if ($metode == 'save') {
                $data = $service->save(self::$model, $request->get('data'));
            } else {
                $data = $service->update(self::$model, $request->get('data'));
            }
            return Response::redirectBack($data);
        }

        $cities = Helper::shareOption((new CityRepository()), false, true, false);
        $data_city = $cities->mapWithKeys(function ($item) {
            return [$item['rajaongkir_city_id'] => $item['rajaongkir_city_province_name'].' - '.$item['rajaongkir_city_name']];
        })->prepend('- Pilih salah satu -', '');

        return view(Helper::setViewCreate())->with($this->share([
            'cities' => $data_city,
        ]));
    }

    public function update(MasterService $service, GeneralRequest $request)
    {
        if (request()->isMethod('POST')) {
            $data = $service->update(self::$model, $request->all());
            return Response::redirectBack($data);
        }

        $area = Helper::shareOption((new AreaRepository()), false, true, false);
        $data_area = $area->mapWithKeys(function ($item) {
            return [$item['rajaongkir_area_id'] => $item['rajaongkir_area_province_name'].' - '.$item['rajaongkir_area_city_name'].' - '.$item['rajaongkir_area_name'].' - '.$item['rajaongkir_area_postcode']];
        });

        $data = $service->show(self::$model);
        return view(Helper::setViewUpdate($this->template, $this->folder))->with($this->share([
            'model'        => $data,
            'area' => $data_area,
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
}
