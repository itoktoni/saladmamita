<?php

namespace App\Dao\Models;

use Plugin\Helper;
use Illuminate\Database\Eloquent\Model;
use Modules\Rajaongkir\Dao\Models\Area;

class Company extends Model
{
    protected $table = 'core_company';
    protected $primaryKey = 'company_id';
    protected $fillable = [
        'company_id',
        'company_contact_name',
        'company_contact_rajaongkir_area_id',
        'company_contact_description',
        'company_contact_address',
        'company_contact_email',
        'company_contact_phone',
        'company_contact_person',
        'company_logo',
        'company_contact_sign',
        'company_delivery_name',
        'company_delivery_rajaongkir_area_id',
        'company_delivery_description',
        'company_delivery_address',
        'company_delivery_email',
        'company_delivery_phone',
        'company_delivery_person',
        'company_invoice_name',
        'company_invoice_rajaongkir_area_id',
        'company_invoice_description',
        'company_invoice_address',
        'company_invoice_email',
        'company_invoice_phone',
        'company_invoice_person',
    ];

    public $timestamps = false;

    public $incrementing = false;
    public $rules = [
        'company_contact_name' => 'required',
        'company_contact_email' => 'required|email',
        'company_contact_person' => 'required',
        'company_contact_address' => 'required',
        'company_contact_rajaongkir_area_id' => 'required',
    ];

    public $searching = 'company_contact_name';

    public $datatable = [
        'company_contact_name'           => [true    => 'Name'],
        'company_contact_email'           => [true    => 'Email'],
        'company_contact_person'           => [true    => 'Person'],
        'company_contact_phone'           => [true    => 'Phone'],
        'company_logo'           => [false    => 'Person'],
        'company_contact_sign'           => [false    => 'Person'],
        'company_contact_address'           => [false    => 'Address'],
        'company_contact_rajaongkir_area_id'           => [false    => 'Address'],
        'rajaongkir_area_id' => [false => 'ID Area'],
        'rajaongkir_area_province_name' => [false => 'Province'],
        'rajaongkir_area_city_name' => [false => 'City'],
        'rajaongkir_area_type' => [false => 'Type'],
        'rajaongkir_area_name' => [false => 'Area'],
        'company_contact_description'     => [false    => 'Description'],
    ];

    public $status    = [
        '1' => ['Show', 'info'],
        '0' => ['Hide', 'default'],
    ];

    public function contact_area()
    {
        return $this->hasOne(Area::class, 'rajaongkir_area_id', 'company_contact_rajaongkir_area_id');
    }

    public function delivery_area()
    {
        return $this->hasOne(Area::class, 'rajaongkir_area_id', 'company_delivery_rajaongkir_area_id');
    }

    public function invoice_area()
    {
        return $this->hasOne(Area::class, 'rajaongkir_area_id', 'company_invoice_rajaongkir_area_id');
    }

    public static function boot()
    {
        parent::saving(function ($model) {
            $file_name = 'logo_contact';
            if (request()->has($file_name)) {
                $image = $model->company_logo;
                if (file_exists(public_path().'files/company/'.$image)) {
                    Helper::removeImage($image, Helper::getTemplate(__CLASS__));
                }
                
                $file = request()->file($file_name);
                $name = Helper::uploadImage($file, Helper::getTemplate(__CLASS__));
                $model->company_logo = $name;
            }

            $sign_name = 'sign_contact';
            if (request()->has($sign_name)) {
                $image_sign = $model->company_contact_sign;
                if (file_exists(public_path().'files/company/'.$image_sign)) {
                    Helper::removeImage($image_sign, Helper::getTemplate(__CLASS__));
                }
                
                $sign = request()->file($sign_name);
                $name2 = Helper::uploadImage($sign, Helper::getTemplate(__CLASS__));
                $model->company_contact_sign = $name2;
            }
        });

        parent::boot();
    }
}
