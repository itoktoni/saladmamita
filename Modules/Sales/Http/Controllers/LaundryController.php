<?php

namespace Modules\Sales\Http\Controllers;

use Carbon\Carbon;
use Plugin\Helper;
use Plugin\Response;
use Barryvdh\DomPDF\Facade as PDF;
use Barryvdh\DomPDF\PdfFacade;
use Webklex\IMAP\Facades\Client;
use App\Http\Controllers\Controller;
use App\Http\Services\MasterService;
use Symfony\Component\DomCrawler\Crawler;
use App\Dao\Repositories\BranchRepository;
use Modules\Finance\Dao\Facades\BankFacades;
use Modules\Sales\Http\Requests\OrderRequest;
use Modules\Sales\Http\Services\OrderService;
use Modules\Sales\Http\Requests\DeliveryRequest;
use Modules\Finance\Dao\Repositories\TaxRepository;
use Modules\Finance\Dao\Repositories\TopRepository;
use Modules\Sales\Dao\Repositories\OrderRepository;
use Modules\Sales\Http\Requests\OrderRequestUpdate;
use Modules\Crm\Dao\Repositories\CustomerRepository;
use Modules\Finance\Dao\Repositories\BankRepository;
use Modules\Item\Dao\Repositories\ProductRepository;
use Modules\Item\Dao\Repositories\VariantRepository;
use Modules\Finance\Dao\Repositories\PaymentRepository;
use Modules\Marketing\Dao\Repositories\PromoRepository;
use Modules\Rajaongkir\Dao\Repositories\DeliveryRepository;

class LaundryController extends Controller
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
        $this->template = Helper::getTemplate(__CLASS__);
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

    private function parser($html, $selector, $node, $sub)
    {
        $crawler = new Crawler($html);
        $header = $crawler->filter($selector)->eq($node)->html();
        $crawler2 = new Crawler($header);
        $parse = $crawler2->filter($sub)->each(function (Crawler $node, $i) {
            return $node->text();
        });
        return $parse;
    }

    public function create(OrderService $service, OrderRequest $request)
    {
        if (request()->isMethod('POST')) {
            $data = $service->save(self::$model, $request->all());
            if($data['status']){
                return Response::redirectToRoute('sales_order_update', ['code' => $data['data']->{self::$model->getKeyName()}]);
            }
        }
        return view(Helper::setViewSave($this->template, $this->folder))->with($this->share([
            'model' => self::$model,
        ]));
    }

    public function update(OrderService $service, OrderRequestUpdate $request)
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
            'model' => $data,
            'from' => $from,
            'to' => $to,
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
            'model' => $data,
            'from' => $from,
            'to' => $to,
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
                    'value' => $select->sales_order_status,
                    'status' => self::$model->status,
                ]);
            });
            $datatable->addColumn('action', Helper::setViewAction($this->template, $this->folder));

            return $datatable->make(true);
        }

        return view(Helper::setViewData())->with([
            'fields' => Helper::listData(self::$model->datatable),
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
            'payment' => $payment,
            'model' => $data,
            'key' => self::$model->getKeyName(),
        ]));
    }

    public function print_order(MasterService $service)
    {
        if (request()->has('code')) {
            $data = $service->show(self::$model, ['detail','detail', 'company']);
            $data->sales_order_print_counter++;
            $data->save();
            $id = request()->get('code');
            // dd($data->deliveryRepository($id)->get());
            $pasing = [
                'master' => $data,
                'detail' => $data->detail,
                'banks' => BankFacades::dataRepository()->get(),
            ];
            $pdf = PDF::loadView(Helper::setViewPrint(__FUNCTION__, $this->folder), $pasing)->setPaper('a6', 'potrait');
            return $pdf->download();
            // return $pdf->stream();
        }
    }
}
