<?php

namespace Modules\Marketing\Dao\Models;

use Plugin\Helper;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\Model;

class Slider extends Model
{
  protected $table = 'marketing_slider';
  protected $primaryKey = 'marketing_slider_id';
  protected $fillable = [
    'marketing_slider_id',
    'marketing_slider_name',
    'marketing_slider_slug',
    'marketing_slider_description',
    'marketing_slider_page',
    'marketing_slider_link',
    'marketing_slider_button',
    'marketing_slider_image',
    'marketing_slider_created_at',
    'marketing_slider_created_by',
  ];

  public $timestamps = true;
  public $incrementing = true;
  public $rules = [
    'marketing_slider_name' => 'required|min:3|unique:marketing_slider',
    'marketing_slider_file' => 'file|image|mimes:jpeg,png,jpg|max:4048',
  ];

  const CREATED_AT = 'marketing_slider_created_at';
  const UPDATED_AT = 'marketing_slider_created_by';

  public $searching = 'marketing_slider_name';
  public $datatable = [
    'marketing_slider_id'          => [false => 'ID'],
    'marketing_slider_name'        => [true => 'Name'],
    'marketing_slider_button'        => [false => 'Button'],
    'marketing_slider_link'        => [false => 'Link'],
    'marketing_slider_slug'        => [false => 'Slug'],
    'marketing_slider_page'        => [false => 'Slug'],
    'marketing_slider_description' => [true => 'Description'],
    'marketing_slider_image'        => [true => 'Images'],
    'marketing_slider_created_by'  => [false => 'Updated At'],  
  ];

  public $status = [
    '1' => ['Active', 'primary'],
    '0' => ['Not Active', 'danger'],
  ];

   public static function boot()
  {
    parent::boot();
    parent::saving(function ($model) {

      $file = 'marketing_slider_file';
      if (request()->has($file)) {
        $image = $model->marketing_slider_image;
        if ($image) {
          Helper::removeImage($image, Helper::getTemplate(__CLASS__));
        }

        $file = request()->file($file);
        $name = Helper::uploadImage($file, Helper::getTemplate(__CLASS__));
        $model->marketing_slider_image = $name;
      }

      if ($model->marketing_slider_name && empty($model->marketing_slider_slug)) {
        $model->marketing_slider_slug = Str::slug($model->marketing_slider_name);
      }
    });

    parent::deleting(function ($model) {
      if (request()->has('id')) {
        $data = $model->getDataIn(request()->get('id'));
        if ($data) {
          foreach ($data as $value) {
            if ($value->marketing_slider_image) {
              Helper::removeImage($value->marketing_slider_image, Helper::getTemplate(__CLASS__));
            }
          }
        }
      }
    });
  }
}