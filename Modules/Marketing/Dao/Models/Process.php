<?php

namespace Modules\Marketing\Dao\Models;

use Plugin\Helper;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\Model;

class Process extends Model
{
  protected $table = 'marketing_process';
  protected $primaryKey = 'marketing_process_id';
  protected $fillable = [
    'marketing_process_id',
    'marketing_process_name',
    'marketing_process_description',
    'marketing_process_image',
  ];

  public $timestamps = false;
  public $incrementing = true;
  public $rules = [
    'marketing_process_name' => 'required|min:3|unique:marketing_process',
    'marketing_process_file' => 'file|image|mimes:jpeg,png,jpg|max:2048',
  ];

  const CREATED_AT = 'marketing_process_created_at';
  const UPDATED_AT = 'marketing_process_created_by';

  public $searching = 'marketing_process_name';
  public $datatable = [
    'marketing_process_id'          => [true => 'ID'],
    'marketing_process_name'        => [true => 'Name'],
    'marketing_process_description' => [true => 'Description'],
    'marketing_process_image'        => [true => 'Images'],
  ];

  public $status = [
    '1' => ['Active', 'primary'],
    '0' => ['Not Active', 'danger'],
  ];
}