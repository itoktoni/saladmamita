<?php

namespace Modules\Sales\Dao\Models;

use App\User;
use Plugin\Helper;
use App\Dao\Models\Company;
use Illuminate\Support\Carbon;
use Modules\Sales\Dao\Models\Area;
use Modules\Sales\Dao\Models\City;
use Modules\Finance\Dao\Models\Tax;
use Modules\Finance\Dao\Models\Top;
use Illuminate\Support\Facades\Auth;
use Modules\Crm\Dao\Models\Customer;
use Modules\Sales\Dao\Models\Province;
use Illuminate\Database\Eloquent\Model;
use Modules\Finance\Dao\Models\Payment;
use Modules\Forwarder\Dao\Models\Vendor;
use Modules\Sales\Dao\Models\OrderDetail;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Sales\Dao\Models\QuotationDetail;

class Quotation extends Model
{
    use SoftDeletes;
    protected $table = 'sales_quotation';
    protected $primaryKey = 'sales_quotation_id';
    protected $fillable = [
    'sales_quotation_id',
    'sales_quotation_created_at',
    'sales_quotation_created_by',
    'sales_quotation_updated_at',
    'sales_quotation_updated_by',
    'sales_quotation_deleted_at',
    'sales_quotation_deleted_by',
    'sales_quotation_from_id',
    'sales_quotation_from_name',
    'sales_quotation_from_phone',
    'sales_quotation_from_email',
    'sales_quotation_from_address',
    'sales_quotation_from_area',
    'sales_quotation_to_id',
    'sales_quotation_to_name',
    'sales_quotation_to_phone',
    'sales_quotation_to_email',
    'sales_quotation_to_address',
    'sales_quotation_to_area',
    'sales_quotation_status',
    'sales_quotation_date',
    'sales_quotation_term_top',
    'sales_quotation_term_product',
    'sales_quotation_term_valid',
    'sales_quotation_notes_internal',
    'sales_quotation_notes_external',
    'sales_quotation_discount_name',
    'sales_quotation_discount_percent',
    'sales_quotation_discount_value',
    'sales_quotation_tax_id',
    'sales_quotation_tax_percent',
    'sales_quotation_tax_value',
    'sales_quotation_sum_product',
    'sales_quotation_sum_discount',
    'sales_quotation_sum_tax',
    'sales_quotation_sum_ongkir',
    'sales_quotation_sum_total',
  ];

    public $timestamps = true;
    public $incrementing = false;
    public $rules = [
    'sales_quotation_email' => 'required',
  ];

    public $with = ['detail', 'detail.product'];

    const CREATED_AT = 'sales_quotation_created_at';
    const UPDATED_AT = 'sales_quotation_updated_at';
    const DELETED_AT = 'sales_quotation_deleted_at';

    public $searching = 'sales_quotation_id';
    public $datatable = [
    'sales_quotation_id'                  => [true => 'Code'],
    'sales_quotation_date'                => [true => 'Order Date'],
    'company_contact_name'                => [true => 'Company'],
    'crm_customer_name'                => [true => 'Customer'],
    'sales_quotation_to_name'                => [true => 'Contact'],
    'sales_quotation_status'                  => [true => 'Status'],
  ];

    protected $dates = [
    'sales_quotation_created_at',
    'sales_quotation_updated_at',
  ];

     protected $casts = [
    'sales_quotation_date' => 'datetime:Y-m-d',
    'sales_quotation_date_quotation' => 'datetime:Y-m-d',
  ];

    public $status = [
    '1' => ['CREATE', 'warning'],
    '2' => ['APPROVE', 'primary'],
    '3' => ['PREPARE', 'success'],
    '4' => ['DELIVERED', 'dark'],
    '0' => ['CANCEL', 'danger'],
  ];

    public $courier = [
    '' => 'Choose Expedition',
    'pos' => 'POS Indonesia (POS)',
    'jne' => 'Jalur Nugraha Ekakurir (JNE)',
    'tiki' => 'Citra Van Titipan Kilat (TIKI)',
    'rpx' => 'RPX Holding (RPX)',
    'wahana' => 'Wahana Prestasi Logistik (WAHANA)',
    'sicepat' => 'SiCepat Express (SICEPAT)',
    'jnt' => 'J&T Express (J&T)',
    'sap' => 'SAP Express (SAP)',
    'jet' => 'JET Express (JET)',
    'indah' => 'Indah Logistic (INDAH)',
    'ninja' => 'Ninja Express (NINJA)',
    'first' => 'First Logistics (FIRST)',
    'lion' => 'Lion Parcel (LION)',
    'rex' => 'Royal Express Indonesia (REX)',
  ];

    public function detail()
    {
        return $this->hasMany(QuotationDetail::class, 'sales_quotation_detail_order_id', 'sales_quotation_id');
    }

    public function payment()
    {
        return $this->hasMany(Payment::class, 'finance_payment_sales_quotation_id', 'sales_quotation_id');
    }

    public function tax()
    {
        return $this->hasOne(Tax::class, 'finance_tax_id', 'sales_quotation_tax_id');
    }

    public function top()
    {
        return $this->hasOne(Top::class, 'finance_top_code', 'sales_quotation_term_top');
    }

    public function company()
    {
        return $this->hasOne(Company::class, 'company_id', 'sales_quotation_from_id');
    }

    public function customer()
    {
        return $this->hasOne(Customer::class, 'crm_customer_id', 'sales_quotation_to_id');
    }

    public function Province()
    {
        return $this->hasOne(Province::class, 'rajaongkir_province_id', 'sales_quotation_rajaongkir_province_id');
    }

    public function City()
    {
        return $this->hasOne(City::class, 'rajaongkir_city_id', 'sales_quotation_rajaongkir_city_id');
    }

    public function from()
    {
        return $this->hasOne(Area::class, 'rajaongkir_area_id', 'sales_quotation_from_id');
    }

    public function to()
    {
        return $this->hasOne(Area::class, 'rajaongkir_area_id', 'sales_quotation_to_id');
    }

    public function Area()
    {
        return $this->hasOne(Area::class, 'rajaongkir_area_id', 'sales_quotation_rajaongkir_area_id');
    }

    public function forwarder()
    {
        return $this->hasOne(Vendor::class, 'forwarder_vendor_id', 'sales_quotation_forwarder_vendor_id');
    }

    public static function boot()
    {
        parent::boot();
        parent::creating(function ($model) {
            $model->sales_quotation_created_by = auth()->user()->username;
        });

        parent::saving(function ($model) {
            $model->sales_quotation_date = $model->sales_quotation_date->format('Y-m-d H:i:s');
            $model->sales_quotation_date_quotation  = $model->sales_quotation_date->addDays($model->sales_order_term_valid)->format('Y-m-d H:i:s');
        });
    }
}
