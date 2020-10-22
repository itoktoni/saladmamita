<?php

namespace Modules\Rajaongkir\Dao\Models;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    protected $table = 'rajaongkir_cities';
    protected $primaryKey = 'rajaongkir_city_id';
    protected $fillable = [
    'rajaongkir_city_id',
    'rajaongkir_city_province_id',
    'rajaongkir_city_province_name',
    'rajaongkir_city_type',
    'rajaongkir_city_name',
    'rajaongkir_city_postal_code',
  ];

    public $timestamps = false;
    public $incrementing = true;
    public $rules = [
    'rajaongkir_city_province_id' => 'required',
    'rajaongkir_city_name' => 'required',
    'rajaongkir_city_postal_code' => 'required',
  ];

    const CREATED_AT = 'rajaongkir_city_created_at';
    const UPDATED_AT = 'rajaongkir_city_created_by';

    public $searching = 'rajaongkir_city_name';
    public $datatable = [
    'rajaongkir_city_id'          => [false => 'ID'],
    'rajaongkir_city_province_name'        => [true => 'Province'],
    'rajaongkir_city_name'        => [true => 'City'],
    'rajaongkir_city_type'        => [true => 'Tipe'],
  ];
}
