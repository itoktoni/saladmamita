<?php

namespace Modules\Marketing\Dao\Models;

use Plugin\Helper;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\Model;

class Testimony extends Model
{
    protected $table = 'marketing_testimony';
    protected $primaryKey = 'marketing_testimony_id';
    protected $fillable = [
    'marketing_testimony_id',
    'marketing_testimony_name',
    'marketing_testimony_description',
    'marketing_testimony_image',
  ];

    public $timestamps = false;
    public $incrementing = true;
    public $rules = [
    'marketing_testimony_name' => 'required|min:3|unique:marketing_testimony',
    'marketing_testimony_file' => 'file|image|mimes:jpeg,png,jpg|max:4048',
  ];

    const CREATED_AT = 'marketing_testimony_created_at';
    const UPDATED_AT = 'marketing_testimony_created_by';

    public $searching = 'marketing_testimony_name';
    public $datatable = [
    'marketing_testimony_id'          => [false => 'ID'],
    'marketing_testimony_name'        => [true => 'Name'],
    'marketing_testimony_description' => [true => 'Description'],
    'marketing_testimony_image'        => [true => 'Images'],
  ];

    public $status = [
    '1' => ['Active', 'primary'],
    '0' => ['Not Active', 'danger'],
  ];
}
