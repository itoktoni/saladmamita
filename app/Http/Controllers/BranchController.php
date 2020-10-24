<?php

namespace App\Http\Controllers;

use Plugin\Helper;
use Plugin\Response;
use Illuminate\Http\Request;
use App\Http\Services\MasterService;
use App\Http\Requests\GeneralRequest;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use App\Dao\Repositories\BranchRepository;
use App\Dao\Repositories\CompanyRepository;
use App\Dao\Repositories\GroupUserRepository;
use Modules\Rajaongkir\Dao\Repositories\AreaRepository;

class BranchController extends Controller
{
    public $template;
    public static $model;

    public function __construct()
    {
        if (self::$model == null) {
            self::$model = new BranchRepository();
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
        $company = Helper::shareOption((new CompanyRepository()));

        $area = ['Please Choose Area'];
        $view = [
            'key'      => self::$model->getKeyName(),
            'template' => $this->template,
            'status' => $status,
            'group' => $group,
            'area' => $area,
            'company' => $company,
        ];

        return array_merge($view, $data);
    }

    public function create(MasterService $service, GeneralRequest $request)
    {
        if (request()->isMethod('POST')) {
            // dd($request->all());
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
        $data = $service->show(self::$model,['area']);
        return view(Helper::setViewUpdate())->with($this->share([
            'model'        => $data,
            'area'  => Helper::getSingleArea($data->branch_rajaongkir_area_id),
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
        $data = $service->show(self::$model);
        return view(Helper::setViewShow())->with($this->share([
            'fields' => Helper::listData(self::$model->datatable),
            'model'   => $data,
            'key'   => self::$model->getKeyName()
        ]));
    }
}
