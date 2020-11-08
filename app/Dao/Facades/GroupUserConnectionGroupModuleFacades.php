<?php
namespace App\Dao\Facades;

use Plugin\Helper;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Facade;

class GroupUserConnectionGroupModuleFacades extends Facade
{
    protected static function getFacadeAccessor()
    {
        return Str::snake(Helper::getClass(__CLASS__));
    }
}
