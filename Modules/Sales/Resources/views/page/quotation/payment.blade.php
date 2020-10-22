<br>
<header class="panel-heading">
    <h2 class="panel-title text-right">Tabel Pembayaran</h2>
</header>
<table id="transaction" class="table table-no-more table-bordered table-striped">
    <thead>
        <tr>
            <th class="text-left col-md-1">Tanggal</th>
            <th class="text-left col-md-1">Cabang</th>
            <th class="text-left col-md-2">Orang</th>
            <th class="text-right col-md-1">Voucher</th>
            <th class="text-left col-md-1">Akun</th>
            <th class="text-right col-md-1">Deskripsi</th>
            <th class="text-right col-md-1">Nominal</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($payment as $item)
        <tr>
            <td data-title="Tanggal">
                {{ $item->finance_payment_date }}
            </td>
            <td data-title="Cabang">
                <p class="text-left">
                    {{ $item->branch->inventory_branch_name ?? '' }}
                </p>
            </td>
            <td data-title="Orang">
                {{ $item->finance_payment_person ?? '' }}
            </td>
            <td data-title="Voucher">
                <p class="text-right">
                    {{ $item->finance_payment_voucher }}
                </p>
            </td>
            <td data-title="Akun">
                {{ $item->account->finance_account_name ?? '' }}
            </td>
            <td data-title="Deskripsi">
                <p class="text-right">
                    {{ $item->finance_payment_notes }}
                </p>
            </td>
            <td data-title="Nomical">
                <p class="text-right">
                    {{ number_format($item->finance_payment_amount) ?? '' }}
                </p>
            </td>
        </tr>
        @endforeach
        <tr>
            <td colspan="6">
                <h3>
                    Total Kurang Bayar
                </h3>
            </td>
            <td>
                <h3 class="text-right">
                    {{ number_format($model->sales_order_total - $payment->sum('finance_payment_amount')) }}
                </h3>
            </td>
        </tr>
    </tbody>
</table>