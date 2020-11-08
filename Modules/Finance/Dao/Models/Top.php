<?php

namespace Modules\Finance\Dao\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;

class Top extends Model
{
  protected $table = 'finance_top';
  protected $primaryKey = 'finance_top_code';
  protected $fillable = [
    'finance_top_code',
    'finance_top_name',
    'finance_top_description',
  ];

  public $timestamps = false;
  public $incrementing = false;
  public $rules = [
    'finance_top_name' => 'required|min:3|unique:finance_top',
  ];

  const CREATED_AT = 'finance_top_created_at';
  const UPDATED_AT = 'finance_top_created_by';
  public $searching = 'finance_top_name';
  public $datatable = [
    'finance_top_code' => [true => 'Code'],
    'finance_top_name' => [true => 'Name'],
    'finance_top_description' => [true => 'Description'],
  ];

  public $status = [
    '1' => ['IN', 'success'],
    '0' => ['OUT', 'danger'],
  ];

  public static function boot()
  {
    parent::boot();
  }
}
