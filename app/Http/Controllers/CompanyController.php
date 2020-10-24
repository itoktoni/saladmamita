<?php

namespace App\Http\Controllers;

use Plugin\Helper;
use Plugin\Response;
use App\Http\Services\MasterService;
use App\Http\Requests\GeneralRequest;
use App\Dao\Repositories\CompanyRepository;
use App\Dao\Repositories\GroupUserRepository;
use Modules\Rajaongkir\Dao\Repositories\AreaRepository;

class CompanyController extends Controller
{
    public $template;
    public static $model;

    public function __construct()
    {
        if (self::$model == null) {
            self::$model = new CompanyRepository();
        }
        $this->template  = Helper::getTemplate(__CLASS__);
    }

    public function index()
    {
        return redirect()->route($this->getModule() . '_data');
    }

    private function share($data = [])
    {
        $status = Helper::shareStatus(self::$model->status)->prepend('- Select Status -', '');
        $group = Helper::shareOption((new GroupUserRepository()));
        $branch = Helper::shareOption((self::$model));
        $area_contact = $area_delivery = $area_invoice = ['Please Choose Area'];

        $view = [
            'key'      => self::$model->getKeyName(),
            'template' => $this->template,
            'status' => $status,
            'area_contact' => $area_contact,
            'area_delivery' => $area_delivery,
            'area_invoice' => $area_invoice,
            'group' => $group,
            'branch' => $branch,
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
            'model'         => $data,
            'area_contact'  => Helper::getSingleArea($data->company_contact_rajaongkir_area_id),
            'area_delivery' => Helper::getSingleArea($data->company_delivery_rajaongkir_area_id),
            'area_invoice'  => Helper::getSingleArea($data->company_invoice_rajaongkir_area_id),
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
            $datatable = $service->setRaw(
                [
                    'active' => Helper::setViewForm('master', 'active'),
                ]
            )->datatable(self::$model);
            return $datatable->make(true);
        }

        return view(Helper::setViewData())->with([
            'fields'   => Helper::listData(self::$model->datatable),
            'template' => $this->template,
        ]);
    }

    public function show(MasterService $service)
    {
        $data = $service->show(self::$model, null);
        return view(Helper::setViewShow())->with($this->share([
            'fields' => Helper::listData(self::$model->datatable),
            'model'   => $data,
            'key'   => self::$model->getKeyName()
        ]));
    }
}
