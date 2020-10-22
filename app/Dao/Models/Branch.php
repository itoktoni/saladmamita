<?php

namespace App\Dao\Models;

use Illuminate\Database\Eloquent\Model;
use Modules\Rajaongkir\Dao\Models\Area;

class Branch extends Model
{
    protected $table = 'core_branch';
    protected $primaryKey = 'branch_id';
    protected $fillable = [
        'branch_name',
        'branch_company_id',
        'branch_description',
        'branch_rajaongkir_area_id',
    ];

    public $timestamps = false;

    public $incrementing = false;
    public $rules = [
        'branch_name' => 'required',
        'branch_company_id' => 'required',
        'branch_rajaongkir_area_id' => 'required',
    ];

    public $searching = 'branch_name';

    public $datatable = [
        'branch_name'           => [true    => 'Name'],
        'company_contact_name'           => [true    => 'Company'],
        'rajaongkir_area_province_name'           => [true    => 'Province'],
        'rajaongkir_area_city_name'           => [true    => 'City'],
        'rajaongkir_area_name'           => [true    => 'Area'],
        'branch_description'     => [false    => 'Notes Area'],
    ];

    public $status    = [
        '1' => ['Show', 'info'],
        '0' => ['Hide', 'default'],
    ];

    public function area()
	{
		return $this->hasOne(Area::class, 'rajaongkir_area_id', 'branch_rajaongkir_area_id');
	}
}
