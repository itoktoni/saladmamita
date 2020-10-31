<?php

namespace Modules\Sales\Dao\Models;

use Modules\Item\Dao\Models\Product;
use Modules\Item\Dao\Models\Variant;
use Illuminate\Database\Eloquent\Model;

class OrderDetailVariant extends Model
{
    protected $table = 'sales_order_detail_variant';
    protected $primaryKey = 'sales_order_detail_variant_item_product_id';
    protected $foreignKey = 'sales_order_detail_variant_item_variant_id';
    protected $with = ['variant'];
    protected $fillable = [
        'sales_order_detail_variant_order_id',
        'sales_order_detail_variant_order_detail_id',
        'sales_order_detail_variant_item_product_id',
        'sales_order_detail_variant_item_variant_id',
        'sales_order_detail_variant_qty',
    ];

    public $timestamps = false;
    public $incrementing = false;

    protected $casts = [
        'sales_order_detail_variant_qty' => 'int',
    ];

    public function getForeignKey()
    {
        return $this->foreignKey;
    }

    public function variant()
    {
        return $this->hasOne(Variant::class, 'item_variant_id', 'sales_order_detail_variant_item_variant_id');
    }

}
