<?php

namespace Modules\Marketing\Dao\Models;

use Illuminate\Database\Eloquent\Model;

class Langganan extends Model
{
    protected $table = 'marketing_langganan';
    protected $primaryKey = 'marketing_langganan_id';
    public $with = ['detail', 'detail.product'];
    protected $fillable = [
        'marketing_langganan_id',
        'marketing_langganan_name',
        'marketing_langganan_day',
        'marketing_langganan_description',
        'marketing_langganan_price',
    ];

    public $timestamps = false;
    public $incrementing = true;
    public $rules = [
        'marketing_langganan_name' => 'required|min:3',
        'marketing_langganan_day' => 'required',
        'marketing_langganan_price' => 'required|numeric',
    ];

    const CREATED_AT = 'marketing_langganan_created_at';
    const UPDATED_AT = 'marketing_langganan_updated_at';

    public $searching = 'marketing_langganan_name';
    public $datatable = [
        'marketing_langganan_id' => [false => 'ID'],
        'marketing_langganan_name' => [true => 'Name'],
        'marketing_langganan_day' => [true => 'Day'],
        'marketing_langganan_description' => [true => 'Description'],
        'marketing_langganan_price' => [true => 'Price'],
    ];

    public $status = [
        '1' => ['Active', 'primary'],
        '0' => ['Not Active', 'danger'],
    ];

    public function detail()
    {
        return $this->hasMany(LanggananDetail::class, 'marketing_langganan_detail_langganan_id', $this->getKeyName());
    }
}
