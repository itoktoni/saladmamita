<table width=100%>
    <tbody>
        <tr>
            <td bgcolor="#ffffff" id="m_-3784408755349078820contentContainer"
                style="border-collapse:collapse;border-spacing:0;font-family:Arial,sans-serif;color:#999;line-height:1.5;margin:0;padding:0">
                <table align="left" width="100%" style="border-collapse:collapse;border-spacing:0;margin:0;padding:0">
                    <tbody>
                        <tr>
                            <td width="15"
                                style="border-collapse:collapse;border-spacing:0;font-family:Arial,sans-serif;color:#999;line-height:1.5;margin:0;padding:0">
                            </td>
                            <td align="left" width="550"
                                style="border-collapse:collapse;border-spacing:0;font-family:Arial,sans-serif;color:#999;line-height:1.5;margin:0;padding:0">
                                <table align="left" width="100%"
                                    style="border-collapse:collapse;border-spacing:0;margin:0;padding:0">
                                    <tbody>
                                        <tr>
                                            <td
                                                style="border-collapse:collapse;border-spacing:0;font-family:Arial,sans-serif;color:#999;line-height:1.5;margin:0;padding:0">
                                                <div style="margin:10px 2px -25px">
                                                    <p
                                                        style="font-family:Arial,sans-serif;color:#555;line-height:1.5;font-size:15px;font-weight:bold;margin:0;padding:0">
                                                        Notification Order From System
                                                        {{ config('website.name') }},
                                                    </p>

                                                </div>
                                                <div style="margin:10px 2px">
                                                    <br>
                                                    <table border="0" cellpadding="5" cellspacing="0"
                                                        id="m_-3784408755349078820templateList" width="100%"
                                                        style="border-collapse:collapse;border-spacing:0;font-size:13px;border-bottom-color:#cccccc;border-bottom-width:1px;border-bottom-style:solid;margin:0 0 25px;padding:0"
                                                        bgcolor="#FFFFFF">
                                                        <tbody>
                                                            <tr>
                                                                <th colspan="4"
                                                                    style="border-bottom-style:none;color:#ffffff;padding-left:10px;padding-right:10px"
                                                                    bgcolor="#{{ config('website.color') }}">
                                                                    <h2
                                                                        style="font-family:Arial,sans-serif;color:#ffffff;line-height:1.5;font-size:15px;font-weight:bold;margin:0;padding:5px 0">
                                                                        No. Order : {{ $master->sales_langganan_id }}
                                                                    </h2>
                                                                </th>
                                                            </tr>
                                                            <tr>
                                                                <td align="left" colspan="1" valign="top"
                                                                    style="border-collapse:collapse;border-spacing:0;font-family:Arial,sans-serif;color:#555;line-height:1.5;border-bottom-color:#cccccc;border-bottom-width:1px;border-bottom-style:solid;margin:0;padding:5px 10px"
                                                                    bgcolor="#FFFFFF">
                                                                    <span
                                                                        style="font-family:Arial,sans-serif;color:#555;line-height:1.5;font-size:13px;margin:0;padding:0">Waktu
                                                                        Transaksi</span>
                                                                </td>
                                                                <td align="right" valign="top" colspan="3"
                                                                    style="border-collapse:collapse;border-spacing:0;font-family:Arial,sans-serif;color:#555;line-height:1.5;border-bottom-color:#cccccc;border-bottom-width:1px;border-bottom-style:solid;margin:0;padding:5px 10px"
                                                                    bgcolor="#FFFFFF">
                                                                    <span
                                                                        style="text-align: right;font-family:Arial,sans-serif;color:#555;line-height:1.5;font-size:13px;margin:0;padding:0">{{ $master->sales_langganan_created_at->format('d M Y H:i:s') }}</span>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td align="left" colspan="1" valign="top"
                                                                    style="border-collapse:collapse;border-spacing:0;font-family:Arial,sans-serif;color:#555;line-height:1.5;border-bottom-color:#cccccc;border-bottom-width:1px;border-bottom-style:solid;margin:0;padding:5px 10px"
                                                                    bgcolor="#FFFFFF">
                                                                    <span
                                                                        style="font-family:Arial,sans-serif;color:#555;line-height:1.5;font-size:13px;margin:0;padding:0">
                                                                        Nama Customer</span>
                                                                </td>
                                                                <td align="right" valign="top" colspan="3"
                                                                    style="border-collapse:collapse;border-spacing:0;font-family:Arial,sans-serif;color:#555;line-height:1.5;border-bottom-color:#cccccc;border-bottom-width:1px;border-bottom-style:solid;margin:0;padding:5px 10px"
                                                                    bgcolor="#FFFFFF">

                                                                    <span
                                                                        style="font-family:Arial,sans-serif;color:#555;line-height:1.5;font-size:13px;margin:0;padding:0">
                                                                        {{ $master->sales_langganan_to_name ?? '' }}
                                                                    </span>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td align="left" colspan="1" valign="top"
                                                                    style="border-collapse:collapse;border-spacing:0;font-family:Arial,sans-serif;color:#555;line-height:1.5;border-bottom-color:#cccccc;border-bottom-width:1px;border-bottom-style:solid;margin:0;padding:5px 10px"
                                                                    bgcolor="#FFFFFF">
                                                                    <span
                                                                        style="font-family:Arial,sans-serif;color:#555;line-height:1.5;font-size:13px;margin:0;padding:0">Email</span>
                                                                </td>
                                                                <td align="right" valign="top" colspan="3"
                                                                    style="border-collapse:collapse;border-spacing:0;font-family:Arial,sans-serif;color:#555;line-height:1.5;border-bottom-color:#cccccc;border-bottom-width:1px;border-bottom-style:solid;margin:0;padding:5px 10px"
                                                                    bgcolor="#FFFFFF">
                                                                    <a
                                                                        style="text-align: right;color:#{{ config('website.color') }}!important;font-family:Arial,sans-serif;line-height:1.5;text-decoration:none;font-size:13px;margin:0;padding:0">
                                                                        {{ $master->sales_langganan_to_email ?? '' }}
                                                                    </a>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td align="left" colspan="1" valign="top"
                                                                    style="border-collapse:collapse;border-spacing:0;font-family:Arial,sans-serif;color:#555;line-height:1.5;border-bottom-color:#cccccc;border-bottom-width:1px;border-bottom-style:solid;margin:0;padding:5px 10px"
                                                                    bgcolor="#FFFFFF">
                                                                    <span
                                                                        style="font-family:Arial,sans-serif;color:#555;line-height:1.5;font-size:13px;margin:0;padding:0">Phone</span>
                                                                </td>
                                                                <td align="right" valign="top" colspan="3"
                                                                    style="border-collapse:collapse;border-spacing:0;font-family:Arial,sans-serif;color:#555;line-height:1.5;border-bottom-color:#cccccc;border-bottom-width:1px;border-bottom-style:solid;margin:0;padding:5px 10px"
                                                                    bgcolor="#FFFFFF">
                                                                    <span
                                                                        style="text-align: right;font-family:Arial,sans-serif;color:#555;line-height:1.5;font-size:13px;margin:0;padding:0">
                                                                        {{ $master->sales_langganan_to_phone ?? '' }}
                                                                    </span>
                                                                </td>
                                                            </tr>

                                                            <tr>
                                                                <td align="left" colspan="1" valign="top"
                                                                    style="border-collapse:collapse;border-spacing:0;font-family:Arial,sans-serif;color:#555;line-height:1.5;border-bottom-color:#cccccc;border-bottom-width:1px;border-bottom-style:solid;margin:0;padding:5px 10px"
                                                                    bgcolor="#FFFFFF">
                                                                    <span
                                                                        style="font-family:Arial,sans-serif;color:#555;line-height:1.5;font-size:13px;margin:0;padding:0">Address</span>
                                                                </td>
                                                                <td align="right" valign="top" colspan="3"
                                                                    style="border-collapse:collapse;border-spacing:0;font-family:Arial,sans-serif;color:#555;line-height:1.5;border-bottom-color:#cccccc;border-bottom-width:1px;border-bottom-style:solid;margin:0;padding:5px 10px"
                                                                    bgcolor="#FFFFFF">
                                                                    <span
                                                                        style="font-family:Arial,sans-serif;color:#555;line-height:1.5;font-size:13px;margin:0;padding:0">
                                                                        {{ $master->sales_langganan_to_address ?? '' }}
                                                                        /
                                                                        {{ Helper::getSingleArea($master->sales_langganan_to_area, true) ?? '' }}
                                                                    </span>
                                                                </td>
                                                            </tr>

                                                            <tr>
                                                                <th colspan="4"
                                                                    style="border-bottom-style:none;color:#ffffff;padding-left:10px;padding-right:10px"
                                                                    bgcolor="#{{ config('website.color') }}"></th>
                                                            </tr>


                                                            @foreach($detail as $order)
                                                            <tr class="header">
                                                                <td class="no" colspan="4">
                                                                    No. <strong>{{ $order->sales_order_id }}</strong> :
                                                                    <strong>Hari {{ $loop->iteration }} - Tanggal Kirim
                                                                        {{ $order->sales_order_date_order->format('d F Y') }}</strong>
                                                                </td>
                                                            </tr>

                                                            @foreach($order->detail as $item)

                                                            <tr>
                                                                <td align="left"
                                                                    class="m_-3784408755349078820headingList"
                                                                    valign="top"
                                                                    style="border-collapse:collapse;border-spacing:0;font-family:Arial,sans-serif;color:#555;line-height:1.5;border-bottom-color:#cccccc;border-bottom-width:1px;border-bottom-style:solid;font-size:11px;margin:0;padding:5px 10px"
                                                                    bgcolor="#F0F0F0">
                                                                    <strong style="color:#555;font-size:13px">
                                                                        Product Name
                                                                    </strong>
                                                                </td>
                                                                <td align="right"
                                                                    class="m_-3784408755349078820headingList"
                                                                    valign="top" width="10%"
                                                                    style="border-collapse:collapse;border-spacing:0;font-family:Arial,sans-serif;color:#555;line-height:1.5;border-bottom-color:#cccccc;border-bottom-width:1px;border-bottom-style:solid;font-size:11px;margin:0;padding:5px 10px"
                                                                    bgcolor="#F0F0F0">
                                                                    <strong
                                                                        style="color:#555;font-size:13px">Qty</strong>
                                                                </td>
                                                                <td align="right"
                                                                    class="m_-3784408755349078820headingList"
                                                                    valign="top" width="10%"
                                                                    style="border-collapse:collapse;border-spacing:0;font-family:Arial,sans-serif;color:#555;line-height:1.5;border-bottom-color:#cccccc;border-bottom-width:1px;border-bottom-style:solid;font-size:11px;margin:0;padding:5px 10px"
                                                                    bgcolor="#F0F0F0">
                                                                    <strong
                                                                        style="color:#555;font-size:13px">Price</strong>
                                                                </td>
                                                                <td align="right"
                                                                    class="m_-3784408755349078820headingList"
                                                                    valign="top" width="15%"
                                                                    style="border-collapse:collapse;border-spacing:0;font-family:Arial,sans-serif;color:#555;line-height:1.5;border-bottom-color:#cccccc;border-bottom-width:1px;border-bottom-style:solid;font-size:11px;margin:0;padding:5px 10px"
                                                                    bgcolor="#F0F0F0">
                                                                    <strong
                                                                        style="color:#555;font-size:13px">Total</strong>
                                                                </td>
                                                            </tr>

                                                            <tr class="item">
                                                                <td class="product">
                                                                    {{ $item->product->item_product_name ?? '' }}
                                                                    @if(!empty($item->variant))
                                                                    <i style="text-transform: lowercase;">
                                                                        @foreach($item->variant->where('sales_order_detail_variant_qty',
                                                                        '>', 0) as $variant)
                                                                        @if($loop->first)
                                                                        ( {{ $variant->sales_order_detail_variant_qty }}
                                                                        )
                                                                        {{ $variant->variant->item_variant_name ?? '' }}
                                                                        @else
                                                                        , (
                                                                        {{ $variant->sales_order_detail_variant_qty }} )
                                                                        {{ $variant->variant->item_variant_name ?? '' }}
                                                                        @endif
                                                                        @endforeach
                                                                        @endif
                                                                    </i>

                                                                </td>
                                                                <td class="qty" align="right">
                                                                    {{ $item->sales_order_detail_qty ?? '' }}
                                                                </td>
                                                                <td class="price" align="right">
                                                                    {{ !empty($item->sales_order_detail_price) ? Helper::createRupiah($item->sales_order_detail_price) : '' }}
                                                                </td>
                                                                <td class="total" align="right">
                                                                    {{ !empty($item->sales_order_detail_total) ? Helper::createRupiah($item->sales_order_detail_total) : '' }}
                                                                </td>
                                                            </tr>
                                                            @endforeach
                                                            @endforeach

                                                            @if (!empty($master->sales_langganan_discount_value))
                                                            <tr class="total_discount">
                                                                <td class="product" colspan="2">
                                                                    {{ ucfirst($master->sales_langganan_discount_name) ?? '' }}
                                                                    : =
                                                                    Total Discount
                                                                </td>
                                                                <td class="qty">
                                                                    {{ Helper::createRupiah($master->sales_langganan_discount_value) ?? '' }}
                                                                </td>
                                                                <td class="total">
                                                                    -{{ Helper::createRupiah($total_discount) ?? '' }}
                                                                </td>
                                                            </tr>
                                                            @endif
                                                            @if (!empty($master->sales_langganan_sum_ongkir))
                                                            <tr class="total_discount">
                                                                <td class="product" colspan="3">
                                                                    Ongkir
                                                                </td>
                                                                <td class="total">
                                                                    {{ Helper::createRupiah($master->sales_langganan_sum_ongkir) ?? '' }}
                                                                </td>
                                                            </tr>
                                                            @endif

                                                            @php
                                                            $total_delivery = $master->sales_langganan_sum_product;
                                                            $total_discount = $master->sales_langganan_sum_discount;
                                                            $grand_total = $master->sales_langganan_sum_total;
                                                            @endphp

                                                            <tr class="total_sumary">
                                                                <td class="product" colspan="3" style="background-color:#555;color:white;font-size:14px">
                                                                    <strong style="font-size: 14px;">
                                                                        Total Amount : Rp
                                                                        {{ Helper::createRupiah($grand_total) }} ( <span
                                                                            style="font-style: italic;">{{ Helper::terbilang($grand_total) }}
                                                                            rupiah. </span>)
                                                                    </strong>
                                                                </td>
                                                                <td class="total" align="right" style="background-color:#555;color:white;font-size:14px">
                                                                    {{ Helper::createRupiah($grand_total) ?? '' }}
                                                                </td>
                                                            </tr>


                                                        </tbody>
                                                    </table>

                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>

                            </td>
                            <td width="15"
                                style="border-collapse:collapse;border-spacing:0;font-family:Arial,sans-serif;color:#999;line-height:1.5;margin:0;padding:0">
                            </td>
                        </tr>
                        <tr>
                            <td height="30" width="15"
                                style="border-collapse:collapse;border-spacing:0;font-family:Arial,sans-serif;color:#999;line-height:1.5;margin:0;padding:0">
                            </td>
                            <td height="30" width="550"
                                style="border-collapse:collapse;border-spacing:0;font-family:Arial,sans-serif;color:#999;line-height:1.5;margin:0;padding:0">
                            </td>
                            <td height="30" width="15"
                                style="border-collapse:collapse;border-spacing:0;font-family:Arial,sans-serif;color:#999;line-height:1.5;margin:0;padding:0">
                            </td>
                        </tr>
                    </tbody>
                </table>
            </td>
        </tr>
        <tr>
            <td
                style="border-collapse:collapse;border-spacing:0;font-family:Arial,sans-serif;color:#999;line-height:1.5;margin:0;padding:0">
                <table align="left" id="m_-3784408755349078820securityAnnouncementWrapper" width="100%"
                    style="border-collapse:collapse;border-spacing:0;font-size:13px;margin:0;padding:0"
                    bgcolor="#f0f0f0">
                    <tbody>
                        <tr>
                            <td height="5" width="15"
                                style="border-collapse:collapse;border-spacing:0;font-family:Arial,sans-serif;color:#999;line-height:1.5;margin:0;padding:0">
                            </td>
                            <td height="5" width="24"
                                style="border-collapse:collapse;border-spacing:0;font-family:Arial,sans-serif;color:#999;line-height:1.5;margin:0;padding:0">
                            </td>
                            <td height="5" width="10"
                                style="border-collapse:collapse;border-spacing:0;font-family:Arial,sans-serif;color:#999;line-height:1.5;margin:0;padding:0">
                            </td>
                            <td height="5" width="516"
                                style="border-collapse:collapse;border-spacing:0;font-family:Arial,sans-serif;color:#999;line-height:1.5;margin:0;padding:0">
                            </td>
                            <td height="5" width="15"
                                style="border-collapse:collapse;border-spacing:0;font-family:Arial,sans-serif;color:#999;line-height:1.5;margin:0;padding:0">
                            </td>
                        </tr>

                    </tbody>
                </table>

            </td>
        </tr>

    </tbody>
</table>