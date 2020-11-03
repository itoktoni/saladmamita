<?php

namespace App\Http\Controllers;

use App;
use App\Dao\Facades\BranchFacades;
use App\Dao\Repositories\BranchRepository;
use App\Dao\Repositories\TeamRepository;
use App\Http\Services\EcommerceService;
use Barryvdh\DomPDF\Facade as PDF;
use Carbon\Carbon;
use Darryldecode\Cart\CartCondition;
use Darryldecode\Cart\Facades\CartFacade as Cart;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;
use Ixudra\Curl\Facades\Curl;
use Jackiedo\DotenvEditor\Facades\DotenvEditor;
use Modules\Finance\Dao\Facades\BankFacades;
use Modules\Finance\Dao\Repositories\BankRepository;
use Modules\Item\Dao\Facades\ProductFacades;
use Modules\Item\Dao\Models\Product;
use Modules\Item\Dao\Models\Wishlist;
use Modules\Item\Dao\Repositories\BrandRepository;
use Modules\Item\Dao\Repositories\CategoryRepository;
use Modules\Item\Dao\Repositories\ColorRepository;
use Modules\Item\Dao\Repositories\ProductRepository;
use Modules\Item\Dao\Repositories\SizeRepository;
use Modules\Item\Dao\Repositories\TagRepository;
use Modules\Marketing\Dao\Facades\LanggananFacades;
use Modules\Marketing\Dao\Repositories\ContactRepository;
use Modules\Marketing\Dao\Repositories\HolidayRepository;
use Modules\Marketing\Dao\Repositories\LanggananRepository;
use Modules\Marketing\Dao\Repositories\PromoRepository;
use Modules\Marketing\Dao\Repositories\SliderRepository;
use Modules\Marketing\Dao\Repositories\SosmedRepository;
use Modules\Marketing\Emails\ContactEmail;
use Modules\Procurement\Dao\Repositories\PurchasePrepareRepository;
use Modules\Procurement\Emails\CreateOrderEmail as EmailsCreateOrderEmail;
use Modules\Rajaongkir\Dao\Repositories\DeliveryRepository;
use Modules\Rajaongkir\Dao\Repositories\ProvinceRepository;
use Modules\Sales\Dao\Facades\OrderFacades;
use Modules\Sales\Dao\Facades\SubscribeFacades;
use Modules\Sales\Dao\Models\Area;
use Modules\Sales\Dao\Models\City;
use Modules\Sales\Dao\Models\Province;
use Modules\Sales\Dao\Repositories\CourierRepository;
use Modules\Sales\Dao\Repositories\OrderRepository;
use Modules\Sales\Dao\Repositories\SubscribeRepository;
use Modules\Sales\Http\Services\LanggananService;
use Modules\Sales\Http\Services\PublicService;
use Plugin\Helper;

