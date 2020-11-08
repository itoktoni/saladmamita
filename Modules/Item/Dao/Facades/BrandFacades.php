<?php
namespace Modules\Item\Dao\Facades;

use Plugin\Helper;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Facade;

class BrandFacades extends Facade
{
    protected static function getFacadeAccessor()
    {
        return Str::snake(Helper::getClass(__CLASS__));
    }
}
