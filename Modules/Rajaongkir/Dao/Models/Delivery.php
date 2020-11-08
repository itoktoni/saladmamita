<?php

namespace Modules\Rajaongkir\Dao\Models;

use Illuminate\Database\Eloquent\Model;

class Delivery extends Model
{
    protected $table = 'rajaongkir_delivery';
    protected $primaryKey = 'rajaongkir_delivery_id';
    protected $fillable = [
        'rajaongkir_delivery_id',
        'rajaongkir_delivery_name',
    ];

    public $timestamps = false;
    public $incrementing = true;
    public $rules = [
        'rajaongkir_delivery_name' => 'required',
    ];

    const CREATED_AT = 'rajaongkir_delivery_created_at';
    const UPDATED_AT = 'rajaongkir_delivery_created_by';

    public $searching = 'rajaongkir_delivery_name';
    public $datatable = [
        'rajaongkir_delivery_id' => [true => 'ID'],
        'rajaongkir_delivery_name' => [true => 'Name'],
    ];
}
