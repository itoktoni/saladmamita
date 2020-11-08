<?php

namespace Modules\Crm\Dao\Models;

use Illuminate\Database\Eloquent\Model;
use Modules\Rajaongkir\Dao\Models\Area;

class Customer extends Model
{
  protected $table = 'crm_customer';
  protected $primaryKey = 'crm_customer_id';
  protected $fillable = [
    'crm_customer_id',
    'crm_customer_name',
    'crm_customer_contact_description',
    'crm_customer_contact_address',
    'crm_customer_contact_email',
    'crm_customer_contact_phone',
    'crm_customer_contact_person',
    'crm_customer_contact_rajaongkir_area_id',
    'crm_customer_delivery_name',
    'crm_customer_delivery_description',
    'crm_customer_delivery_address',
    'crm_customer_delivery_email',
    'crm_customer_delivery_phone',
    'crm_customer_delivery_person',
    'crm_customer_delivery_rajaongkir_area_id',
    'crm_customer_invoice_name',
    'crm_customer_invoice_description',
    'crm_customer_invoice_address',
    'crm_customer_invoice_email',
    'crm_customer_invoice_phone',
    'crm_customer_invoice_person',
    'crm_customer_invoice_rajaongkir_area_id',
  ];

  public $timestamps = true;
  public $incrementing = true;
  public $rules = [
    'crm_customer_name' => 'required|min:3',
  ];

  const CREATED_AT = 'crm_customer_created_at';
  const UPDATED_AT = 'crm_customer_updated_at';

  public $searching = 'crm_customer_name';
  public $datatable = [
    'crm_customer_id'          => [false => 'ID'],
    'crm_customer_name'        => [true => 'Name'],
    'crm_customer_contact_email' => [true => 'Email'],
    'crm_customer_contact_phone' => [true => 'Phone'],
    'crm_customer_contact_person' => [true => 'Contact Person'],
    'crm_customer_contact_rajaongkir_area_id' => [false => 'Area ID'],
    'rajaongkir_area_id' => [false => 'Area ID'],
    'rajaongkir_area_province_name' => [false => 'Province'],
    'rajaongkir_area_city_name' => [false => 'City'],
    'rajaongkir_area_type' => [false => 'Type'],
    'rajaongkir_area_name' => [false => 'Area'],
    'crm_customer_contact_address' => [false => 'Address'],
  ];

  public $status = [
    '1' => ['Active', 'primary'],
    '0' => ['Not Active', 'danger'],
  ];

    public function area()
    {
        return $this->hasOne(Area::class, 'rajaongkir_area_id', 'crm_customer_contact_rajaongkir_area_id');
    }
}
