<?php

namespace Modules\Rajaongkir\Dao\Models;

use Illuminate\Database\Eloquent\Model;

class Province extends Model
{
  protected $table = 'rajaongkir_provinces';
  protected $primaryKey = 'rajaongkir_province_id';
  protected $fillable = [
    'rajaongkir_province_id',
    'rajaongkir_province_name',
  ];

  public $timestamps = false;
  public $incrementing = true;
  public $rules = [
    'rajaongkir_province_name' => 'required',
  ];

  const CREATED_AT = 'rajaongkir_province_created_at';
  const UPDATED_AT = 'rajaongkir_province_created_by';

  public $searching = 'rajaongkir_province_name';
  public $datatable = [
    'rajaongkir_province_id'          => [true => 'ID'],
    'rajaongkir_province_name'        => [true => 'Name'],
  ];
}
