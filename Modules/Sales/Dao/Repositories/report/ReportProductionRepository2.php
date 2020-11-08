<?php

namespace Modules\Sales\Dao\Repositories\report;

use Illuminate\Support\Facades\DB;
use Modules\Sales\Dao\Models\Order;
use Modules\Item\Dao\Models\Product;
use Modules\Item\Dao\Models\Variant;
use Maatwebsite\Excel\Concerns\FromView;
use Modules\Sales\Dao\Models\OrderDetail;
use Maatwebsite\Excel\Concerns\WithMapping;
use Modules\Rajaongkir\Dao\Models\Delivery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Modules\Sales\Dao\Models\OrderDetailVariant;
use Modules\Sales\Dao\Repositories\OrderRepository;

class ReportProductionRepository2 extends Order implements FromView, ShouldAutoSize
{
    public $model;
    public $detail;
    public $product;
    public $variant;
    public $variant_detail;
    public $key = [];

    public function __construct()
    {
        $this->model = new OrderRepository();
        $this->detail = new OrderDetail();
        $this->product = new Product();
        $this->variant_detail = new OrderDetailVariant();
        $this->variant = new Variant();
        $this->delivery = new Delivery();
    }

    // public function headings(): array
    // {
    //     return [
    //         'Sales ID',
    //         'Create Date',
    //         'Delivery Date',
    //         'Delivery From',
    //         'Customer',
    //         'Status',
    //         'Total Order',
    //         'Discount Name',
    //         'Discount',
    //         'Waybill',
    //         'Ongkir',
    //         'Total Data',
    //         'Notes',
    //     ];
    // }

    public function view(): View
    {
        // $query = DB::table($this->model->getTable())
            $query = $this->detail
            ->leftJoin($this->model->getTable(), $this->model->getKeyName(), 'sales_order_detail_order_id')
            // ->leftJoin($this->variant_detail->getTable(), 'sales_order_detail_variant_order_detail_id', 'sales_order_detail_id')
            // ->leftJoin($this->variant->getTable(), $this->variant->getKeyName(), 'sales_order_detail_variant_item_variant_id')
            ->leftJoin($this->product->getTable(), 'sales_order_detail_item_product_id', $this->product->getKeyName())
            // ->where('sales_order_detail_qty', '>', 0)
            // ->where('sales_order_detail_variant_qty', '>', 0)
            // ->where('sales_order_status', '>', 2)
            ->select([
                'sales_order_date_order',
                'item_product_name',
                DB::raw('sum(sales_order_detail_qty) as detail_qty'),
                // DB::raw('sum(sales_order_detail_variant_qty) as variant_qty'),
                // 'sales_order_detail_variant.*',
                'sales_order_detail.*',
                // 'item_variant.*',
            ]);

        if ($promo = request()->get('promo')) {
            $query->where('sales_order_marketing_promo_code', $promo);
        }
        if ($status = request()->get('status')) {
            $query->where('sales_order_status', $status);
        }
        if ($from = request()->get('from')) {
            $query->where('sales_order_date_order', '>=', $from);
        }
        if ($to = request()->get('to')) {
            $query->where('sales_order_date_order', '<=', $to);
        }

        $query = $query
            ->groupBy('sales_order_date_order', 'item_variant_id')
            ->orderBy('sales_order_date_order', 'ASC');
        // return $query->get();

        // dd($query->toSql());
        // dd($query->toSql());
        // dd($query->first()->sales_order_created_at->format('Y-m-d'));
        return view('Sales::page.report.export_detail', [
            'export' => $query->get()
        ]);
    }

    // public function map($data): array
    // {
    //     return [
    //         $data->sales_order_date_order ? $data->sales_order_date_order : '',
    //         $data->item_product_name,
    //         $data->item_variant_name,
    //         $data->detail_qty,
    //         $data->variant_qty,
    //     ];
    // }
}
