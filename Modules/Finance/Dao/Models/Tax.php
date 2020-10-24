<?php

namespace Modules\Finance\Dao\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;

class Tax extends Model
{
  protected $table = 'finance_tax';
  protected $primaryKey = 'finance_tax_id';
  protected $fillable = [
    'finance_tax_id',
    'finance_tax_name',
    'finance_tax_type',
    'finance_tax_value',
    'finance_tax_description',
  ];

  public $timestamps = false;
  public $incrementing = true;
  public $rules = [
    'finance_tax_name' => 'required|min:3|unique:finance_tax',
  ];

  const CREATED_AT = 'finance_tax_created_at';
  const UPDATED_AT = 'finance_tax_created_by';
  public $searching = 'finance_tax_name';
  public $datatable = [
    'finance_tax_id' => [false => 'Code'],
    'finance_tax_name' => [true => 'Name'],
    'finance_tax_type' => [true => 'Type'],
    'finance_tax_value' => [true => 'Value'],
    'finance_tax_description' => [true => 'Description'],
  ];

  public $status = [
    'IN' => ['Include Tax', 'success'],
    'EX' => ['Exclude Tax', 'danger'],
  ];

}
