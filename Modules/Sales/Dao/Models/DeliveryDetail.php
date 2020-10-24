<?php

namespace Modules\Sales\Dao\Models;

use Modules\Item\Dao\Models\Product;
use Illuminate\Database\Eloquent\Model;
use Modules\Rajaongkir\Dao\Models\Area;

class DeliveryDetail extends Model
{
  protected $table = 'sales_delivery_detail';
  protected $primaryKey = 'sales_delivery_detail_delivery_id';
  protected $foreignKey = 'sales_delivery_detail_item_product_id';
  protected $with = ['product'];
  protected $fillable = [
    'sales_delivery_detail_order_id',
    'sales_delivery_detail_delivery_id',
    'sales_delivery_detail_notes',
    'sales_delivery_detail_item_product_id',
    'sales_delivery_detail_item_product_description',
    'sales_delivery_detail_item_product_price',
    'sales_delivery_detail_item_product_weight',
    'sales_delivery_detail_qty',
    'sales_delivery_detail_out',
    'sales_delivery_detail_price',
    'sales_delivery_detail_total',
    'sales_delivery_detail_discount_name',
    'sales_delivery_detail_discount_percent',
    'sales_delivery_detail_discount_value',
    'sales_delivery_detail_tax_id',
    'sales_delivery_detail_tax_percent',
    'sales_delivery_detail_tax_value',
  ];

  public $timestamps = false;
  public $incrementing = false;

  public function getForeignKey()
  {
      return $this->foreignKey;
  }

  public function getOrderKey()
  {
      return 'sales_delivery_detail_order_id';
  }

  public function detail()
  {
    return $this->belongsTo(Order::class, 'sales_delivery_detail_sales_id', 'sales_delivery_id');
  }

  public function product()
  {
    return $this->hasOne(Product::class, 'item_product_id', 'sales_delivery_detail_item_product_id');
  }

}
