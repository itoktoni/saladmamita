<?php

namespace Modules\Marketing\Dao\Models;

use Illuminate\Database\Eloquent\Model;

class Holiday extends Model
{
  protected $table = 'marketing_holiday';
  protected $primaryKey = 'marketing_holiday_id';
  protected $fillable = [
    'marketing_holiday_id',
    'marketing_holiday_name',
    'marketing_holiday_date',
    'marketing_holiday_description',
  ];

  public $timestamps = false;
  public $incrementing = true;
  public $rules = [
    'marketing_holiday_name' => 'required|min:3',
    'marketing_holiday_date' => 'required',
  ];

  const CREATED_AT = 'marketing_holiday_created_at';
  const UPDATED_AT = 'marketing_holiday_updated_at';

  public $searching = 'marketing_holiday_name';
  public $datatable = [
    'marketing_holiday_id'          => [false => 'ID'],
    'marketing_holiday_name'        => [true => 'Name'],
    'marketing_holiday_date' => [true => 'Day'],
    'marketing_holiday_description' => [true => 'Description'],
  ];

  public $status = [
    '1' => ['Active', 'primary'],
    '0' => ['Not Active', 'danger'],
  ];
}
