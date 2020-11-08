<?php

namespace Modules\Sales\Dao\Repositories\report;

use App\Dao\Models\Branch;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Modules\Item\Dao\Models\Category;
use Modules\Item\Dao\Models\Product;
use Modules\Item\Dao\Models\Variant;
use Modules\Rajaongkir\Dao\Models\Delivery;
use Modules\Sales\Dao\Models\Order;
use Modules\Sales\Dao\Models\OrderDetail;
use Modules\Sales\Dao\Models\OrderDetailVariant;
use Modules\Sales\Dao\Repositories\OrderRepository;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class ReportProductionRepository extends Order implements FromView, ShouldAutoSize, WithColumnFormatting
{
    public $model;
    public $detail;
    public $product;
    public $branch;
    public $key = [];

    public function __construct()
    {
        $this->model = new OrderRepository();
        $this->detail = new OrderDetail();
        $this->product = new Product();
        $this->category = new Category();
        $this->branch = new Branch();
        $this->variant_detail = new OrderDetailVariant();
        $this->variant = new Variant();
        $this->delivery = new Delivery();
    }

    public function view(): View
    {
        $query = $this->detail
        // ->leftJoin($this->branch->getTable(), 'sales_order_from_id', $this->branch->getKeyName())
        // ->leftJoin($this->delivery->getTable(), 'sales_order_delivery_type', $this->delivery->getKeyName())
        // ->leftJoin($this->detail->getTable(), $this->model->getKeyName(), 'sales_order_detail_order_id')
            ->leftJoin($this->model->getTable(), $this->model->getKeyName(), 'sales_order_detail_order_id')
            ->leftJoin($this->variant_detail->getTable(), 'sales_order_detail_variant_order_detail_id', 'sales_order_detail_id')
            ->leftJoin($this->variant->getTable(), $this->variant->getKeyName(), 'sales_order_detail_variant_item_variant_id')
            ->leftJoin($this->product->getTable(), 'sales_order_detail_item_product_id', $this->product->getKeyName())
            ->leftJoin($this->category->getTable(), 'item_product_item_category_id', $this->category->getKeyName())
            ->select([
                'sales_order_date_order',
                'item_category_name',
                'item_product_name',
                'sales_order_detail_qty',
                'sales_order_detail.*',
                'sales_order_detail_variant.*',
                'item_variant_name',
                // 'sales_order_detail_variant_qty',
                // DB::raw('sum(sales_order_detail_qty) as detail_qty'),
            ]);
        // ->whereNull('sales_order_detail_variant_qty')
        // ->orWhere('sales_order_detail_variant_qty', '>', 0);

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

        $query = $query->orderBy('sales_order_date_order', 'ASC');
        // dd($query->toSql());
        // dd($query->first()->sales_order_created_at->format('Y-m-d'));
        return view('Sales::page.report.export_production', [
            'export' => $query->get(),
        ]);
    }

    public function columnFormats(): array
    {
        return [
            'A' => NumberFormat::FORMAT_DATE_YYYYMMDD,
            'E' => NumberFormat::FORMAT_NUMBER,
        ];
    }
}
