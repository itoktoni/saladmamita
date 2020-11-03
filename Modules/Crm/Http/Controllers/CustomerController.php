<?php

namespace Modules\Crm\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\GeneralRequest;
use App\Http\Services\MasterService;
use Modules\Crm\Dao\Repositories\CustomerRepository;
use Plugin\Helper;
use Plugin\Response;

class CustomerController extends Controller
{
    public $template;
    public static $model;

    public function __construct()
    {
        if (self::$model == null) {
            self::$model = new CustomerRepository();
        }
        $this->template = Helper::getTemplate(__CLASS__);
    }

    public function index()
    {
        return redirect()->route($this->getModule() . '_data');
    }

    private function share($data = [])
    {
        $area_contact = $area_delivery = $area_invoice = ['Please Choose Area'];
        $view = [
            'template' => $this->template,
            'area_contact' => $area_contact,
            'area_delivery' => $area_delivery,
            'area_invoice' => $area_invoice,
        ];

        return array_merge($view, $data);
    }

    public function create(MasterService $service, GeneralRequest $request)
    {
        if (request()->isMethod('POST')) {
            $service->save(self::$model, $request->all());
        }
        return view(Helper::setViewCreate())->with($this->share());
    }

    public function update(MasterService $service, GeneralRequest $request)
    {
        if (request()->isMethod('POST')) {
            $service->update(self::$model, $request->all());
            return redirect()->route($this->getModule() . '_data');
        }

        if (request()->has('code')) {
            $data = $service->show(self::$model);
            return view(Helper::setViewUpdate())->with($this->share([
                'model' => $data,
                'key' => self::$model->getKeyName(),
                'area_contact' => Helper::getSingleArea($data->crm_customer_contact_rajaongkir_area_id),
                'area_delivery' => Helper::getSingleArea($data->crm_customer_delivery_rajaongkir_area_id),
                'area_invoice' => Helper::getSingleArea($data->crm_customer_invoice_rajaongkir_area_id),
            ]));
        }
    }

    public function delete(MasterService $service)
    {
        $service->delete(self::$model);
        return Response::redirectBack();

    }

    public function data(MasterService $service)
    {
        if (request()->isMethod('POST')) {
            return $service->datatable(self::$model)->make(true);
        }

        return view(Helper::setViewData())->with([
            'fields' => Helper::listData(self::$model->datatable),
            'template' => $this->template,
        ]);
    }

    public function show(MasterService $service)
    {
        if (request()->has('code')) {
            $data = $service->show(self::$model);
            return view(Helper::setViewShow())->with($this->share([
                'fields' => Helper::listData(self::$model->datatable),
                'model' => $data,
                'key' => self::$model->getKeyName(),
            ]));
        }
    }
}
