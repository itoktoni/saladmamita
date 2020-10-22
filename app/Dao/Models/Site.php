<?php

namespace App\Dao\Models;

use Illuminate\Database\Eloquent\Model;

class Site extends Model
{
    protected $table = 'core_sites';
    protected $primaryKey = 'site_id';
    protected $fillable = [
        'site_id',
        'site_name',
        'site_description',
    ];
    
    public $timestamps = false;

    public $incrementing = true;
    public $rules = [
        'site_code' => 'required|unique:core_sites',
        'site_name' => 'required|min:3',
    ];

    public $searching = 'site_name';

    public $datatable = [
        'site_id'           => [true    => 'Code'],
        'site_name'         => [true    => 'Name'],
        'site_description'  => [false   => 'Description'],
    ];
}
