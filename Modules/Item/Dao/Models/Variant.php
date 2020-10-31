<?php

namespace Modules\Item\Dao\Models;

use Plugin\Helper;
use Illuminate\Support\Str;
use Modules\Item\Dao\Models\Product;
use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\Model;
use Modules\Item\Dao\Facades\ProductFacades;
use Modules\Item\Dao\Facades\CategoryFacades;

class Variant extends Model
{
    protected $table = 'item_variant';
    protected $primaryKey = 'item_variant_id';
    protected $fillable = [
        'item_variant_id',
        'item_variant_name',
        'item_variant_description',
        'item_variant_created_at',
        'item_variant_created_by',
        'item_variant_image',
        'item_variant_item_category_id',
    ];

    public $with = ['category'];

    public $timestamps = true;
    public $incrementing = true;
    public $rules = [
        'item_variant_name' => 'required|min:3',
    ];

    const CREATED_AT = 'item_variant_created_at';
    const UPDATED_AT = 'item_variant_created_by';

    public $searching = 'item_variant_name';
    public $datatable = [
        'item_category_name' => [true => 'Category'],
        'item_variant_name' => [true => 'Variant'],
        'item_variant_item_category_id' => [false => 'Variant'],
        'item_variant_description' => [false => 'Description'],
        'item_variant_image' => [true => 'Images'],
        'item_variant_created_at' => [false => 'Created At'],
        'item_variant_created_by' => [false => 'Updated At'],
    ];

    public $status = [
        '1' => ['Active', 'primary'],
        '0' => ['Not Active', 'danger'],
    ];

    public function category()
    {
        return $this->hasOne(Category::class, CategoryFacades::getKeyName(), 'item_variant_item_category_id');
    }

    public static function boot()
    {
        parent::boot();

        parent::saving(function ($model) {
            $file = 'item_variant_file';
            if (request()->has($file)) {
                $image = $model->item_variant_image;
                if ($image) {
                    Helper::removeImage($image, Helper::getTemplate(__CLASS__));
                }

                $file = request()->file($file);
                $name = Helper::uploadImage($file, Helper::getTemplate(__CLASS__));
                $model->item_variant_image = $name;
            }
            $model->item_variant_name = Str::upper(request()->get('item_variant_name'));

            if(request()->has('item_variant_price')){
                $price = request()->get('item_variant_price');
                if($price){
                    $model->item_variant_price = Helper::filterInput($price);
                }
                else{
                    $product = ProductFacades::dataRepository()->find(request()->get('item_variant_item_product_id'));
                    $model->item_variant_price = $product->item_product_sell ?? 0;
                }
            }

        });

        parent::deleting(function ($model) {
            if (request()->has('id')) {
                $data = $model->whereIn($model->getkeyName(), request()->get('id'))->get();
                if ($data) {
                    foreach ($data as $value) {
                        if ($value->item_variant_image) {
                            Helper::removeImage($value->item_product_image, Helper::getTemplate(__CLASS__));
                        }
                    }
                }
            }
        });
    }

}
