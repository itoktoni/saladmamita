<?php

namespace Modules\Sales\Http\Controllers;

use PDF;
use Plugin\Helper;
use Plugin\Response;
use Barryvdh\DomPDF\Facade;
use Barryvdh\DomPDF\PdfFacade;
use App\Http\Controllers\Controller;
use App\Http\Services\MasterService;
use App\Dao\Repositories\CompanyRepository;
use Modules\Sales\Dao\Models\OrderDelivery;
use Modules\Finance\Dao\Facades\BankFacades;
use Modules\Sales\Http\Requests\OrderRequest;
use Modules\Sales\Http\Services\OrderService;
use Modules\Sales\Dao\Facades\DeliveryFacades;
use Modules\Sales\Http\Requests\DeliveryRequest;
use Modules\Finance\Dao\Repositories\TaxRepository;
use Modules\Finance\Dao\Repositories\TopRepository;
use Modules\Sales\Dao\Repositories\OrderRepository;
use Modules\Crm\Dao\Repositories\CustomerRepository;
use Modules\Item\Dao\Repositories\ProductRepository;
use Modules\Sales\Dao\Repositories\DeliveryRepository;
use Modules\Finance\Dao\Repositories\PaymentRepository;
use Modules\Marketing\Dao\Repositories\PromoRepository;

class OrderController extends Controller
{
    public $template;
    public static $model;
    public static $delivery;
    public $folder;

    public function __construct()
    {
        if (self::$model == null) {
            self::$model = new OrderRepository();
            self::$delivery = new DeliveryRepository();
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
        $tax = Helper::shareOption((new TaxRepository()));
        $promo = Helper::shareOption((new PromoRepository()));
        $company = Helper::shareOption((new CompanyRepository()));
        $customers = Helper::shareOption((new CustomerRepository()));
        $status = Helper::shareStatus(self::$model->status);

        $from = $to = ['Please Choose Area'];
        
        $view = [
            'key'      => self::$model->getKeyName(),
            'template' => $this->template,
            'tax' => $tax,
            'tops' => $tops,
            'product' => $product,
            'status' => $status,
            'promo' => $promo,
            'from' => $from,
            'to' => $to,
            'company' => $company,
            'customers' => $customers,
        ];

        return array_merge($view, $data);
    }

    public function create(OrderService $service, OrderRequest $request)
    {
        if (request()->isMethod('POST')) {
            $data = $service->save(self::$model, $request->all());
            return Response::redirectBack($data);
        }
        return view(Helper::setViewSave($this->template, $this->folder))->with($this->share([
            'model' => self::$model,
        ]));
    }

    public function update(OrderService $service, OrderRequest $request)
    {
        if (request()->isMethod('POST')) {
            $data = $service->update(self::$model, $request->all());
            $data = $request->all();
            return Response::redirectBack($data);
        }

        $data = $service->show(self::$model);
        $from = Helper::getSingleArea($data->sales_order_from_area);
        $to = Helper::getSingleArea($data->sales_order_to_area);

        return view(Helper::setViewSave($this->template, $this->folder))->with($this->share([
            'model'        => $data,
            'from'        => $from,
            'to'        => $to,
            'detail' => $data->detail,
        ]));
    }

    public function delivery(OrderService $service, DeliveryRequest $request)
    {
        if (request()->isMethod('POST')) {
            $data = $service->delivery(self::$delivery, $request->all());
            return Response::redirectBack($data);
        }

        $data = $service->show(self::$model);
        $from = Helper::getSingleArea($data->company->company_delivery_rajaongkir_area_id ?? '');
        $to = Helper::getSingleArea($data->customer->crm_customer_delivery_rajaongkir_area_id);

        return view(Helper::setViewForm($this->template, __FUNCTION__, $this->folder))->with($this->share([
            'model'        => $data,
            'from'        => $from,
            'to'        => $to,
            'detail' => $data->detail,
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
            $datatable = $service->setRaw(['sales_order_status'])->datatable(self::$model);
            $datatable->editColumn('sales_order_status', function ($select) {
                return Helper::createStatus([
                    'value'  => $select->sales_order_status,
                    'status' => self::$model->status,
                ]);
            });
            $datatable->addColumn('action', Helper::setViewAction($this->template, $this->folder));

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
        unset($field['sales_order_status']);
        unset($field['rajaongkir_paket_name']);
        unset($field['finance_top_name']);
        $payment = PaymentRepository::where('finance_payment_sales_order_id', $data->sales_order_id)->get();
        return view(Helper::setViewShow())->with($this->share([
            'fields' => $field,
            'payment'   => $payment,
            'model'   => $data,
            'key'   => self::$model->getKeyName()
        ]));
    }

    public function print_order(MasterService $service)
    {
        if (request()->has('code')) {
            $data = $service->show(self::$model, ['delivery', 'company']);
            $id = request()->get('code');
            // dd($data->deliveryRepository($id)->get());
            $pasing = [
                'master' => $data,
                'detail' => $data->deliveryRepository($id)->get(),
                'banks'   => BankFacades::dataRepository()->get(),
            ];
            $pdf = PdfFacade::loadView(Helper::setViewPrint(__FUNCTION__, $this->folder), $pasing);
            return $pdf->download();
            // return $pdf->stream();
        }
    }
}
