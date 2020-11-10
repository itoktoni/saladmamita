<?php

namespace Modules\Sales\Dao\Repositories\report;

use Plugin\Notes;
use Plugin\Helper;
use Illuminate\Support\Facades\DB;
use Modules\Sales\Dao\Models\Order;
use Modules\Item\Dao\Models\Product;
use App\Dao\Interfaces\MasterInterface;
use Illuminate\Database\QueryException;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Modules\Procurement\Dao\Repositories\PurchaseRepository;
use Modules\Sales\Dao\Repositories\OrderRepository;

class ReportSummaryOrderRepository extends Order implements FromCollection, WithHeadings, ShouldAutoSize, WithColumnFormatting, WithMapping
{
    public $model;
    public function headings(): array
    {
        return [
            'Sales ID',
            'Create Date',
            'Delivery Date',
            'Delivery From',
            'Customer',
            'Status',
            'Total Order',
            'Discount Name',
            'Discount',
            'Waybill',
            'Ongkir',
            'Total Data',
            'Notes',
        ];
    }


    public function __construct()
    {
        $this->model = new OrderRepository();
    }

    public function collection()
    {

        $query = $this->model
            ->select([
                'sales_order_id',
                'sales_order_created_at',
                'sales_order_date_order',
                'sales_order_from_name',
                'sales_order_to_name',
                'sales_order_status',
                'sales_order_sum_product',
                'sales_order_discount_name',
                'sales_order_discount_value',
                'sales_order_delivery_name',
                'sales_order_sum_ongkir',
                'sales_order_sum_total',
                'sales_order_notes_external',
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
            $query->where('sales_order_date_order','<=', $to);
        }
        return $query->get();
    }

    public function map($data): array
    {
        return [
           $data->sales_order_id, 
           $data->sales_order_created_at ? $data->sales_order_created_at->format('d-m-Y') : '', 
           $data->sales_order_date_order ? $data->sales_order_date_order->format('d-m-Y') : '', 
           $data->sales_order_from_name, 
           $data->sales_order_to_name, 
           $data->status[$data->sales_order_status][0] ?? '', 
           $data->sales_order_sum_product, 
           $data->sales_order_discount_name, 
           $data->sales_order_discount_value , 
           $data->sales_order_delivery_name ,
           $data->sales_order_sum_ongkir ,
           $data->sales_order_sum_total, 
           $data->sales_order_notes_external, 
        ];
    }

    public function columnFormats(): array
    {
        return [
            'B' => NumberFormat::FORMAT_DATE_YYYYMMDD,
            'C' => NumberFormat::FORMAT_DATE_YYYYMMDD,
            'E' => NumberFormat::FORMAT_TEXT,
            'G' => NumberFormat::FORMAT_NUMBER,
            'H' => NumberFormat::FORMAT_NUMBER,
            'I' => NumberFormat::FORMAT_NUMBER,
            'J' => NumberFormat::FORMAT_NUMBER,
            'K' => NumberFormat::FORMAT_NUMBER,
            'L' => NumberFormat::FORMAT_NUMBER,
        ];
    }
}