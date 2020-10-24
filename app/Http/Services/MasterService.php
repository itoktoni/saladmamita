<?php

namespace App\Http\Services;

use Yajra\DataTables\Facades\DataTables;
use Plugin\Alert;
use Plugin\Helper;
use App\Dao\Interfaces\MasterInterface;

class MasterService
{
    public function setModel(MasterInterface $repository)
    {
        if ($this->model == null) {
            $this->model = $repository->dataRepository();
        }

        return $this;
    }

    public function setFilter(MasterInterface $repository)
    {
        if ($this->model == null) {
            $this->setModel($repository);
        }
        $this->filter = Helper::filter($this->model);
        return $this;
    }

    public function setSearching(MasterInterface $repository)
    {
        if ($this->model == null) {
            $this->setModel($repository);
        }
        if ($this->filter == null) {
            $this->setFilter($repository);
        }

        $query = $this->filter;
        $request = request()->all();

        if (!empty($request['search'])) {
            $code         = $request['code'];
            $search       = $request['search'];
            $aggregate    = $request['aggregate'];
            $search_field = empty($code) ? $repository->searching : $code;
            $aggregation  = empty($aggregate) ? 'like' : $aggregate;
            $input        = empty($aggregate) ? "%$search%" : "$search";
            $query->where($search_field, $aggregation, $input);
        }
        $this->searching = $query;
        return $this;
    }

    public function setRaw(array $raw)
    {
        $this->raw = $raw;
        return $this;
    }

    public function datatable(MasterInterface $repository)
    {
        $this->data = $repository->dataRepository();
        $this->filter = Helper::filter($this->data);
        $request = request()->all();

        if (!empty($request['search'])) {
            $code         = $request['code'] ?? null;
            $search       = $request['search'] ?? null;
            $aggregate    = $request['aggregate'] ?? null;
            $search_field = empty($code) ? $repository->searching : $code;
            $aggregation  = empty($aggregate) ? 'like' : $aggregate;
            $input        = empty($aggregate) ? "%$search%" : "$search";
            $this->filter->where($search_field, $aggregation, $input);
        }

        $datatable = Datatables::of($this->filter);

        $rawColumns = ['action', 'checkbox'];
        if (request()->ajax()) {
            $datatable->addColumn('checkbox', Helper::setViewCheckbox());
            $datatable->addColumn('action', Helper::setViewAction());

            // set action
            if (!empty($this->raw)) {

                foreach ($this->raw as $keyColumn => $valColumn) {

                    $datatable->editColumn($keyColumn, $valColumn);
                }
                
                $rawColumns = array_merge($rawColumns, array_keys($this->raw));
            }
        }

        $datatable->rawColumns($rawColumns);
        return $datatable;
    }

    public function save(MasterInterface $repository, $request)
    {
        $check = false;
        try {
            $check = $repository->saveRepository($request);
            Alert::create();
        } catch (\Throwable $th) {
            Alert::error($th->getMessage());
            return $th->getMessage();
        }

        return $check;
    }

    public function delete(MasterInterface $repository)
    {
        $rules = ['id' => 'required'];
        // valdiate rules
        request()->validate($rules, ['id.required' => 'Please select any data !']);
        $check = $repository->deleteRepository(request()->get('id'));
        if ($check['status']) {
            Alert::delete();
        } else {
            Alert::error($check['data']);
        }
    }

    public function update(MasterInterface $repository, $request)
    {
        $id = request()->query('code');
        $check = $repository->updateRepository($id, $request);
        if ($check['status']) {
            Alert::update();
        } else {
            Alert::error($check['data']);
        }
    }

    public function show(MasterInterface $repository, $relation = false)
    {
        $id   = request()->get('code');
        return $repository->showRepository($id, $relation);
    }
}
