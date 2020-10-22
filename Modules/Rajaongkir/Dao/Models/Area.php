<?php

namespace Modules\Rajaongkir\Dao\Models;

use Illuminate\Database\Eloquent\Model;

class Area extends Model
{
  protected $table = 'rajaongkir_areas';
  protected $primaryKey = 'rajaongkir_area_id';
  protected $fillable = [
    'rajaongkir_area_id',
    'rajaongkir_area_province_id',
    'rajaongkir_area_province_name',
    'rajaongkir_area_city_id',
    'rajaongkir_area_city_name',
    'rajaongkir_area_type',
    'rajaongkir_area_name',
    'rajaongkir_area_postcode',
  ];

  public $timestamps = false;
  public $incrementing = true;
  public $rules = [
    'rajaongkir_area_name' => 'required',
  ];

  const CREATED_AT = 'rajaongkir_area_created_at';
  const UPDATED_AT = 'rajaongkir_area_created_by';

  public $searching = 'rajaongkir_area_city_name';
  public $datatable = [
    'rajaongkir_area_id'          => [false => 'ID'],
    'rajaongkir_area_name'        => [true => 'Name'],
    'rajaongkir_area_type'        => [true => 'Type'],
    'rajaongkir_area_city_name'        => [true => 'City'],
    'rajaongkir_area_province_name'        => [true => 'Province'],
    'rajaongkir_area_postcode'        => [true => 'Postcode'],
  ];
}
