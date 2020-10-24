<?php

namespace App\Dao\Dimentions;

use App\Observers\BranchObserver;

trait BranchDimention
{
    public static function bootBranchDimention()
    {
        static::observe(BranchObserver::class);
    }
}