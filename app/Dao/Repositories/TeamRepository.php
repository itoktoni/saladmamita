<?php

namespace App\Dao\Repositories;

use Plugin\Alert;
use Plugin\Notes;
use Plugin\Helper;
use App\Dao\Models\User;
use Illuminate\Support\Facades\DB;
use App\Dao\Interfaces\MasterInterface;
use Illuminate\Database\QueryException;

class TeamRepository extends User implements MasterInterface
{
    public function dataRepository()
    {
        $list = Helper::dataColumn($this->datatable, $this->getKeyName());
        return $this->select($list);
    }

    public function saveRepository($request)
    {
        try {
            unset($request['_token']);

            if (!empty($request['password'])) {
                $request['password'] =  bcrypt($request['password']);
            } else {
                unset($request['password']);
            }

            $activity = DB::table($this->getTable())->insert($request);
            return Notes::create($activity);
        } catch (\Illuminate\Database\QueryException $ex) {
            return Notes::error($ex->getMessage());
        }
    }

    public function updateRepository($id, $request)
    {
        try {
            if (!empty($request['password'])) {
                $request['password'] =  bcrypt($request['password']);
            } else {
                unset($request['password']);
            }
            
            unset($request['_token']);
            unset($request['code']);
            $activity = DB::table($this->getTable())
              ->where($this->getKeyName(), $id)
              ->update($request);

            $activity = $this->find($id)->update($request);
            return Notes::update($request);
        } catch (QueryException $ex) {
            return Notes::error($ex->getMessage());
        }
    }

    public function updateAuthRepository($id, $request)
    {
        $check = $this->updateRepository($id, $request);
        if ($check['status']) {
            Alert::update();
        } else {
            Alert::error($check['data']);
        }

    }

    public function deleteRepository($data)
    {
        try {
            $activity = $this->Destroy(array_values($data));
            return Notes::delete($activity);
        } catch (\Illuminate\Database\QueryException $ex) {
            return Notes::error($ex->getMessage());
        }
    }

    public function showRepository($id, $relation = null)
    {
        if ($relation) {
            return $this->with($relation)->findOrFail($id);
        }
        return $this->findOrFail($id);
    }
}
