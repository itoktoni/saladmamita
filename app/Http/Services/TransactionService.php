<?php

namespace App\Http\Services;

use Plugin\Alert;
use Plugin\Notes;
use Plugin\Helper;
use Illuminate\Support\Facades\DB;
use App\Http\Services\MasterService;
use App\Dao\Interfaces\MasterInterface;
use Modules\Procurement\Dao\Models\PurchaseDetail;

class TransactionService extends MasterService
{
    public function mapping(MasterInterface $repository)
    {
        $detail = [];
        $count = $repository->mapping['detail'][$repository->mapping['foreign']];
        for ($i = 0; $i < count($this->data[$count]); $i++) {
            # mapping for detail become key array 
            foreach ($repository->mapping['detail'] as $key => $val) {
                # mapping for detail become value
                $detail[$i][$key] = isset($this->data[$val][$i]) && $this->data[$val][$i] != '0' ? Helper::filterInput($this->data[$val][$i]) : null;
            }
        }
        return $detail;
    }

    public function save(MasterInterface $repository, $request)
    {
        DB::beginTransaction();
        $check = $repository->saveRepository($request);
        PurchaseDetail::insert($request['detail']);
       
        DB::commit();
        return $check;
    }

    public function update(MasterInterface $repository, $request)
    {
        $check = $repository->updateDetail($repository, $request);
        if ($check['status']) {
            Alert::create();
        } else {
            Alert::error($check['data']);
        }
        return $check;
    }

    public function updateDetail(MasterInterface $repository, $request)
    {
        $id = request()->get('code');
        DB::beginTransaction();
        $check = $repository->updateRepository($id, $request);
        foreach ($this->mapping($repository) as $value) {
            $check_detail = $repository->updateDetailRepository($id, $value);
            if (!$check_detail['status']) {
                DB::rollback();
                return Notes::error($check_detail['data']);
            }
        }
        DB::commit();
        return Notes::create($check['data']);
    }

    public  function deleteDetail(MasterInterface $repository)
    {
        $check['status'] = false;
        $check['data'] = 'Data Failed to delete !';

        if (request()->has('id')) {
            // set validation or use default validation
            // if ($this->rules == null) {
            //     $rules = ['id' => 'required'];
            //     $this->setRules($rules);
            // }
            // // valdiate rules
            // request()->validate($this->rules, ['id.required' => 'Please select any data !']);
            $check = $repository->deleteDetailRepository(request()->get('id'));
        }
        if (request()->ajax() && request()->has('code') && request()->has('detail')) {
            $code = request()->get('code');
            $detail = request()->get('detail');
            // action delete detail
            $check = $repository->deleteDetailRepository($code, $detail);
        }

        return $check;
    }

    public function delete(MasterInterface $repository)
    {
        $check = $this->deleteDetail($repository);
        if ($check['status']) {
            if ($check['data'] == 'master') {
                Alert::delete();
            }
        } else {
            Alert::error($check['data']);
        }
        return $check;
    }
}
