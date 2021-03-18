<?php

namespace Modules\Marketing\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\GeneralRequest;
use App\Http\Services\MasterService;
use Illuminate\Support\Facades\DB;
use Modules\Item\Dao\Facades\ProductFacades;
use Modules\Item\Dao\Repositories\ProductRepository;
use Modules\Marketing\Dao\Models\LanggananDetail;
use Modules\Marketing\Dao\Repositories\LanggananRepository;
use Plugin\Helper;
use Plugin\Response;

class LanggananController extends Controller
{
    public $template;
    public static $model;

    public function __construct()
    {
        if (self::$model == null) {
            self::$model = new LanggananRepository();
        }
        $this->template = Helper::getTemplate(__CLASS__);
    }

    public function index()
    {
        return redirect()->route($this->getModule() . '_data');
    }

    private function share($data = [])
    {
        $product = Helper::shareOption(new ProductRepository());
        $view = [
            'template' => $this->template,
            'product' => $product,
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
            $code = request()->get('code');
            $detail = request()->get('temp_id');
            if (!empty($detail)) {
                LanggananDetail::where('marketing_langganan_detail_langganan_id', $code)->delete();
                foreach ($detail as $insert) {
                    LanggananDetail::create([
                        'marketing_langganan_detail_langganan_id' => $code,
                        'marketing_langganan_detail_product_id' => $insert,
                    ]);
                }
            }
            $service->update(self::$model, $request->all());
            return redirect()->route($this->getModule() . '_data');
        }

        if (request()->has('code')) {

            $data = $service->show(self::$model);
            $detail = DB::table((new LanggananDetail())->getTable())
                ->where('marketing_langganan_detail_langganan_id', request()->get('code'))
                ->leftJoin(ProductFacades::getTable(), ProductFacades::getKeyName(), 'marketing_langganan_detail_product_id')
                ->get();

            return view(Helper::setViewUpdate())->with($this->share([
                'model' => $data,
                'key' => self::$model->getKeyName(),
                'detail' => $detail,
            ]));
        }
    }

    public function delete(MasterService $service)
    {
        if ($detail = request()->get('detail')) {
            $check = true;
            $check = DB::table((new LanggananDetail())->getTable())->where('marketing_langganan_detail_id', request()->get('detail'))->delete();
            return $check ? $detail : false;
        }

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
