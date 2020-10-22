<?php

namespace Modules\Marketing\Dao\Models;

use Plugin\Helper;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
  protected $table = 'marketing_service';
  protected $primaryKey = 'marketing_service_id';
  protected $fillable = [
    'marketing_service_id',
    'marketing_service_name',
    'marketing_service_icon',
    'marketing_service_description',
  ];

  public $timestamps = false;
  public $incrementing = true;
  public $rules = [
    'marketing_service_name' => 'required|min:3',
  ];

  const CREATED_AT = 'marketing_service_created_at';
  const UPDATED_AT = 'marketing_service_created_by';

  public $searching = 'marketing_service_name';
  public $datatable = [
    'marketing_service_id'          => [false => 'ID'],
    'marketing_service_name'        => [true => 'Name'],
    'marketing_service_description'        => [true => 'Description'],
    'marketing_service_icon'        => [false => 'Icon'],
  ];

  
}