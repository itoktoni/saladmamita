<?php

namespace App\Http\Controllers;

use App;
use App\Dao\Facades\BranchFacades;
use App\Dao\Repositories\BranchRepository;
use App\Dao\Repositories\TeamRepository;
use Barryvdh\DomPDF\Facade as PDF;
use Carbon\Carbon;
use Darryldecode\Cart\CartCondition;
use Darryldecode\Cart\Facades\CartFacade as Cart;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Intervention\Image\Facades\Image;
use Ixudra\Curl\Facades\Curl;
use Jackiedo\DotenvEditor\Facades\DotenvEditor;
use Modules\Finance\Dao\Facades\BankFacades;
use Modules\Finance\Dao\Repositories\BankRepository;
use Modules\Item\Dao\Facades\ProductFacades;
use Modules\Item\Dao\Models\Product;
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
use Modules\Marketing\Dao\Repositories\PageRepository;
use Modules\Marketing\Dao\Repositories\PromoRepository;
use Modules\Marketing\Dao\Repositories\SliderRepository;
use Modules\Marketing\Dao\Repositories\SosmedRepository;
use Modules\Marketing\Emails\ContactEmail;
use Modules\Rajaongkir\Dao\Repositories\DeliveryRepository;
use Modules\Rajaongkir\Dao\Repositories\ProvinceRepository;
use Modules\Sales\Dao\Facades\OrderFacades;
use Modules\Sales\Dao\Facades\SubscribeFacades;
use Modules\Sales\Dao\Models\Area;
use Modules\Sales\Dao\Models\City;
use Modules\Sales\Dao\Models\Province;
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
        $page = Helper::createOption(new PageRepository(), false, true);

        $view = [
            'sosmed' => $sosmed,
            'category' => $category,
            'product' => $product,
            'page' => $page,
        ];

        return array_merge($view, $data);
    }

    public function index($slug = false)
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
        $object_product = new ProductRepository();
        $product = $object_product->dataRepository();
        
        if(request()->has('type')){
            if(request()->get('type') == 'category'){
                $data = Helper::shareOption(new CategoryRepository(), false, true);
                return View(Helper::setViewFrontend(__FUNCTION__.'_category'))->with($this->share([
                    'product' => $data,
                ]));
            }
            else{
                $data = $product->where('item_category_slug', request()->get('type'))->get();
                return View(Helper::setViewFrontend(__FUNCTION__))->with($this->share([
                    'product' => $data,
                ]));
            }
        }

        $data = $product->get();
        return View(Helper::setViewFrontend(__FUNCTION__))->with($this->share([
            'product' => $data,
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
        $order = new OrderRepository();
        $data = $order->dataRepository()->select('*')->where('sales_order_to_phone', auth()->user()->phone)->orderBy('sales_order_date_order', 'DESC')->get();
        return View(Helper::setViewFrontend(__FUNCTION__))->with($this->share([
            'status' => Helper::shareStatus($order->status),
            'order' => $data,
        ]));
    }

    public function page($slug = false)
    {
        if ($slug) {
            $page = new PageRepository();
            $data = $page->where('marketing_page_slug', $slug)->first();
            if (!$data) {
                abort(404, 'Page not found !');
            }

            return View(Helper::setViewFrontend('page'))->with($this->share([
                'data' => $data,
            ]));
        }

        abort(404, 'Page not found !');
    }

    public function slider($slug = false)
    {
        if ($slug) {
            $slider = new SliderRepository();
            $data = $slider->dataRepository()->where('marketing_slider_slug', $slug)->first();
            if (!$data) {
                abort(404, 'Page not found !');
            }

            return View(Helper::setViewFrontend('slider'))->with($this->share([
                'data' => $data,
            ]));
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
        // session()->forget('area');
        if (request()->has('token')) {
            $token = request()->get('token');
            $data = OrderFacades::where('sales_order_token', $token)->firstOrFail();
            $pasing = [
                'master' => $data,
                'detail' => $data->detail,
                'banks' => BankFacades::dataRepository()->first(),
            ];
            $pdf = PDF::loadView(Helper::setViewPrint('print_order'), $pasing)->setPaper('A4', 'potrait');
            return $pdf->stream();
        }

        if (request()->isMethod('POST')) {
            $request = request()->all();
            $autonumber = Helper::autoNumber(OrderFacades::getTable(), OrderFacades::getKeyName(), 'SO' . date('Ym'), config('website.autonumber'));

            if (request()->has('sales_order_to_area')) {
                $area_id = request()->get('sales_order_to_area');
                session()->put('area', Helper::getSingleArea($area_id, false, true));
            }

            // if (isset($request['sales_order_to_area'])) {
            //     $area_id = $request['sales_order_to_area'];
            //     $area = Helper::getSingleArea($area_id, false, true);
            // }

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
                'sales_order_to_email' => 'sometimes|email',
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
                // 'sales_order_to_email.required' => 'Email Harus Diisi',
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
            } else {
                return redirect()->route('checkout', ['token' => $check['data']->sales_order_token->toString()]);
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
        $location = $langganan_data = $carbon = [];

        if (request()->has('token')) {
            $token = request()->get('token');
            $data = SubscribeFacades::where('sales_langganan_token', $token)->firstOrFail();
            $pasing = [
                'master' => $data,
                'detail' => $data->order,
                'banks' => BankFacades::dataRepository()->first(),
            ];
            $pdf = PDF::loadView(Helper::setViewPrint('print_langganan'), $pasing);
            return $pdf->stream();
        }

        if (request()->has('sales_langganan_date_order')) {
            $date = request()->get('sales_langganan_date_order');
            $carbon = Carbon::createFromFormat('Y-m-d', $date);
        }

        if (request()->has('sales_langganan_to_area')) {
            $area_id = request()->get('sales_langganan_to_area');
            $location = Helper::getSingleArea($area_id, false, true);
        }

        if (request()->has('area')) {
            $area_id = request()->get('area');
            $location = Helper::getSingleArea($area_id, false, true);
        }

        if (request()->has('code')) {
            $code = request()->get('code');
            $langganan_data = LanggananFacades::showRepository($code);
        }

        if (request()->isMethod('POST')) {
            $request = request()->all();
            
            $rules2 = [
                'sales_langganan_to_name' => 'required',
                'sales_langganan_to_phone' => 'required',
                'sales_langganan_to_email' => 'sometimes|email',
                'sales_langganan_to_address' => 'required',
                'sales_langganan_from_id' => 'required',
                'sales_langganan_date_order' => 'required',
                'sales_langganan_marketing_langganan_id' => 'required',
                'province' => 'required',
                'city' => 'required',
                'sales_langganan_to_area' => 'required',
            ];

            $message2 = [
                'province.required' => 'Province Harus Diisi',
                'city.required' => 'Kota Harus Diisi',
                'sales_langganan_to_area.required' => 'Lokasi Harus Diisi',
                'sales_langganan_to_name.required' => 'Nama Customer Harus Diisi',
                'sales_langganan_to_phone.required' => 'No. Telp Harus Diisi',
                'sales_langganan_to_address.required' => 'Alamat Harus Diisi',
                'sales_langganan_to_email.email' => 'Email Tidak Valid',
                'sales_langganan_from_id.required' => 'Lokasi Pickup Harus Diisi',
                'sales_langganan_date_order.required' => 'Tanggal Pengiriman Harus Diisi',
                'sales_langganan_marketing_langganan_id.required' => 'Paket Berlangganan Harus Diisi',
            ]; 
            // $validate_first = Validator::make($request, $rules2, $message2);
            // if ($validate_first->fails()) {
            //     // return redirect()->back()->withErrors($validate_first)->withInput([
            //     //     'location' => $location,
            //     //     'sales_langganan_marketing_langganan_id' => request()->get('sales_langganan_marketing_langganan_id')
            //     // ]);
            //     return redirect()->back()->withErrors($validate_first)->withInput();
            // }
            
            if (request()->has('pilih')) {
                
                return redirect()->route('langganan', ['code' => request()->get('sales_langganan_marketing_langganan_id'), 'area' => request()->get('sales_langganan_to_area'), 'date' => $date, 'branch' => request()->get('sales_langganan_from_id')])->withInput();
            }

            
            
            $order_date = $request['sales_langganan_date_order'];

            $backdate = date('Y-m-d', strtotime($order_date. ' -1 month'));
            $jumlah_hari = $request['jumlah_hari'];
            $list_date = [];
            for($i=1;$i <= 90;$i++){
                $carbon_date = date('D', strtotime($backdate. ' + '.$i.' days'));
                if($carbon_date == 'Sun'){
                    $list_date[] = date('Y-m-d', strtotime($backdate. ' + '.$i.' days'));
                }
            }  

            $validasi = [];
            if (isset($request['detail'])) {
                
                $rules = [
                    'detail.*.langganan_date' => Rule::notIn($list_date),
                    'sales_langganan_to_name' => 'required',
                    'sales_langganan_to_phone' => 'required',
                    'sales_langganan_to_email' => 'sometimes|email',
                    'sales_langganan_to_address' => 'required',
                    'sales_langganan_from_id' => 'required',
                    'sales_langganan_date_order' => 'required',
                    'sales_langganan_date_order' => 'required',
                    'sales_langganan_marketing_langganan_id' => 'required',
                    'province' => 'required',
                    'city' => 'required',
                    'sales_langganan_to_area' => 'required',
                    'files' => 'required|mimes:png,jpg,jpeg,pdf|max:4048',
                    // 'sales_langganan_discount_code' => 'sometimes|exists:marketing_promo,marketing_promo_code',
                ];
                
                $message = [
                    'sales_langganan_to_name.required' => 'Nama Customer Harus Diisi',
                    'sales_langganan_marketing_langganan_id.required' => 'Paket Langganan Harus Diisi',
                    'sales_langganan_to_phone.required' => 'No. Telp Harus Diisi',
                    'sales_langganan_to_address.required' => 'Alamat Harus Diisi',
                    // 'sales_langganan_to_email.required' => 'Email Harus Diisi',
                    'sales_langganan_to_email.email' => 'Email Tidak Valid',
                    'sales_langganan_from_id.required' => 'Lokasi Pickup Harus Diisi',
                    'sales_langganan_date_order.required' => 'Tanggal Pengiriman Harus Diisi',
                    'sales_langganan_marketing_langganan_id.required' => 'Paket Berlangganan Harus Diisi',
                    // 'sales_langganan_discount_code.exists' => 'Voucher Not Valid !',
                    'files.required' => 'Bukti pembayaran harus diisi',
                    'files.mimes' => 'format document harus png, jpeg, jpg, atau pdf',
                    'files.max' => 'format document tidak lebih dari 4mb',
                    'province.required' => 'Province Harus Diisi',
                    'city.required' => 'Kota Harus Diisi',
                    'sales_langganan_to_area.required' => 'Lokasi Harus Diisi',
                ];
                
                $validate = Validator::make($request, $rules, $message);
                if ($validate->fails()) {
                    return redirect()->back()->withErrors($validate)->withInput();
                }
                
                $grand_total = $discount_total = 0;
                $discount_name = null;

                $file = request()->file('files');
                if (!empty($file)) //handle images
                {
                  $name = Helper::uploadFile($file, 'payment');
                  $request['file'] = $name;
                }
                
                $repo = new SubscribeRepository();
                $check = $service->save($repo, $request);
                if (isset($check['status']) && $check['status']) {
                    return redirect()->route('langganan', ['token' => $check['data']->sales_langganan_token->toString()]);
                }

            }
        }

        if (Auth::check() && empty($location)) {
            $location = Helper::getSingleArea(auth()->user()->area, false, true);
        }

        $carts = Cart::getContent();
        $list_province = Helper::createOption(new ProvinceRepository());
        $branch = Helper::createOption(new BranchRepository());
        $user = Auth::user() ?? [];
        $metode = Helper::createOption(new DeliveryRepository());
        $langganan = Helper::createOption(new LanggananRepository(),false,true);
        // $product = Helper::createOption(new ProductRepository(), false, true, true)->where('item_product_langganan', 1);
        $holiday = Helper::createOption(new HolidayRepository(), false, true, true)->where('item_product_langganan', 1);
        $data_bank = Helper::createOption(new BankRepository(), false, true, true);
        $bank = $data_bank->mapWithKeys(function($dbank){
            return [$dbank->finance_bank_id => $dbank->finance_bank_name.' - '.$dbank->finance_bank_account_number.' ('.$dbank->finance_bank_account_name.')'];
        }); 

        return View(Helper::setViewFrontend(__FUNCTION__))->with($this->share([
            'carts' => $carts,
            'list_province' => $list_province,
            'branch' => $branch,
            'user' => $user,
            'bank' => $bank,
            'location' => $location,
            'metode' => $metode,
            'langganan' => $langganan,
            'langganan_data' => $langganan_data,
            // 'product' => $product,
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
                'payment_person' => 'required',
                'code' => 'required',
                'payment_person' => 'required',
                'payment_phone' => 'required',
                'payment_value' => 'required',
                'payment_email' => 'required|email',
                'payment_date' => 'required',
                'files' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            ];
            
            $message = [
                'payment_person.required' => 'Nama Pengirim Harus Diisi',
                'payment_value.required' => 'Jumlah Pembayaran Harus Diisi',
                'code.required' => 'No. Order Harus Diisi',
                // 'code.exists' => 'No. Order Tidak',
                'files.required' => 'Bukti Transfer Harus Upload',
            ];

            $validate = Validator::make($request, $rules, $message);

            if ($validate->fails()) {
                return redirect()->back()->withErrors($validate)->withInput();
            }

            if (OrderFacades::find($request['code'])) {

                $update = OrderFacades::showRepository($request['code']);
                $check['status'] = false;
                if ($update) {

                    $file = 'files';
                    $name = null;
                    if (request()->has($file)) {

                        $file = request()->file($file);
                        $name = Helper::uploadImage($file, 'payment');

                    }
                    
                    $request['sales_order_payment_person'] = $request['payment_person'];
                    $request['sales_order_payment_bank_to_id'] = $request['payment_bank'];
                    $request['sales_order_payment_date'] = $request['payment_date'];
                    $request['sales_order_payment_notes'] = $request['payment_notes'];

                    $request['sales_order_term_top'] = 'CASH';
                    $request['sales_order_payment_file'] = $name;
                    $check = OrderFacades::updateRepository($request['code'], $request);
                }

                if ($check['status']) {
                    return redirect()->route('confirmation')->with('success', 'Data has been Success');
                }

            } else if (SubscribeFacades::find($request['code'])) {
                $update = SubscribeFacades::showRepository($request['code']);
                $check['status'] = false;
                if ($update) {

                    $file = 'files';
                    $name = null;
                    if (request()->has($file)) {

                        $file = request()->file($file);
                        $name = Helper::uploadImage($file, 'payment');

                    }

                    $request['sales_langganan_payment_person'] = $request['payment_person'];
                    $request['sales_langganan_payment_bank_to_id'] = $request['payment_bank'];
                    $request['sales_langganan_payment_date'] = $request['payment_date'];
                    $request['sales_langganan_payment_notes'] = $request['payment_notes'];

                    $request['sales_langganan_term_top'] = 'CASH';
                    $request['sales_langganan_payment_file'] = $name;
                    $check = SubscribeFacades::updateRepository($request['code'], $request);
                }

                if ($check['status']) {
                    return redirect()->route('confirmation')->with('success', 'Data has been Success');
                }
            } else {
                $validate->errors()->add('code', 'Nomer Order tidak Terdaftar !');
                return redirect()->back()->withErrors($validate)->withInput();
            }

        }

        return View(Helper::setViewFrontend(__FUNCTION__))->with($this->share([
            'bank' => Helper::shareOption($bank, false, true)->pluck('finance_bank_name', 'finance_bank_name'),
        ]));
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

        $branch = BranchFacades::dataRepository()->get()->sortBy('branch_id');
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

        $branch = BranchFacades::find(4);
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
        $data_product = new ProductRepository();
        $product = $data_product->slugRepository($slug);
        $product_id = $product->item_product_id;

        if (request()->isMethod('POST')) {

            $request = request()->all();
            $rules = [
                'detail.temp_product_qty' => 'required|numeric|min:' . $product->item_product_min_order,
            ];

            $message = [
                'detail.temp_product_qty.required' => 'Qty Harus Diisi !',
                'detail.temp_product_qty.min' => 'Qty Minimal ' . $product->item_product_min_order . ' !',
                'detail.temp_product_qty.numeric' => 'Qty Harus Angka !',
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
        // $product->item_product_counter = $product->item_product_counter + 1;
        // $product->save();
        $product_image = $data_product->getImageDetail($product->item_product_id) ?? [];
        $variants = $data_product->variant($product->item_product_id) ?? [];
        return View(Helper::setViewFrontend(__FUNCTION__))->with($this->share([
            'item' => $product,
            'variants' => $variants,
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