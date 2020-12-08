<?php

namespace Modules\Sales\Dao\Models;

use App\User;
use App\Dao\Models\Branch;
use App\Dao\Models\Company;
use Modules\Sales\Dao\Models\Area;
use Modules\Sales\Dao\Models\City;
use Modules\Finance\Dao\Models\Tax;
use Modules\Finance\Dao\Models\Top;
use Modules\Sales\Dao\Models\Order;
use Illuminate\Support\Facades\Auth;
use Modules\Crm\Dao\Models\Customer;
use Modules\Sales\Dao\Models\Province;
use Illuminate\Database\Eloquent\Model;
use Modules\Finance\Dao\Models\Payment;
use Modules\Forwarder\Dao\Models\Vendor;
use Modules\Sales\Dao\Models\OrderDetail;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Sales\Dao\Facades\OrderFacades;

class Subscribe extends Model
{
    use SoftDeletes;
    protected $table = 'sales_berlangganan';
    protected $primaryKey = 'sales_langganan_id';
    protected $fillable = [
        'sales_langganan_id',
        'sales_langganan_created_at',
        'sales_langganan_created_by',
        'sales_langganan_updated_at',
        'sales_langganan_updated_by',
        'sales_langganan_deleted_at',
        'sales_langganan_deleted_by',
        'sales_langganan_date_order',
        'sales_langganan_from_id',
        'sales_langganan_from_name',
        'sales_langganan_from_phone',
        'sales_langganan_from_email',
        'sales_langganan_from_address',
        'sales_langganan_from_area',
        'sales_langganan_to_id',
        'sales_langganan_to_name',
        'sales_langganan_to_phone',
        'sales_langganan_to_email',
        'sales_langganan_to_address',
        'sales_langganan_to_area',
        'sales_langganan_status',
        'sales_langganan_term_top',
        'sales_langganan_term_product',
        'sales_langganan_term_valid',
        'sales_langganan_notes_internal',
        'sales_langganan_notes_external',
        'sales_langganan_discount_code',
        'sales_langganan_discount_name',
        'sales_langganan_discount_percent',
        'sales_langganan_discount_value',
        'sales_langganan_sum_product',
        'sales_langganan_sum_discount',
        'sales_langganan_sum_tax',
        'sales_langganan_sum_ongkir',
        'sales_langganan_sum_total',
        'sales_langganan_payment_date',
        'sales_langganan_payment_bank_from',
        'sales_langganan_payment_bank_to_id',
        'sales_langganan_payment_person',
        'sales_langganan_payment_phone',
        'sales_langganan_payment_email',
        'sales_langganan_payment_file',
        'sales_langganan_payment_value',
        'sales_langganan_payment_notes',
        'sales_langganan_delivery_type',
        'sales_langganan_delivery_name',
        'sales_langganan_print_counter',
        'sales_langganan_core_user_id',
        'sales_langganan_marketing_langganan_id',
        'sales_langganan_token',
        'sales_langganan_date_email',
    ];

    public $timestamps = true;
    public $incrementing = false;
    public $rules = [
        'sales_langganan_to_name' => 'required',
    ];

    public $with = ['order'];

    const CREATED_AT = 'sales_langganan_created_at';
    const UPDATED_AT = 'sales_langganan_updated_at';
    const DELETED_AT = 'sales_langganan_deleted_at';

    public $searching = 'sales_langganan_id';
    public $datatable = [
        'sales_langganan_id' => [true => 'Code'],
        'sales_langganan_created_at' => [true => 'Create Order'],
        'sales_langganan_date_order' => [false => 'Delivery Date'],
        'sales_langganan_from_name' => [true => 'Pickup'],
        'sales_langganan_to_name' => [true => 'Contact'],
        'sales_langganan_to_phone' => [true => 'Phone'],
        'sales_langganan_status' => [true => 'Status'],
        'sales_langganan_token' => [false => 'Token'],
    ];

    protected $dates = [
        'sales_langganan_created_at',
        'sales_langganan_updated_at',
    ];

    protected $casts = [
        'sales_langganan_date_order' => 'datetime:d-m-Y',
        'sales_langganan_payment_date' => 'datetime:d-m-Y',
        'sales_langganan_created_at' => 'datetime:d-m-Y',
    ];

    public $status = [
        '1' => ['CREATE', 'warning'],
        '2' => ['PAID', 'primary'],
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

    public function order()
    {
        return $this->hasMany(Order::class, 'sales_order_code_reference', 'sales_langganan_id');
    }

    public function delivery()
    {
        return $this->hasMany(DeliveryDetail::class, 'sales_delivery_detail_order_id', 'sales_langganan_id');
    }

    public function payment()
    {
        return $this->hasMany(Payment::class, 'finance_payment_sales_langganan_id', 'sales_langganan_id');
    }

    public function tax()
    {
        return $this->hasOne(Tax::class, 'finance_tax_id', 'sales_langganan_tax_id');
    }

    public function top()
    {
        return $this->hasOne(Top::class, 'finance_top_code', 'sales_langganan_term_top');
    }

    public function company()
    {
        return $this->hasOne(Company::class, 'company_id', 'sales_langganan_from_id');
    }

    public function branch()
    {
        return $this->hasOne(Branch::class, 'branch_id', 'sales_langganan_from_id');
    }

    public function customer()
    {
        return $this->hasOne(Customer::class, 'crm_customer_id', 'sales_langganan_to_id');
    }

    public function Province()
    {
        return $this->hasOne(Province::class, 'rajaongkir_province_id', 'sales_langganan_rajaongkir_province_id');
    }

    public function City()
    {
        return $this->hasOne(City::class, 'rajaongkir_city_id', 'sales_langganan_rajaongkir_city_id');
    }

    public function from()
    {
        return $this->hasOne(Area::class, 'rajaongkir_area_id', 'sales_langganan_from_id');
    }

    public function to()
    {
        return $this->hasOne(Area::class, 'rajaongkir_area_id', 'sales_langganan_to_id');
    }

    public function Area()
    {
        return $this->hasOne(Area::class, 'rajaongkir_area_id', 'sales_langganan_rajaongkir_area_id');
    }

    public function forwarder()
    {
        return $this->hasOne(Vendor::class, 'forwarder_vendor_id', 'sales_langganan_forwarder_vendor_id');
    }

    public static function boot(){
        parent::boot();

        parent::updated(function($model){

            if(request()->has('sales_langganan_status')){
                 $id = $model->sales_langganan_id;
                 $data = OrderFacades::where('sales_order_code_reference', $id);
                 if($data->count() > 0){
                    $data->update([
                        'sales_order_status' => request()->get('sales_langganan_status')
                    ]);
                 }
            }
        });
    }

}
