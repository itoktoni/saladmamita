<?php

namespace Modules\Item\Http\Controllers;

use Plugin\Notes;
use Plugin\Helper;
use Plugin\Response;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Services\MasterService;
use App\Http\Requests\GeneralRequest;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Config;
use App\Dao\Repositories\BranchRepository;
use Modules\Item\Http\Services\ProductService;
use Modules\Item\Dao\Repositories\TagRepository;
use Modules\Item\Dao\Repositories\TaxRepository;
use Modules\Item\Dao\Repositories\SizeRepository;
use Modules\Item\Dao\Repositories\BrandRepository;
use Modules\Item\Dao\Repositories\ColorRepository;
use Modules\Item\Dao\Repositories\ProductRepository;
use Modules\Item\Dao\Repositories\CategoryRepository;
use Modules\Item\Dao\Repositories\CurrencyRepository;
use Modules\Item\Dao\Repositories\MaterialRepository;
use Modules\Item\Dao\Repositories\UnitRepository;

class ProductController extends Controller
{
    public $template;
    public $folder;
    public static $model;

    public function __construct()
    {
        if (self::$model == null) {
            self::$model = new ProductRepository();
        }
        $this->folder = 'Item';
        $this->template  = Helper::getTemplate(__CLASS__);
    }

    public function index()
    {
        return redirect()->route($this->getModule() . '_data');
    }

    private function share($data = [])
    {
        $brand = Helper::createOption((new BrandRepository()));
        $branch = Helper::createOption((new BranchRepository()));
        $product = Helper::createOption((new ProductRepository()));
        $category = Helper::createOption((new CategoryRepository()));
        $tax = Helper::createOption((new TaxRepository()));
        $currency = Helper::createOption((new CurrencyRepository()));
        $tag = Helper::shareTag((new TagRepository()), 'item_tag_slug');
        $unit = Helper::shareOption((new UnitRepository()));
        $material = Helper::shareOption((new MaterialRepository()));
        $type = Helper::shareStatus(self::$model->promo);

        $view = [
            'key'       => self::$model->getKeyName(),
            'brand'      => $brand,
            'branch'      => $branch,
            'category'  => $category,
            'tag'  => $tag,
            'tax'  => $tax,
            'currency'  => $currency,
            'product'  => $product,
            'unit'  => $unit,
            'material'  => $material,
            'type'  => $type,
        ];

        return array_merge($view, $data);
    }

    public function create(MasterService $service, GeneralRequest $request)
    {
//         $curl = curl_init();
//         $token = "qD0N9C1fqFYUAZyDKWDI6OVzydlvQAW7fKlM3tch6kFaTC7JvRKMgAGjF5lOxFHR";
//         $data = [
//             'phone' => '081213427842',
//             'message' =>    nl2br('NOTIFICATION ORDER SO2020010001 \n Customer : itok toni laksono \n Product : \n 1. gado gado 2 pcs x 20.000 = 40.000 \n 2. Ice cream 1 pcs x 10.000 = 10.000 \n Total product : 50.000 \n Voucher : 10.000 \n Jasa ongkir : 20.000 \n TOTAL : 60.000 \n'),
// //             'message' => '
// //             NOTIFICATION ORDER SO7353738
// // Customer : itok toni laksono

// // Product : 
// // 1. gado gado 2 pcs x 20.000 = 40.000
// // 2. Ice cream 1 pcs x 10.000 = 10.000
// // Total product : 50.000
// // Voucher : 10.000
// // Jasa ongkir : 20.000
// // TOTAL : 60.000
// //             ',
//         ];

//         curl_setopt(
//             $curl,
//             CURLOPT_HTTPHEADER,
//             array(
//         "Authorization: $token",
// )
//         );
//         curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
//         curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
//         curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));
//         curl_setopt($curl, CURLOPT_URL, "https://selo.wablas.com/api/send-message");
//         curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
//         curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
//         $result = curl_exec($curl);
//         curl_close($curl);

//         dd($result);

        if (request()->isMethod('POST')) {
            $check = $service->save(self::$model, $request->all());
            if ($check['status']) {
                return redirect()->route($this->getModule() . '_update', ['code' => $check['data']->item_product_id]);
            }
            return redirect()->back();
        }
        return view(Helper::setViewCreate())->with($this->share([
            'model' => self::$model,
        ]));
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
                'model'        => $data,
                'image_detail' => self::$model->getImageDetail($data->item_product_id),
                'key'          => self::$model->getKeyName()
            ]));
        }
    }

    public function delete_image()
    {
        if (request()->has('code')) {
            $code = request()->get('code');
            self::$model->deleteImageDetail($code);

            Helper::removeImage($code, 'product_detail');
            return response()->json(['status' => $code]);
        }
    }

    public function upload()
    {
        if (request()->has('code')) {
            $code = request()->get('code');
            $path = public_path('files/product_detail');
            $photos = request()->file('file');

            for ($i = 0; $i < count($photos); $i++) {
                $photo = $photos[$i];
                $name = sha1(date('YmdHis') . Str::random(30));
                $save_name = $name . '.' . $photo->getClientOriginalExtension();
                $resize_name = 'thumbnail_' . $save_name;

                Image::make($photo)
                    ->resize(250, null, function ($constraints) {
                        $constraints->aspectRatio();
                    })
                    ->save($path . '/' . $resize_name);

                $photo->move($path, $save_name);
                self::$model->saveImageDetail($code, $save_name);
            }

            return response()->json(['status' => 1]);
        }
    }

    public function delete(MasterService $service)
    {
        $service->delete(self::$model);
        return Response::redirectBack();
        ;
    }

    public function data(MasterService $service)
    {
        if (request()->isMethod('POST')) {
            $datatable = $service->setRaw(['item_product_image'])->datatable(self::$model);
            $datatable->editColumn('item_product_sell', function ($select) {
                return number_format($select->item_product_sell);
            });
            $datatable->editColumn('item_product_image', function ($select) {
                return Helper::createImage(Helper::getTemplate(__CLASS__) . '/thumbnail_' . $select->item_product_image);
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
        if (request()->has('code')) {
            $data = $service->show(self::$model);
            return view(Helper::setViewShow())->with($this->share([
                'fields' => Helper::listData(self::$model->datatable),
                'model'   => $data,
                'key'   => self::$model->getKeyName()
            ]));
        }
    }
}
