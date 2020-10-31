<?php

namespace Modules\Item\Dao\Models;

use Plugin\Helper;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Modules\Item\Dao\Facades\BrandFacades;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Item\Dao\Facades\CategoryFacades;
use Modules\Item\Dao\Facades\ProductFacades;

class Product extends Model
{
    use SoftDeletes;
    protected $table = 'item_product';
    protected $branch = 'item_branch_id';
    protected $primaryKey = 'item_product_id';
    protected $fillable = [
        'item_product_id',
        'item_product_slug',
        'item_product_min_stock',
        'item_product_max_stock',
        'item_product_min_order',
        'item_product_max_order',
        'item_product_sku',
        'item_product_buy',
        'item_product_image',
        'item_product_sell',
        'item_product_item_category_id',
        'item_product_item_brand_id',
        'item_product_item_material_id',
        'item_product_item_unit_id',
        'item_product_branch_id',
        'item_product_item_tag_json',
        'item_product_item_tax_id',
        'item_product_item_currency_id',
        'item_product_name',
        'item_product_description',
        'item_product_updated_at',
        'item_product_created_at',
        'item_product_deleted_at',
        'item_product_updated_by',
        'item_product_created_by',
        'item_product_counter',
        'item_product_status',
        'item_product_weight',
        'item_product_group',
        'item_product_stock',
        'item_product_display',
    ];

    public $timestamps = true;
    public $incrementing = false;
    public $keyType = 'string';
    public $rules = [
        'item_product_name' => 'required|min:3',
        'item_product_sell' => 'required',
    ];

    public $with = ['category', 'brand'];

    const CREATED_AT = 'item_product_created_at';
    const UPDATED_AT = 'item_product_updated_at';
    const DELETED_AT = 'item_product_deleted_at';

    public $searching = 'item_product_name';
    public $datatable = [
        'item_product_id' => [false => 'ID'],
        'item_category_id' => [false => 'Category'],
        'item_category_name' => [false => 'Category'],
        'item_category_slug' => [false => 'Category'],
        'item_product_name' => [true => 'Product Name'],
        'item_brand_name' => [true => 'Brand'],
        'item_brand_slug' => [false => 'Brand'],
        'item_product_min_order' => [false => 'Min Order'],
        'item_product_buy' => [false => 'Buy'],
        'item_product_sell' => [true => 'Price'],
        'item_product_weight' => [false => 'Gram'],
        'item_product_stock' => [true => 'Stock'],
        'item_product_image' => [true => 'Images'],
        'item_product_slug' => [false => 'Slug'],
        'item_product_display' => [false => 'Display'],
        'item_product_item_tag_json' => [false => 'Tag'],
        'item_product_description' => [false => 'Description'],
        'item_product_created_at' => [false => 'Created At'],
        'item_product_created_by' => [false => 'Updated At'],
    ];

    public $status = [
        '1' => ['Active', 'primary'],
        '0' => ['Not Active', 'danger'],
    ];

    public $promo = [
        '0' => ['Not Active', 'danger'],
        '1' => ['Percent', 'primary'],
        '2' => ['Amount', 'success'],
    ];

    protected $casts = [
        'item_product_sell' => 'integer',
    ];

    public static function boot()
    {
        parent::boot();
        $statis = 'data';
        parent::creating(function ($model) {
            $model->item_product_id = Helper::autoNumber($model->getTable(), 'item_product_id', 'P' . date('ymd'), 10);
        });

        parent::saving(function ($model) {
            $file = 'item_product_file';
            if (request()->has($file)) {
                $image = $model->item_product_image;
                if ($image) {
                    Helper::removeImage($image, Helper::getTemplate(__CLASS__));
                }

                $file = request()->file($file);
                $name = Helper::uploadImage($file, Helper::getTemplate(__CLASS__));
                $model->item_product_image = $name;
            }

            if ($model->item_product_min_order <= 0) {
                $model->item_product_min_order = 1;
            }

            // $id = $model->item_product_id;
            // ProductFacades::deleteProductVariant($id);
            // foreach(request()->get('variant') as $variant){
            //     ProductFacades::saveProductVariant($model->item_product_id, $variant);
            // }

            if ($model->item_product_name && empty($model->item_product_slug)) {
                $model->item_product_slug = Str::slug($model->item_product_name);
            } else {
                $model->item_product_slug = Str::slug($model->item_product_slug);
            }

        });

        parent::deleting(function ($model) {
            if (request()->has('id')) {
                $data = $model->whereIn($model->getkeyName(), request()->get('id'))->get();
                if ($data) {
                    foreach ($data as $value) {
                        if ($value->item_product_image) {
                            Helper::removeImage($value->item_product_image, Helper::getTemplate(__CLASS__));
                        }
                    }
                }
            }
        });
    }

    public function category()
    {
        return $this->hasOne(Category::class, CategoryFacades::getKeyName(), 'item_product_item_category_id');
    }

    public function brand()
    {
        return $this->hasOne(Brand::class, BrandFacades::getKeyName(), 'item_product_item_brand_id');
    }

    public function variant(){
        return $this->leftJoin('item_product_variant', 'item_detail_product_id', 'item_product_id')
        ->leftJoin('item_variant', 'item_variant_id', 'item_detail_variant_id')->whereColumn('item_detail_product_id','item_product_id')->get();
    }
}
