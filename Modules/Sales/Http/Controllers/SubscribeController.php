<?php

namespace Modules\Sales\Http\Controllers;

use Plugin\Helper;
use Plugin\Response;
use Barryvdh\DomPDF\Facade as PDF;
use App\Http\Controllers\Controller;
use App\Http\Services\MasterService;
use App\Http\Requests\GeneralRequest;
use App\Dao\Repositories\BranchRepository;
use App\Dao\Repositories\CompanyRepository;
use Modules\Finance\Dao\Facades\BankFacades;
use Modules\Sales\Dao\Models\OrderSubscribe;
use Modules\Sales\Http\Requests\OrderRequest;
use Modules\Sales\Http\Services\OrderService;
use Modules\Sales\Dao\Facades\SubscribeFacades;
use Modules\Sales\Http\Requests\SubscribeRequest;
use Modules\Finance\Dao\Repositories\TaxRepository;
use Modules\Finance\Dao\Repositories\TopRepository;
use Modules\Sales\Dao\Repositories\OrderRepository;
use Modules\Crm\Dao\Repositories\CustomerRepository;
use Modules\Finance\Dao\Repositories\BankRepository;
use Modules\Item\Dao\Repositories\ProductRepository;
use Modules\Item\Dao\Repositories\VariantRepository;
use Modules\Finance\Dao\Repositories\PaymentRepository;
use Modules\Marketing\Dao\Repositories\PromoRepository;
use Modules\Sales\Dao\Repositories\SubscribeRepository;
use Modules\Rajaongkir\Dao\Repositories\DeliveryRepository;

class SubscribeController extends Controller
{
    public $template;
    public static $model;
    public static $delivery;
    public $folder;

    public function __construct()
    {
        if (self::$model == null) {
            self::$model = new SubscribeRepository();
            self::$delivery = new OrderRepository();
        }
        $this->template  = Helper::getTemplate(__CLASS__);
        $this->folder = 'sales';
    }

    public function index()
    {
        return redirect()->route($this->getModule() . '_data');
    }

    private function share($data = [])
    {
        $tops = Helper::shareOption((new TopRepository()));
        $product = Helper::shareOption((new ProductRepository()));
        $variant = Helper::shareOption((new VariantRepository()));
        $tax = Helper::shareOption((new TaxRepository()));
        $promo = Helper::shareOption((new PromoRepository()));
        $branch = Helper::shareOption((new BranchRepository()));
        $bank = Helper::shareOption((new BankRepository()));
        $customers = Helper::shareOption((new CustomerRepository()));
        $delivery = Helper::shareOption((new DeliveryRepository()));
        $status = Helper::shareStatus(self::$model->status);

        $from = $to = ['Please Choose Area'];

        $view = [
            'key' => self::$model->getKeyName(),
            'template' => $this->template,
            'tax' => $tax,
            'tops' => $tops,
            'product' => $product,
            'delivery' => $delivery,
            'variant' => $variant,
            'status' => $status,
            'promo' => $promo,
            'from' => $from,
            'to' => $to,
            'branch' => $branch,
            'bank' => $bank,
            'customers' => $customers,
        ];

        return array_merge($view, $data);
    }

    public function update(MasterService $service, GeneralRequest $request)
    {
        if (request()->isMethod('POST')) {
            $data = $service->update(self::$model, $request->all());
            
            return Response::redirectBack($data);
        }

        $data = $service->show(self::$model);
        $from = Helper::getSingleArea($data->sales_langganan_from_area);
        $to = Helper::getSingleArea($data->sales_langganan_to_area);

        return view(Helper::setViewUpdate())->with($this->share([
            'model'        => $data,
            'from'        => $from,
            'to'        => $to,
            'detail' => $data->order,
        ]));
    }

    public function delete(MasterService $service)
    {
        if (request()->has('code') && request()->has('detail')) {
            $code = request()->get('code');
            $detail = request()->get('detail');
            self::$model->deleteDetailRepository($code, $detail);
        }

        $service->delete(self::$model);
        return Response::redirectBack();
    }

    public function data(MasterService $service)
    {
        if (request()->isMethod('POST')) {
            $datatable = $service->setRaw(['sales_langganan_status'])->datatable(self::$model);
            $datatable->editColumn('sales_langganan_status', function ($select) {
                return Helper::createStatus([
                    'value'  => $select->sales_langganan_status,
                    'status' => self::$model->status,
                ]);
            });

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
        $field = Helper::listData(self::$model->datatable);
        unset($field['sales_langganan_status']);
        unset($field['rajaongkir_paket_name']);
        unset($field['finance_top_name']);
        return view(Helper::setViewShow())->with($this->share([
            'fields' => $field,
            'model'   => $data,
            'key'   => self::$model->getKeyName()
        ]));
    }

    public function print_do(MasterService $service)
    {
        if (request()->has('code')) {
            $data = $service->show(self::$model, ['detail', 'company']);
            $id = request()->get('code');
            $pasing = [
                'master' => $data,
                'detail' => $data->detail,
            ];
            $pdf = PDF::loadView(Helper::setViewPrint(__FUNCTION__, $this->folder), $pasing);
            return $pdf->download();
            // return $pdf->stream();
        }
    }

    public function print_invoice(MasterService $service)
    {
        if (request()->has('code')) {
            $data = $service->show(self::$model, ['detail', 'company']);
            $id = request()->get('code');
            
            $pasing = [
                'master' => $data,
                'detail' => $data->detail,
                'banks'   => BankFacades::dataRepository()->get(),
            ];
            $pdf = PDF::loadView(Helper::setViewPrint(__FUNCTION__, $this->folder), $pasing);
            return $pdf->download();
            // return $pdf->stream();
        }
    }
}