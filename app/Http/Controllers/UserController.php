<?php

namespace App\Http\Controllers;

use Plugin\Alert;
use Plugin\Helper;
use Plugin\Response;
use Illuminate\Http\Request;
use Modules\Sales\Dao\Models\Area;
use App\Http\Services\MasterService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use App\Dao\Repositories\SiteRepository;
use App\Dao\Repositories\TeamRepository;
use App\Http\Requests\TeamCreateRequest;
use App\Http\Requests\TeamUpdateRequest;
use Illuminate\Support\Facades\Validator;
use App\Dao\Repositories\GroupUserRepository;

class UserController extends Controller
{
    public $template;
    public $key;
    public static $model;

    public function __construct()
    {
        if (self::$model == null) {
            self::$model = new TeamRepository();
        }
        $this->key       = self::$model->getKeyName();
        $this->template  = Helper::getTemplate(__CLASS__);
    }

    public function index()
    {
        return redirect()->route($this->getModule() . '_data');
    }

    private function share($data = [])
    {
        $site = Helper::shareOption((new SiteRepository()));
        $view = [
            'key'      => self::$model->getKeyName(),
            'template' => $this->template,
            'site' => $site,
        ];

        return array_merge($view, $data);
    }

    public function create(MasterService $service, TeamCreateRequest $request)
    {
        if (request()->isMethod('POST')) {

            $data = $service->save(self::$model, $request->all());
            return Response::redirectBack($data);
        }
        return view(Helper::setViewCreate())->with($this->share());
    }

    public function resetpassword()
    {
        return view('auth.lock');
    }

    public function change_password(Request $request)
    {
        $this->validate($request, [
            'change_password' => 'required|min:8',
        ]);

        $password = $request->input('change_password');
        $data     = self::$model->find(Auth::User()->id)->update([
            'password' => bcrypt($password)
        ]);
        Alert::create('Change password success !');
        return Response::redirectToRoute('reset');
    }

    public function resetRedis()
    {
        if (Auth::check()) {

            $key = $this->key;
            $access_menu = Auth::user()->username . '_access_menu';
            $group_list = Auth::user()->username . '_group_list';
            $access_user = 'App\User_By_Id_' . Auth::user()->$key;
            Cache::has($access_menu) ? Cache::forget($access_menu) : '';
            Cache::has($group_list) ? Cache::forget($group_list) : '';
            Cache::has('tables') ? Cache::forget('tables') : '';
            Cache::has('filter') ? Cache::forget('filter') : '';
            Auth::logout();
        }
        return redirect()->to('/');
    }

    public function resetRouting()
    {
        $this->resetRedis();
        Cache::forget('routing');

        return redirect()->to('/');
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
