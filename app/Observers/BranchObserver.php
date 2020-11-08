<?php

namespace App\Observers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;

class BranchObserver
{
    protected $id;

    public function __construct()
    {
        $this->id = Auth::user()->branch;
    }
    
    public function creating(Model $model)
    {
        $model->{$model->branch} = $this->id;
    }

    public function updating(Model $model)
    {
        $model->{$model->branch} = $this->id;
    }
}
