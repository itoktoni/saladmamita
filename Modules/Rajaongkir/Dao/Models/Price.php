<?php

namespace Modules\Rajaongkir\Dao\Models;

use Illuminate\Database\Eloquent\Model;

class Price extends Model
{
  protected $table = 'rajaongkir_price';
  protected $primaryKey = 'rajaongkir_price_code';
  protected $fillable = [
    'rajaongkir_price_code',
    'rajaongkir_price_from',
    'rajaongkir_price_to',
    'rajaongkir_price_top',
    'rajaongkir_price_value',
  ];

  public $timestamps = false;
  public $incrementing = false;
  public $rules = [
    'rajaongkir_paket_name' => 'required',
  ];

  const CREATED_AT = 'rajaongkir_price_created_at';
  const UPDATED_AT = 'rajaongkir_price_created_by';

  public $searching = 'rajaongkir_paket_name';
  public $keyType = 'string';
  public $datatable = [
    'rajaongkir_price_code'        => [false => 'Code'],
    'from_city'        => [true => 'Kota Asal'],
    'from_name'        => [true => 'Asal'],
    'to_city'        => [true => 'Tujuan'],
    'to_name'        => [true => 'Area'],
    'postcode'        => [true => 'Zipcode'],
    'finance_top_name'        => [true => 'Top'],
    'rajaongkir_paket_name'        => [true => 'Paket'],
    'rajaongkir_price_value'        => [true => 'Harga'],
  ];
}
