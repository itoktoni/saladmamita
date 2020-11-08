<?php

namespace Modules\Rajaongkir\Dao\Models;

use Illuminate\Database\Eloquent\Model;

class Paket extends Model
{
  protected $table = 'rajaongkir_paket';
  protected $primaryKey = 'rajaongkir_paket_code';
  protected $fillable = [
    'rajaongkir_paket_code',
    'rajaongkir_paket_name',
    'rajaongkir_paket_estimasi',
    'rajaongkir_paket_description',
  ];

  public $timestamps = false;
  public $incrementing = true;
  public $rules = [
    'rajaongkir_paket_name' => 'required',
  ];

  const CREATED_AT = 'rajaongkir_paket_created_at';
  const UPDATED_AT = 'rajaongkir_paket_created_by';

  public $searching = 'rajaongkir_paket_name';
  public $datatable = [
    'rajaongkir_paket_code'          => [true => 'Code'],
    'rajaongkir_paket_name'        => [true => 'Name'],
    'rajaongkir_paket_estimasi'        => [true => 'Estimasi Hari'],
    'rajaongkir_paket_description'        => [true => 'Description'],
  ];

  public $keyType = 'string';
}
