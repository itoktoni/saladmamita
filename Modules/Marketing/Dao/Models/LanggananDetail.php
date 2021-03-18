<?php

namespace Modules\Marketing\Dao\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Modules\Item\Dao\Facades\ProductFacades;
use Modules\Item\Dao\Models\Product;

class LanggananDetail extends Model
{
    protected $table = 'marketing_langganan_detail';
    protected $primaryKey = 'marketing_langganan_detail_id';
    protected $fillable = [
        'marketing_langganan_detail_id',
        'marketing_langganan_detail_product_id',
        'marketing_langganan_detail_langganan_id',
    ];

    public $timestamps = false;
    public $incrementing = true;
    public $rules = [
        'marketing_langganan_detail_name' => 'required|min:3',
        'marketing_langganan_detail_day' => 'required',
    ];

    const CREATED_AT = 'marketing_langganan_detail_created_at';
    const UPDATED_AT = 'marketing_langganan_detail_updated_at';

    public $searching = 'marketing_langganan_detail_name';
    public $datatable = [
        'marketing_langganan_detail_id' => [false => 'ID'],
        'marketing_langganan_detail_product_id' => [true => 'Product'],
        'marketing_langganan_detail_langganan_id' => [true => 'Langganan'],
    ];

    public $status = [
        '1' => ['Active', 'primary'],
        '0' => ['Not Active', 'danger'],
    ];

    public function product()
    {
        return $this->hasOne(Product::class, ProductFacades::getKeyName(), 'marketing_langganan_detail_product_id');
    }
    
    public function variant($product)
    {
        return DB::table('item_product_variant')->join('item_variant', 'item_detail_variant_id', 'item_variant_id')->where('item_detail_product_id', $product)->get();
    }
}