class PublicController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->only(['myaccount']);
    }

    private function share($data = [])
    {
        $sosmed = Helper::createOption(new SosmedRepository(), false, true);
        $category = Helper::createOption(new CategoryRepository(), false, true);
        $product = Helper::createOption(new ProductRepository(), false, true);

        $view = [
            'sosmed' => $sosmed,
            'category' => $category,
            'product' => $product,
        ];

        return array_merge($view, $data);
    }

    public function index($slider = false)
    {
        if (config('website.application')) {
            return redirect()->route('login');
        }

        $slider = Helper::createOption(new SliderRepository(), false, true);
        return View(Helper::setViewFrontend(__FUNCTION__))->with($this->share([
            'sliders' => $slider,
        ]));
    }

    public function about()
    {
        return View(Helper::setViewFrontend(__FUNCTION__))->with([]);
    }

    public function filters()
    {
        return redirect()->route('shop');
    }

    public function shop($type = null, $slug = null)
    {
        // session()->forget('filter');
        if (request()->isMethod('POST')) {
            if (empty(request()->get('search'))) {
                session()->forget('filter.item_product_name');
            } else {
                session()->put('filter.item_product_name', request()->get('search'));
            }
        }
        $color = Helper::createOption(new ColorRepository(), false, true);
        $size = Helper::createOption(new SizeRepository(), false, true)->pluck('item_size_code');
        $tag = Helper::createOption(new TagRepository(), false, true)->pluck('item_tag_slug');
        $brand = Helper::createOption(new BrandRepository(), false, true)->pluck('item_brand_slug', 'item_brand_name');

        $object_product = new ProductRepository();
        $product = $object_product->dataRepository();
        $session = [];
        // session()->flush();
        if ($type == 'add' && is_numeric($slug)) {
            $item = $object_product->showRepository($slug);
            $additional = [];

            $discount = 0;
            if ($item->item_product_discount_type == 1) {
                $discount = $item->item_product_sell * $item->item_product_discount_value;
            } elseif ($item->item_product_discount_type == 2) {
                $discount = $item->item_product_discount_value;
            }

            $stock = DB::table('view_stock_product')->where('product', $item->item_product_id)->get();
            $option_stock = $stock->mapWithKeys(function ($item) {
                $size = $item->size ? $item->size . ' - ' : '';
                $color = $item->hex ? $item->hex . ' - ' : '';
                $stock = 'Stock ( ' . $item->qty . ' )';

                return [$item->id => $size . $color . $stock];
            })->toArray();

            $additional = [
                'image' => $item->item_product_image,
                'list_option' => $option_stock,
                'option' => $stock->first()->id ?? null,
                'product' => $item->item_product_id ?? null,
                'size' => $stock->first()->size ?? null,
                'color' => $stock->first()->hex ?? null,
                'stock' => $stock->first()->qty ?? null,
                'discount' => $discount,
                'gram' => $item->item_product_gram,
            ];

            $price = $item->item_product_sell - $discount;
            Cart::add($stock->first()->id, $item->item_product_name, $price, 1, $additional);
        } elseif ($type == 'love' && is_string($slug)) {
            $love = DB::table('item_wishlist')->where([
                'item_wishlist_item_product_id' => $slug,
                'item_wishlist_user_id' => Auth::user()->id,
            ]);

            if ($love->count() > 0) {
                $love->delete();
            } else {
                $love = DB::table('item_wishlist')->insert([
                    'item_wishlist_item_product_id' => $slug,
                    'item_wishlist_user_id' => Auth::user()->id,
                    'item_wishlist_created_at' => date('Y-m-d H:i:s'),
                ]);
            }
        } else {
            switch ($type) {
                case 'brand':
                    if (!session()->has('filter.item_brand_slug.' . $slug)) {
                        session()->put('filter.item_brand_slug.' . $slug, $slug);
                    }
                    break;
                case 'category':
                    if (!session()->has('filter.item_category_slug.' . $slug)) {
                        session()->put('filter.item_category_slug.' . $slug, $slug);
                    }
                    break;
                case 'size':
                    if (!session()->has('filter.item_product_item_size_json.' . $slug)) {
                        session()->put('filter.item_product_item_size_json.' . $slug, $slug);
                    }
                    break;
                case 'color':
                    if (!session()->has('filter.item_product_item_color_json.' . $slug)) {
                        session()->put('filter.item_product_item_color_json.' . $slug, $slug);
                    }
                    break;
                case 'tag':
                    if (!session()->has('filter.item_product_item_tag_json.' . $slug)) {
                        session()->put('filter.item_product_item_tag_json.' . $slug, $slug);
                    }
                    break;
                case 'reset':
                    session()->forget('filter');
                    break;
                case 'remove_filter':
                    session()->forget('filter.' . $slug);
                    foreach (session()->get('filter') as $rmv => $remove) {
                        if (empty($remove)) {
                            session()->forget('filter.' . $rmv);
                        }
                    }
                    break;
            }
        }
        if (session()->has('filter')) {
            foreach (session()->get('filter') as $key => $value) {
                if ($key == 'item_product_item_tag_json') {
                    foreach ($value as $filter) {
                        $product->where($key, 'like', '%' . $filter . '%');
                    }
                } elseif ($key == 'item_product_name') {
                    $product->where($key, 'like', '%' . $value . '%');
                } else {
                    $product->whereIn($key, array_values($value));
                }
            }
        }

        return View(Helper::setViewFrontend(__FUNCTION__))->with($this->share([
            'color' => $color,
            'size' => $size,
            'tag' => $tag,
            'brand' => $brand,
            'product' => $product->paginate(9),
        ]));
    }

    public function faq()
    {
        return View(Helper::setViewFrontend(__FUNCTION__))->with([]);
    }

    public function track($code)
    {
        $model = new OrderRepository();
        $data = $model->showRepository($code);
        if ($data) {
            try {
                //code...
                $response = Curl::to(route('waybill'))->withData([
                    'waybill' => $data->sales_order_rajaongkir_waybill,
                    'courier' => $data->sales_order_rajaongkir_courier,
                ])->post();
                $waybill = json_decode($response);
                if (isset($waybill) && !empty($waybill->rajaongkir) && $waybill->rajaongkir->status->code == 200) {
                    return View(Helper::setViewFrontend(__FUNCTION__))->with([
                        'data' => $data,
                        'waybill' => $waybill->rajaongkir->result,
                    ]);
                } else {
                    abort(403, $waybill->rajaongkir->status->description);
                }
            } catch (\Throwable $th) {
                abort(403, 'Ongkir API was down !');
                //throw $th;
            }
        }
    }

    public function userprofile()
    {
        $user = new TeamRepository;

        if (Auth::check()) {
            $province = Auth::user()->province;
            $city = Auth::user()->city;
            $area = Auth::user()->area;
            $data = $user->showRepository(Auth::user()->id);
        };

        if (request()->isMethod('POST')) {
            $request = request()->all();
            $province = request()->get('province');
            $city = request()->get('city');
            $area = request()->get('area');

            $validation = [
                'name' => 'required',
                'email' => 'required',
                'address' => 'required',
                'province' => 'required',
                'city' => 'required',
                'area' => 'required',
            ];

            $validate = Validator::make($request, $validation);
            if ($validate->fails()) {
                return redirect()->back()->withInput()->withErrors($validate);
            }
            unset($request['province']);
            unset($request['city']);
            $success = $user->updateRepository(Auth::user()->id, $request);
            $area = Helper::getSingleArea($request['area'], false, true);

            if ($success) {
                session()->flash('info', 'Data Has been saved');
                return redirect()->back();
            }
        }

        $area = Helper::getSingleArea(Auth::user()->area, false, true);
        $province = Helper::createOption(new ProvinceRepository());

        return View(Helper::setViewFrontend(__FUNCTION__))->with($this->share([
            'model' => $data,
            'province' => isset($area['province']) ? array_keys($area['province']) : [],
            'city' => isset($area['city']) ? array_keys($area['city']) : [],
            'area' => isset($area['area']) ? array_keys($area['area']) : [],
            'list_province' => $province,
            'list_city' => $area['city'] ?? [],
            'list_area' => $area['area'] ?? [],
        ]));
    }
    public function register()
    {
        return View(Helper::setViewFrontend(__FUNCTION__))->with($this->share());
    }

    public function myaccount()
    {
        $user = new TeamRepository();
        $order = new OrderRepository();

        $province = $city = $location = $data = false;
        $list_location = $list_city = $data_order = $my_wishlist = [];

        if ($delete = request()->get('delete')) {
            $c = Wishlist::where('item_wishlist_item_product_id', $delete)->where('item_wishlist_user_id', Auth::user()->id)->delete();
            if ($c) {
                return redirect()->route('myaccount')->with('info', 'Success Delete Product');
            } else {
                return redirect()->route('myaccount')->with('info', 'Fail Delete Product');
            }
        }

        if (Auth::check()) {
            $province = Auth::user()->province;
            $city = Auth::user()->city;
            $location = Auth::user()->location;
            $data = $user->showRepository(Auth::user()->id);

            $data_order = $order->userRepository(Auth::user()->email)->get();
        };

        if (request()->isMethod('POST')) {
            $request = request()->all();
            $province = request()->get('province');
            $city = request()->get('city');
            $location = request()->get('location');

            $validation = [
                'name' => 'required',
                'email' => 'required',
                'address' => 'required',
                'province' => 'required',
                'city' => 'required',
                'location' => 'required',
                'password' => 'required|min:6',
            ];

            $validate = Validator::make($request, $validation);
            if ($validate->fails()) {
                return redirect()->back()->withInput()->withErrors($validate);
            }

            if (request()->has('password')) {
                $request['password'] = bcrypt(request()->get('password'));
            }

            $user->updateRepository(Auth::user()->id, $request);
        }

        if (Cache::has('province')) {
            $list_province = Cache::get('province');
        } else {
            $list_province = Cache::rememberForever('province', function () {
                return DB::table('rajaongkir_provinces')->get()->sortBy('rajaongkir_province_name')->pluck('rajaongkir_province_name', 'rajaongkir_province_id')->prepend(' Choose Province', '0')->toArray();
            });
        }

        if ($province) {
            $list_city = DB::table('rajaongkir_cities')->where('rajaongkir_city_province_id', $province)->get()->sortBy('rajaongkir_city_name')->pluck('rajaongkir_city_name', 'rajaongkir_city_id')->toArray();
        }

        if ($city) {
            $list_location = DB::table('rajaongkir_areas')->where('rajaongkir_area_city_id', $city)->get()->sortBy('rajaongkir_area_name')->pluck('rajaongkir_area_name', 'rajaongkir_area_id')->toArray();
        }

        return View(Helper::setViewFrontend(__FUNCTION__))->with($this->share([
            'model' => $data,
            'province' => $province,
            'order' => $data_order,
            'city' => $city,
            'location' => $location,
            'status' => Helper::shareStatus($order->status),
            'list_province' => $list_province,
            'list_city' => $list_city,
            'list_location' => $list_location,
            'my_wishlist' => $my_wishlist,
        ]));
    }

    public function page($slug = false)
    {
        if ($slug && Cache::has('marketing_page_api')) {
            $page = Cache::get('marketing_page_api');
            $data = $page->where('marketing_page_slug', $slug)->first();
            if (!$data) {
                abort(404, 'Page not found !');
            }

            return View(Helper::setViewFrontend('page'))->with([
                'data' => $data,
            ]);
        }

        abort(404, 'Page not found !');
    }

    public function promo($slug = false)
    {
        if ($slug) {
            $model = new PromoRepository();
            $data = $model->slugRepository($slug);

            return View(Helper::setViewFrontend('single_promo'))->with([
                'data' => $data,
            ]);
        }

        $promo = new PromoRepository();
        $data_promo = $promo->dataRepository()
            ->where('marketing_promo_status', 1)
            ->where('marketing_promo_type', 1)->get();
        $single = $data_promo->where('marketing_promo_default', 1)->first();
        return View(Helper::setViewFrontend(__FUNCTION__))->with([
            'promo' => $data_promo->whereNotIn('marketing_promo_default', [1]),
            'single' => $single,
        ]);
    }

    public function category($slug = false)
    {
        if ($slug) {
            $category = new CategoryRepository();
            $data_category = $category->slugRepository($slug);
            $color = Helper::createOption(new ColorRepository(), false, true)->pluck('item_color_code');
            $size = Helper::createOption(new SizeRepository(), false, true)->pluck('item_size_code');
            $tag = Helper::createOption(new TagRepository(), false, true)->pluck('item_tag_slug');
            $brand = Helper::createOption(new BrandRepository(), false, true)->pluck('item_brand_slug', 'item_brand_name');

            $product = ProductRepository::where('item_product_item_category_id', $data_category->item_category_id)->paginate(9);
            return View(Helper::setViewFrontend('shop'))->with([
                'color' => $color,
                'size' => $size,
                'tag' => $tag,
                'brand' => $brand,
                'product' => $product,
            ]);
        }

        return View(Helper::setViewFrontend(__FUNCTION__));
    }

    public function cart()
    {
        // Cart::clear();
        if (request()->isMethod('POST')) {
            $request = request()->all();
            // dd($request);

            if (isset($request['code']) && !empty($request['code'])) {
                $code = $request['code'];
                $validate = Validator::make($request, [
                    'code' => 'required|exists:marketing_promo,marketing_promo_code',
                ], [
                    'code.exists' => 'Voucher Not Valid !',
                ]);

                $promo = new PromoRepository();
                $data = $promo->codeRepository(strtoupper($code));

                if ($data) {
                    $value = Cart::getTotal();
                    $matrix = $data->marketing_promo_matrix;
                    if ($matrix) {

                        // validate with minimal
                        $minimal = $data->marketing_promo_minimal;
                        if ($minimal) {
                            if ($minimal > $value) {
                                $validate->getMessageBag()->add('code', 'Minimal value ' . number_format($minimal) . ' !');
                                return redirect()->back()->withErrors($validate);
                            }
                        }

                        $string = str_replace('@value', $value, $matrix);
                        $total = $value;

                        try {
                            $total = Helper::calculate($string);
                        } catch (\Throwable $th) {
                            $total = $value;
                        }

                        $promo = Cart::getConditions()->first();
                        if ($promo) {
                            Cart::removeCartCondition($promo->getName());
                        }
                        $condition = new CartCondition(array(
                            'name' => $data->marketing_promo_code,
                            'type' => $data->marketing_promo_type == 1 ? 'Promo' : 'Voucher',
                            'target' => 'total', // this condition will be applied to cart's subtotal when getSubTotal() is called.
                            'value' => -$total,
                            'order' => 1,
                            'attributes' => array( // attributes field is optional
                                'name' => $data->marketing_promo_name,
                            ),
                        ));

                        Cart::condition($condition);
                    }
                } else {
                    $validate->getMessageBag()->add('code', 'Voucher Not Valid !');
                    return redirect()->back()->withErrors($validate)->withInput();
                }

                if ($validate->fails()) {
                    return redirect()->back()->withErrors($validate)->withInput();
                }
            } else {

                $index = $sub = 0;
                if (isset($request['detail'])) {

                    foreach ($request['detail'] as $detail) {

                        $product_id = $detail['temp_product_id'];
                        $product = ProductFacades::find($product_id);

                        if (isset($detail['temp_product_variant'])) {

                            $collection = collect($detail['temp_product_variant']);
                            $qty = $collection->sum(function ($product) {
                                $qty = intval($product['temp_variant_qty']);
                                return $qty;
                            });

                            $detail['temp_product_qty'] = $qty;

                            $attributes = [
                                'detail' => $detail,
                                'variant' => $detail['temp_product_variant'] ?? [],
                            ];

                        } else {

                            $qty = $detail['temp_product_qty'];
                            $detail['temp_product_qty'] = intval($qty);
                            $attributes = [
                                'detail' => $detail,
                                'variant' => [],
                            ];
                        }

                        $sub_total = $qty * $product->item_product_sell;
                        $sub = $sub + $sub_total;

                        $rules = [
                            'detail.temp_product_qty' => 'required|numeric|min:' . $product->item_product_min_order,
                        ];

                        $message = [
                            'detail.temp_product_qty.required' => 'Qty Harus Diisi !',
                            'detail.temp_product_qty.numeric' => 'Qty Harus Angka !',
                            'detail.temp_product_qty.min' => 'Qty Minimal ' . $product->item_product_min_order . ' !',
                        ];

                        $validate = Validator::make($attributes, $rules, $message);
                        if ($validate->fails()) {
                            return redirect()->back()->withErrors($validate)->withInput();
                        }

                        if (Cart::getContent()->contains('id', $product_id)) {
                            Cart::remove($product_id);
                        }

                        Cart::add($product_id, $product->item_product_name, $product->item_product_sell, $qty, $attributes);

                        $index++;
                    }

                    $this->updatePromo();

                } else {

                    $validate = Validator::make($request, [
                        'code' => 'required|exists:marketing_promo,marketing_promo_code',
                    ], [
                        'code.exists' => 'Voucher Not Valid !',
                    ]);
                }

                return redirect()->back()->withErrors($validate)->withInput();
            }
        }

        $carts = Cart::getContent();

        return View(Helper::setViewFrontend(__FUNCTION__))->with($this->share([
            'carts' => $carts,

        ]));
    }
    public function checkout(PublicService $service)
    {
        $area = [];

        if (request()->isMethod('POST')) {
            $request = request()->all();
            $autonumber = Helper::autoNumber(OrderFacades::getTable(), OrderFacades::getKeyName(), 'SO' . date('Ym'), config('website.autonumber'));

            if (isset($request['sales_order_to_area'])) {
                $area_id = $request['sales_order_to_area'];
                $area = Helper::getSingleArea($area_id, false, true);
            }

            $detail = collect($request['detail'])->map(function ($item) use ($autonumber) {
                $item['sales_order_detail_order_id'] = $autonumber;
                return $item;
            });

            $request = array_merge($request, [
                'detail' => $detail,
            ]);

            $rules = [
                'sales_order_to_name' => 'required',
                'sales_order_to_phone' => 'required',
                'sales_order_to_email' => 'required|email',
                'sales_order_to_address' => 'required',
                'sales_order_to_area' => 'required',
                'sales_order_from_id' => 'required',
                'sales_order_delivery_type' => 'required',
                'sales_order_date_order' => 'required',
            ];

            $message = [
                'sales_order_to_name.required' => 'Nama Customer Harus Diisi',
                'sales_order_to_phone.required' => 'No. Telp Harus Diisi',
                'sales_order_to_address.required' => 'Alamat Harus Diisi',
                'sales_order_to_email.required' => 'Email Harus Diisi',
                'sales_order_to_email.email' => 'Email Tidak Valid',
                'sales_order_to_area.required' => 'Area Pengiriman Harus Diisi',
                'sales_order_from_id.required' => 'Lokasi Pickup Harus Diisi',
                'sales_order_delivery_type.required' => 'Metode Pengiriman Harus Diisi',
                'sales_order_date_order.required' => 'Tanggal Pengiriman Harus Diisi',
            ];

            $validate = Validator::make($request, $rules, $message);
            if ($validate->fails()) {
                return redirect()->back()->withErrors($validate)->withInput()->with([
                    'area' => $area,
                ]);
            }

            $order = new OrderRepository();
            $check = $service->save($order, $request);
            if (!isset($check['status'])) {
                $validate->errors()->add('field', 'Something is wrong with this field!');
                return redirect()->back()->withErrors($validate)->withInput()->with([
                    'area' => $area,
                ]);
            }
        }

        if (Auth::check()) {
            $area = Helper::getSingleArea(auth()->user()->area, false, true);
        }

        $carts = Cart::getContent();
        $list_province = Helper::createOption(new ProvinceRepository());
        $branch = Helper::createOption(new BranchRepository());
        $user = Auth::user() ?? [];
        $metode = Helper::createOption(new DeliveryRepository());

        return View(Helper::setViewFrontend(__FUNCTION__))->with($this->share([
            'carts' => $carts,
            'list_province' => $list_province,
            'branch' => $branch,
            'user' => $user,
            'area' => $area,
            'metode' => $metode,
        ]));
    }
    public function langganan(LanggananService $service)
    {
        $area = $langganan_data = $carbon = [];

        if (request()->has('token')) {
            $token = request()->get('token');
            $data = SubscribeFacades::where('sales_langganan_token', $token)->firstOrFail();
            $pasing = [
                'master' => $data,
                'detail' => $data->detail,
                'banks' => BankFacades::dataRepository()->get(),
            ];
            $pdf = PDF::loadView(Helper::setViewPrint('print_order'), $pasing);
            return $pdf->stream();
        }

        if (request()->has('sales_langganan_date_order')) {
            $date = request()->get('sales_langganan_date_order');
            $carbon = Carbon::createFromFormat('Y-m-d', $date);
        }

        if (request()->has('area')) {
            $area_id = request()->get('area');
            $area = Helper::getSingleArea($area_id, false, true);
        }

        if (request()->has('code')) {
            $code = request()->get('code');
            $langganan_data = LanggananFacades::showRepository($code);
        }

        if (request()->isMethod('POST')) {
            $request = request()->all();

            if (request()->has('sales_langganan_to_area')) {
                $area_id = request()->get('sales_langganan_to_area');
                session()->put('area', Helper::getSingleArea($area_id, false, true));
            }

            $rules = [
                'sales_langganan_to_name' => 'required',
                'sales_langganan_to_phone' => 'required',
                'sales_langganan_to_email' => 'required|email',
                'sales_langganan_to_address' => 'required',
                'sales_langganan_from_id' => 'required',
                'sales_langganan_date_order' => 'required',
                'sales_langganan_date_order' => 'required',
                'sales_langganan_marketing_langganan_id' => 'required',
                'sales_langganan_discount_code' => 'exists:marketing_promo,marketing_promo_code',
            ];

            $message = [
                'sales_langganan_to_name.required' => 'Nama Customer Harus Diisi',
                'sales_langganan_marketing_langganan_id.required' => 'Paket Langganan Harus Diisi',
                'sales_langganan_to_phone.required' => 'No. Telp Harus Diisi',
                'sales_langganan_to_address.required' => 'Alamat Harus Diisi',
                'sales_langganan_to_email.required' => 'Email Harus Diisi',
                'sales_langganan_to_email.email' => 'Email Tidak Valid',
                'sales_langganan_from_id.required' => 'Lokasi Pickup Harus Diisi',
                'sales_langganan_date_order.required' => 'Tanggal Pengiriman Harus Diisi',
                'sales_langganan_marketing_langganan_id.required' => 'Paket Berlangganan Harus Diisi',
                'sales_langganan_discount_code.exists' => 'Voucher Not Valid !',
            ];

            $validate = Validator::make($request, $rules, $message);
            if ($validate->fails()) {
                return redirect()->back()->withErrors($validate)->withInput();
            }

            if (request()->has('pilih')) {
                return redirect()->route('langganan', ['code' => request()->get('sales_langganan_marketing_langganan_id'), 'area' => request()->get('sales_langganan_to_area'), 'date' => $date])->withInput();
            }

            $validasi = [];
            if (isset($request['detail'])) {

                foreach ($request['detail'] as $detail) {
                    $qty = $int = 0;
                    foreach ($detail['product'] as $product) {
                        if (!isset($product['variant'])) {
                            $quantity = intval($product['sales_order_detail_qty']);
                        } else {
                            $quantity = collect($product['variant'])->map(function ($item) {
                                return intval($item['sales_order_detail_variant_qty']);
                            })->sum();
                        }
                        $qty = $qty + intval($quantity);
                    }
                    $int++;
                    $validasi[]['qty'] = $qty;
                }

                $request['hari'] = $validasi;
                $validate2 = Validator::make($request, ['hari.*.qty' => 'not_in:0']);
                if ($validate2->fails()) {
                    return redirect()->back()->withErrors($validate2)->withInput();
                }

                $repo = new SubscribeRepository();
                $check = $service->save($repo, $request);

                if ($check['status']) {
                    return redirect()->route('langganan', ['token' => $check['data']->sales_langganan_token->toString()]);
                }
            }
        }

        if (Auth::check()) {
            $area = Helper::getSingleArea(auth()->user()->area, false, true);
        }

        $carts = Cart::getContent();
        $list_province = Helper::createOption(new ProvinceRepository());
        $branch = Helper::createOption(new BranchRepository());
        $user = Auth::user() ?? [];
        $metode = Helper::createOption(new DeliveryRepository());
        $langganan = Helper::createOption(new LanggananRepository());
        $product = Helper::createOption(new ProductRepository(), false, true, true)->where('item_product_langganan', 1);
        $holiday = Helper::createOption(new HolidayRepository(), false, true, true)->where('item_product_langganan', 1);

        return View(Helper::setViewFrontend(__FUNCTION__))->with($this->share([
            'carts' => $carts,
            'list_province' => $list_province,
            'branch' => $branch,
            'user' => $user,
            'area' => $area,
            'metode' => $metode,
            'langganan' => $langganan,
            'langganan_data' => $langganan_data,
            'product' => $product,
            'holiday' => $holiday,
        ]));
    }

    public function delete($id)
    {
        if (Cart::getContent()->contains('id', $id)) {

            Cart::remove($id);
            if (Cart::isEmpty()) {
                Cart::clearCartConditions();
            } else {

                $this->updatePromo();
            }

            return redirect()->route('cart');
        }

        return redirect()->route('cart');
    }

    public function add($id)
    {
        if (is_numeric($id)) {
            $product = new ProductRepository();
            $item = $product->showRepository($id);

            $discount = 0;
            if ($item->item_product_discount_type == 1) {
                $discount = $item->item_product_sell * $item->item_product_discount_value;
            } elseif ($item->item_product_discount_type == 2) {
                $discount = $item->item_product_discount_value;
            }

            $additional = [];
            if (json_decode($item->item_product_color_json) && json_decode($item->item_product_size_json)) {
                $additional = [
                    'image' => $item->item_product_image,
                    'color' => 'random',
                    'size' => 'random',
                    'discount' => $discount,
                ];
            }
            Cart::add($item->item_product_id, $item->item_product_name, $item->item_product_sell, 1, [
                'image' => $item->item_product_image,
                'color' => 'random',
                'size' => 'random',
            ]);
        }
        return true;
    }

    public function confirmation()
    {
        $bank = new BankRepository();
        if (request()->isMethod('POST')) {
            $request = request()->all();
            $rules = [
                'sales_order_payment_person' => 'required',
                'code' => 'required|exists:sales_order,sales_order_id',
                'sales_order_payment_person' => 'required',
                'sales_order_payment_phone' => 'required',
                'sales_order_payment_value' => 'required',
                'sales_order_payment_email' => 'required|email',
                'sales_order_payment_date' => 'required',
                'files' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            ];

            $message = [
                'sales_order_payment_person.required' => 'Nama Pengirim Harus Diisi',
                'sales_order_payment_value.required' => 'Jumlah Pembayaran Harus Diisi',
                'code.required' => 'No. Order Harus Diisi',
                'code.exists' => 'No. Order Tidak',
                'files.required' => 'Bukti Transfer Harus Upload',
            ];

            $validate = Validator::make($request, $rules, $message);

            if ($validate->fails()) {
                return redirect()->back()->withErrors($validate)->withInput();
            }

            $update = OrderFacades::showRepository($request['code']);
            $check['status'] = false;
            if ($update) {

                $file = 'files';
                $name = null;
                if (request()->has($file)) {
                    $image = $update->item_product_image;
                    if ($image) {
                        Helper::removeImage($image, Helper::getTemplate(__CLASS__));
                    }

                    $file = request()->file($file);
                    $name = Helper::uploadImage($file, Helper::getTemplate(__CLASS__));

                    $update->item_product_image = $name;
                }

                $request['sales_order_term_top'] = 'CASH';
                $request['sales_order_payment_file'] = $name;
                $check = OrderFacades::updateRepository($request['code'], $request);
            }

            if ($check['status']) {
                return redirect()->route('confirmation')->with('success', 'Data has been Success');
            }
        }

        return View(Helper::setViewFrontend(__FUNCTION__))->with($this->share([
            'bank' => Helper::shareOption($bank, false, true)->pluck('finance_bank_name', 'finance_bank_name'),
        ]));
    }

    public function checkout2(EcommerceService $service)
    {
        $address = null;
        $email = null;
        $phone = null;
        $notes = null;
        $name = null;
        $postcode = null;
        $province = null;

        $city = [];
        $location = [];
        $ongkir = [];

        $list_city = [];
        $list_location = [];
        $order = new OrderRepository();
        $account = Helper::shareOption((new BankRepository()), false, true);
        $data_courier = Helper::shareOption((new CourierRepository()), false, true, false);
        $courier = $data_courier->pluck('rajaongkir_courier_name', 'rajaongkir_courier_code')->prepend('- Select Courier -', '')->all();
        if (Auth::check()) {
            $address = Auth::user()->address;
            $phone = Auth::user()->phone;
            $email = Auth::user()->email;
            $name = Auth::user()->name;
            $postcode = Auth::user()->postcode;

            $province = Auth::user()->province;
            $city = Auth::user()->city;
            $location = Auth::user()->location;
        }

        if ($province) {
            $list_city = City::where('rajaongkir_city_province_id', $province)->get()->sortBy('rajaongkir_city_name')->pluck('rajaongkir_city_name', 'rajaongkir_city_id')->toArray();
        }

        if ($city) {
            $list_location = Area::where('rajaongkir_area_city_id', $city)->get()->sortBy('rajaongkir_area_name')->pluck('rajaongkir_area_name', 'rajaongkir_area_id')->toArray();
        }

        if (Cache::has('province')) {
            $list_province = Cache::get('province');
        } else {
            $list_province = Cache::rememberForever('province', function () {
                return Province::get()->sortBy('province')->pluck('rajaongkir_province_name', 'rajaongkir_province_id')->prepend(' Choose Province', '0')->toArray();
            });
        }

        $validate = [];
        if (request()->isMethod('POST')) {
            $discount = Cart::getConditions()->first();
            $request = request()->all();
            $validator1 = Validator::make($request, [
                'sales_order_rajaongkir_courier' => 'required',
                'sales_order_rajaongkir_ongkir' => 'required',
                'sales_order_rajaongkir_city_id' => 'required',
            ], [], [
                'sales_order_rajaongkir_courier' => 'Expedition Harus Dipilih',
                'sales_order_rajaongkir_ongkir' => 'Ongkir Harus Dipilih',
                'sales_order_rajaongkir_city_id' => 'City Harus Dipilih',
            ]);

            $address = $request['sales_order_rajaongkir_address'];
            $email = $request['sales_order_email'];
            $name = $request['sales_order_rajaongkir_name'];
            $phone = $request['sales_order_rajaongkir_phone'];
            $postcode = $request['sales_order_rajaongkir_postcode'];

            $province = $request['sales_order_rajaongkir_province_id'] ?? null;
            $city = $request['sales_order_rajaongkir_city_id'] ?? null;
            $location = $request['sales_order_rajaongkir_area_id'] ?? null;

            if ($validator1->fails()) {
                return View(Helper::setViewFrontend(__FUNCTION__))->with([
                    'address' => $address,
                    'email' => $email,
                    'phone' => $phone,
                    'name' => $name,
                    'account' => $account,
                    'postcode' => $postcode,
                    'province' => $province,
                    'city' => $city,
                    'location' => $location,
                    'list_city' => $list_city,
                    'list_location' => $list_location,
                    'list_province' => $list_province,
                    'courier' => $courier,
                    'ongkir' => $ongkir,
                ])->withErrors($validator1);
            }

            $saveOngkir = 0;
            if (request()->has('sales_order_rajaongkir_ongkir')) {
                $post_to = $location;
                $post_weight = request()->get('sales_order_rajaongkir_weight');
                $post_courier = request()->get('sales_order_rajaongkir_courier');
                $response = Curl::to(route('ongkir'))->withData([
                    'to' => $post_to,
                    'weight' => $post_weight,
                    'courier' => $post_courier,
                ])->post();
                $json = json_decode($response);
                if (isset($json) && !empty($json)) {
                    $int = 0;
                    $service = $request['sales_order_rajaongkir_ongkir'];
                    $saveOngkir = collect($json)->where('service', $service)->first()->cost ?? 0;
                    $ongkir[''] = 'Choose Ongkir';
                    foreach ($json as $value) {
                        $ongkir[$value->service] = $value->service . ' ( ' . $value->description . ' ) [ ' . $value->etd . ' ] - ' . $value->price;
                    }
                }
            }

            $request['sales_order_rajaongkir_ongkir'] = $saveOngkir;
            if ($discount) {
                $request['sales_order_marketing_promo_code'] = $discount->getName();
                $request['sales_order_marketing_promo_name'] = $discount->getAttributes()['name'];
                $request['sales_order_marketing_promo_value'] = abs($discount->getValue());
            }

            $rules = [
                'sales_order_rajaongkir_province_id' => 'required',
                'sales_order_rajaongkir_city_id' => 'required',
                'sales_order_rajaongkir_area_id' => 'required',
                'sales_order_rajaongkir_courier' => 'required',
                'sales_order_rajaongkir_ongkir' => 'required|numeric',
                'sales_order_rajaongkir_address' => 'required',
                'sales_order_email' => 'required|email',
                'sales_order_rajaongkir_name' => 'required',
                'sales_order_rajaongkir_phone' => 'required',
                'sales_order_rajaongkir_weight' => 'required',
                'sales_order_rajaongkir_courier' => 'required',
                'sales_order_rajaongkir_ongkir' => 'required',
            ];
            $request['sales_order_total'] = Cart::getTotal() + $saveOngkir;
            $validate = Validator::make($request, $rules, $order->custom_attribute);
            $check = $order->saveRepository($request);
            $id = $check['data']->sales_order_id;
            foreach (Cart::getContent() as $item) {
                $stock = DB::table('view_stock_product')->where('id', $item->attributes['option'])->first();
                $price_real = $item->price + $item->quantity;

                $tax_name = $tax_value = null;
                if (config('website.tax')) {
                    $tax_name = $item->getConditions()->getName();
                    $tax_value = $item->getConditions()->getValue() * $item->quantity;
                    $price_real = ($item->price * $item->quantity) + $tax_value;
                }

                DB::table('sales_order_detail')->insert([
                    'sales_order_detail_sales_order_id' => $id,
                    'sales_order_detail_item_product_id' => $item->attributes['product'],
                    'sales_order_detail_qty_order' => $item->quantity,
                    'sales_order_detail_price_order' => $item->price,
                    'sales_order_detail_total_order' => $price_real,
                    'sales_order_detail_option' => $stock->id,
                    'sales_order_detail_item_size' => $stock->size,
                    'sales_order_detail_tax_name' => $tax_name,
                    'sales_order_detail_tax_value' => $tax_value,
                    'sales_order_detail_item_color' => $stock->color,
                    'sales_order_detail_gram' => $item->attributes['gram'],
                    'sales_order_detail_discount' => $item->attributes['discount'],
                    'sales_order_detail_price_real' => $item->price + $item->attributes['discount'],
                ]);

                if (Cart::getContent()->contains('id', $item->id)) {
                    Cart::remove($item->id);
                    if (Cart::isEmpty()) {
                        Cart::clearCartConditions();
                    }
                }
            }

            $data = $order->showRepository($id, ['customer', 'forwarder', 'detail', 'detail.product']);

            return redirect()->back()->with(['success' => true]);
        }

        return View(Helper::setViewFrontend(__FUNCTION__))->with([
            'address' => $address,
            'email' => $email,
            'phone' => $phone,
            'name' => $name,
            'account' => $account,
            'postcode' => $postcode,
            'province' => $province,
            'city' => $city,
            'location' => $location,
            'list_province' => $list_province,
            'list_city' => $list_city,
            'list_location' => $list_location,
            'courier' => $courier,
            'ongkir' => $ongkir,
        ])->withErrors($validate);
    }

    public function email($id)
    {
        // $order = new OrderRepository();
        // $data = $order->showRepository($id, ['customer', 'forwarder', 'detail', 'detail.product']);
        // return new CreateOrderEmail($data);

        $order = new PurchasePrepareRepository();
        $data = $order->showRepository($id, ['vendor', 'detail', 'detail.product']);
        return new EmailsCreateOrderEmail($data);

        // $prepare_order = new PurchasePrepareRepository();
        // $prepare_order_data = $prepare_order->dataRepository()->where('purchase_status', 3)->whereNull('purchase_sent_date')->limit(1)->get();
        // if ($prepare_order_data) {

        //     foreach ($prepare_order_data as $prepare_order_item) {

        //         $data = $prepare_order->showRepository($prepare_order_item->purchase_id, ['vendor', 'detail', 'detail.product']);
        //         Mail::to([$data->vendor->procurement_vendor_email, config('website.warehouse')])->send(new EmailsCreateOrderEmail($data));
        //         $data->purchase_sent_date = date('Y-m-d H:i:s');
        //         $data->save();
        //     }
        // }
    }

    public function branch()
    {
        if (request()->isMethod('POST')) {
            $contact = new ContactRepository();
            $request = request()->all();
            request()->validate($contact->rules);

            $data = $contact->saveRepository($request);
            if ($data['status']) {
                try {
                    Mail::to(config('website.email'))->send(new ContactEmail($data['data']));
                } catch (Exception $e) {
                    return redirect()->back()->withErrors('Email Not Sent');
                }
            }

            return redirect()->back()->withInput();
        }

        $branch = BranchFacades::dataRepository()->get();
        return View(Helper::setViewFrontend(__FUNCTION__))->with($this->share([
            'branchs' => $branch,
        ]));
    }

    public function contact()
    {
        if (request()->isMethod('POST')) {
            $contact = new ContactRepository();
            $request = request()->all();
            request()->validate($contact->rules);

            $data = $contact->saveRepository($request);
            if ($data['status']) {
                try {
                    Mail::to(config('website.email'))->send(new ContactEmail($data['data']));
                } catch (Exception $e) {
                    return redirect()->back()->withErrors('Email Not Sent');
                }
            }

            return redirect()->back()->withInput();
        }

        $branch = BranchFacades::find(1)->first();
        return View(Helper::setViewFrontend(__FUNCTION__))->with($this->share([
            'branch' => $branch,
        ]));
    }

    public function install()
    {
        if (request()->isMethod('POST')) {
            $file = DotenvEditor::load('local.env');
            $file->setKey('DB_CONNECTION', request()->get('provider'));
            $file->setKey('DB_HOST', request()->get('host'));
            $file->setKey('DB_DATABASE', request()->get('database'));
            $file->setKey('DB_USERNAME', request()->get('username'));
            $file->setKey('DB_PASSWORD', request()->get('password'));
            $file->save();
            // dd(request()->get('provider'));
            $value = DotenvEditor::getValue('DB_CONNECTION');
            // dd($value);
            $file = DotenvEditor::setKey('DB_CONNECTION', request()->get('provider'));
            $file = DotenvEditor::save();
            // Config::write('database.connections', request()->get('provider'));
            dd(request()->all());
        }
        // rename(base_path('readme.md'), realpath('').'readme.md');
        return View('welcome');
    }

    public function cara_belanja()
    {
        return View('frontend.' . config('website.frontend') . '.pages.cara_belanja');
    }

    public function konfirmasi()
    {
        if (request()->isMethod('POST')) {
            dd(request()->all());
        }
        return View('frontend.' . config('website.frontend') . '.pages.konfirmasi');
    }

    public function product($slug = false)
    {
        // Cart::clear();
        $request = request()->all();
        $data_product = new ProductRepository();
        $product = $data_product->slugRepository($slug);
        $product_id = $product->item_product_id;

        if (request()->isMethod('POST')) {

            $rules = [
                'detail.temp_product_qty' => 'required|numeric|min:' . $product->item_product_min_order,
            ];

            $message = [
                'detail.temp_product_qty.required' => 'Qty Harus Diisi !',
                'detail.temp_product_qty.numeric' => 'Qty Harus Angka !',
                'detail.temp_product_qty.min' => 'Qty Minimal ' . $product->item_product_min_order . ' !',
            ];

            if (request()->exists('variant')) {

                $collection = collect($request['variant']);
                $qty = $collection->sum(function ($product) {
                    $qty = intval($product['temp_variant_qty']);
                    return $qty;
                });

                $variant = $request['variant'];
            } else {

                $qty = $request['detail']['temp_product_qty'];
                $variant = [];
            }

            $request['detail']['temp_product_qty'] = $qty;
            $validate = Validator::make($request, $rules, $message);

            if ($validate->fails()) {
                return redirect()->back()->withErrors($validate)->withInput();
            }

            if (Cart::getContent()->contains('id', $product_id)) {
                Cart::remove($product_id);
            }

            $attributes = [
                'detail' => $request['detail'],
                'variant' => $request['variant'] ?? [],
            ];

            Cart::add($product_id, $product->item_product_name, $product->item_product_sell, $qty, $attributes);
            $this->updatePromo();
        }

        $product->item_product_counter = $product->item_product_counter + 1;
        $product->save();
        $product_image = $data_product->getImageDetail($product->item_product_id);

        return View(Helper::setViewFrontend(__FUNCTION__))->with($this->share([
            'item' => $product,
            'images' => $product_image,
        ]));
    }

    private function updatePromo($code = null)
    {
        $promo = new PromoRepository();
        $cartPromo = Cart::getConditions()->first();

        if ($cartPromo) {
            if ($code) {

                $data = $promo->codeRepository(strtoupper($code));
            } else {

                $data = $promo->codeRepository(strtoupper($cartPromo->getName()));
            }

            $value = Cart::getSubTotal();
            $matrix = $data->marketing_promo_matrix;
            if ($matrix) {

                $string = str_replace('@value', $value, $matrix);
                $total = $value;

                try {
                    $total = Helper::calculate($string);
                } catch (\Throwable $th) {
                    $total = $value;
                }

                $promo = Cart::getConditions()->first();
                if ($promo) {
                    Cart::removeCartCondition($promo->getName());
                }

                $condition = new CartCondition(array(
                    'name' => $data->marketing_promo_code,
                    'type' => $data->marketing_promo_type == 1 ? 'Promo' : 'Voucher',
                    'target' => 'total', // this condition will be applied to cart's subtotal when getSubTotal() is called.
                    'value' => -$total,
                    'order' => 1,
                    'attributes' => array( // attributes field is optional
                        'name' => $data->marketing_promo_name,
                    ),
                ));

                Cart::condition($condition);
            }
        }
    }

    /*
    File upload
     */
    public function dropzone(Request $request)
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
                ProductFacades::saveImageDetail($code, $save_name);
            }

            return response()->json(['status' => 1]);
        }
    }

    public function detail($slug)
    {
        if (!empty($slug)) {
            $data = DB::table('products')
                ->select(['products.*', 'category.name as categoryName'])
                ->leftJoin('category', 'category.id', 'products.category_id')
                ->where('products.slug', $slug)->first();
            return View('frontend.' . config('website.frontend') . '.pages.detail')->with([
                'data' => $data,
                'category' => Helper::createOption('category-api'),
                'tag' => Helper::createOption('tag-api'),
            ]);
        }
    }

    public function stock()
    {
        if (request()->has('id')) {
            $id = request()->get('id');
            $stock = DB::table('view_stock_product')->leftJoin((new Product())->getTable(), 'product', 'item_product_id')->where('id', $id)->first();
            if ($stock && $stock->item_product_min > $stock->qty) {
                return 'Stock Only ' . $stock->qty;
            }

            return 0;
        }
    }
}
