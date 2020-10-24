<?php

namespace Modules\Marketing\Dao\Models;

use Plugin\Helper;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\Model;

class Benefit extends Model
{
    protected $table = 'marketing_benefit';
    protected $primaryKey = 'marketing_benefit_id';
    protected $fillable = [
    'marketing_benefit_id',
    'marketing_benefit_name',
    'marketing_benefit_description',
    'marketing_benefit_image',
  ];

    public $timestamps = false;
    public $incrementing = true;
    public $rules = [
    'marketing_benefit_name' => 'required|min:3|unique:marketing_benefit',
    'marketing_benefit_file' => 'file|image|mimes:jpeg,png,jpg|max:4048',
  ];

    const CREATED_AT = 'marketing_benefit_created_at';
    const UPDATED_AT = 'marketing_benefit_created_by';

    public $searching = 'marketing_benefit_name';
    public $datatable = [
    'marketing_benefit_id'          => [false => 'ID'],
    'marketing_benefit_name'        => [true => 'Name'],
    'marketing_benefit_description' => [false => 'Description'],
    'marketing_benefit_image'        => [true => 'Images'],
  ];

    public $status = [
    '1' => ['Active', 'primary'],
    '0' => ['Not Active', 'danger'],
  ];

}
