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
use Modules\Sales\Http\Requests\OrderRequest;
use Modules\Sales\Dao\Facades\DeliveryFacades;
use Modules\Sales\Dao\Models\QuotationDelivery;
use Modules\Sales\Http\Requests\DeliveryRequest;
use Modules\Sales\Http\Requests\QuotationRequest;
use Modules\Sales\Http\Services\QuotationService;
use Modules\Finance\Dao\Repositories\TaxRepository;
use Modules\Finance\Dao\Repositories\TopRepository;
use Modules\Sales\Dao\Repositories\OrderRepository;
use Modules\Crm\Dao\Repositories\CustomerRepository;
use Modules\Item\Dao\Repositories\ProductRepository;
use Modules\Sales\Dao\Repositories\DeliveryRepository;
use Modules\Finance\Dao\Repositories\PaymentRepository;
use Modules\Marketing\Dao\Repositories\PromoRepository;
use Modules\Sales\Dao\Repositories\QuotationRepository;
use Modules\Sales\Http\Services\OrderService;

class QuotationController extends Controller
{
    public $template;
    public static $model;
    public static $order;
    public $folder;

    public function __construct()
    {
        if (self::$model == null) {
            self::$model = new QuotationRepository();
            self::$order = new OrderRepository();
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

    public function create(QuotationService $service, QuotationRequest $request)
    {
        if (request()->isMethod('POST')) {
            $data = $service->save(self::$model, $request->all());
            return Response::redirectBack($data);
        }
        return view(Helper::setViewSave($this->template, $this->folder))->with($this->share([
            'model' => self::$model,
        ]));
    }

    public function update(QuotationService $service, QuotationRequest $request)
    {
        if (request()->isMethod('POST')) {
            $data = $service->update(self::$model, $request->all());
            $data = $request->all();
            return Response::redirectBack($data);
        }

        $data = $service->show(self::$model);
        $from = Helper::getSingleArea($data->sales_quotation_from_area);
        $to = Helper::getSingleArea($data->sales_quotation_to_area);

        return view(Helper::setViewSave($this->template, $this->folder))->with($this->share([
            'model'        => $data,
            'from'        => $from,
            'to'        => $to,
            'detail' => $data->detail,
        ]));
    }

    public function order(OrderService $service, OrderRequest $request)
    {
        if (request()->isMethod('POST')) {
            // dd($request->all());
            $data = $service->save(self::$order, $request->all());
            return Response::redirectBack($data);
        }

        $data = $service->show(self::$model);
        $from = Helper::getSingleArea($data->sales_quotation_from_area ?? '');
        $to = Helper::getSingleArea($data->sales_quotation_to_area);

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
            $datatable = $service->setRaw(['sales_quotation_status'])->datatable(self::$model);
            $datatable->editColumn('sales_quotation_status', function ($select) {
                return Helper::createStatus([
                    'value'  => $select->sales_quotation_status,
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
        unset($field['sales_quotation_status']);
        unset($field['rajaongkir_paket_name']);
        unset($field['finance_top_name']);
        $payment = PaymentRepository::where('finance_payment_sales_quotation_id', $data->sales_quotation_id)->get();
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
            $data = $service->show(self::$model, ['detail', 'company']);
            $id = request()->get('code');
            $pasing = [
                'master' => $data,
                'detail' => $data->detail,
            ];
            $pdf = PdfFacade::loadView(Helper::setViewPrint('print_quotation', $this->folder), $pasing);
            return $pdf->download();
            // return $pdf->stream();
        }
    }
}
