<?php

namespace Modules\Sales\Dao\Models;

use Modules\Item\Dao\Models\Product;
use Illuminate\Database\Eloquent\Model;
use Modules\Rajaongkir\Dao\Models\Area;

class OrderDetail extends Model
{
  protected $table = 'sales_order_detail';
  protected $primaryKey = 'sales_order_detail_order_id';
  protected $foreignKey = 'sales_order_detail_item_product_id';
  protected $with = ['product'];
  protected $fillable = [
    'sales_order_detail_order_id',
    'sales_order_detail_notes',
    'sales_order_detail_item_product_id',
    'sales_order_detail_item_product_description',
    'sales_order_detail_item_product_price',
    'sales_order_detail_item_product_weight',
    'sales_order_detail_qty',
    'sales_order_detail_price',
    'sales_order_detail_total',
    'sales_order_detail_discount_name',
    'sales_order_detail_discount_percent',
    'sales_order_detail_discount_value',
    'sales_order_detail_tax_id',
    'sales_order_detail_tax_percent',
    'sales_order_detail_tax_value',
  ];

  public $timestamps = false;
  public $incrementing = false;

  public function getForeignKey()
  {
      return $this->foreignKey;
  }

  public function detail()
  {
    return $this->belongsTo(Order::class, 'sales_order_detail_sales_id', 'sales_order_id');
  }

  public function product()
  {
    return $this->hasOne(Product::class, 'item_product_id', 'sales_order_detail_item_product_id');
  }

}
