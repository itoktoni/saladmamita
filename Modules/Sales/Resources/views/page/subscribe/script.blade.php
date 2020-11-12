<x-area :selector="['from_area', 'to_area']" />
<x-date :array="['date']" />
<x-mask :array="['number', 'money']" />
<x-editor />

@push('javascript')
namespace Modules\Sales\Resources\views\page\order;
<script>
$(document).ready(function() {

    function calculate() {

        var qty = $('#qty').val();
        var price = $('#price').val();
        var disc = $('#disc').val();
        var total = numeral(qty).value() * numeral(price).value();

        if (disc != '') {
            total = total - (total * numeral(disc).value() / 100);
        }

        var mask_total = numeral(total).format('0,0');
        var sub_total = $('#sub_total').val(mask_total);
    }

    function sumTotal() {

        var sum = 0;
        $('.temp_total').each(function() {
            sum += numeral($(this).val()).value();
        });

        var value_total_product = numeral(sum).value();

        var total_name = $('#total_name');
        var total_value = $('#total_value');
        var total_input = $('#hidden_total');
        var total_product = $('#total_product');
        var total_payment = $('#total_payment');
        var before_discount = $('#before_discount');

        var disc = $('#grand_discount_value');
        var price = numeral(disc.val()).value();
        var mask_price_discount = numeral(price).format('0,0');

        var total_discount = sum - price;
        var mask_total_discount = numeral(total_discount).format('0,0');
        sum = total_discount;
        $('#grand_total').val(mask_total_discount);

        var ongkir = $('#ongkirs');
        var total_ongkir = 0;
        if (ongkir.val() != '') {

            var value_ongkir = numeral(ongkir.val()).value();
            var total_ongkir = sum + value_ongkir;
            var mask_total_ongkir = numeral(total_ongkir).format('0,0');

            sum = total_ongkir;
        }

        total_name.text('Total');
        total_input.val(sum);
        total_value.text(numeral(sum).format('0,0'));
        total_product.val(numeral(sum).format('0,0'));
        total_payment.text(numeral(sum).format('0,0'));
        before_discount.val(numeral(value_total_product).format('0,0'));

        $('#grand_discount_price').val(mask_price_discount);
        $('#grand_discount_total').val(mask_total_discount);

        // $('#ongkirs').val(mask_total_ongkir);
        $('#grand_total').val(numeral(sum).format('0,0'));
    }

    function addDetail(e) {
        var input_product = $('#product option:selected');
        var input_variant = $('#variant option:selected');
        var input_qty = $('#qty');
        var input_price = $('#price');
        // var input_disc = $('#disc');
        // var input_desc = $('#desc');
        var input_notes = $('#notes');
        var input_sub_total = $('#sub_total');

        if (input_product.val() == '') {
            new PNotify({
                title: 'Error Select Product',
                text: 'You must select Product',
                addclass: 'notification-danger',
                icon: 'fa fa-bolt'
            });

            return false;
        }

        var product_id = input_product.val();
        var product_name = input_product.text().trim();
        var product_qty = input_qty.val();
        var product_price = input_price.val();
        var product_notes = input_notes.val();
        // var product_disc = input_disc.val();
        // var product_desc = input_desc.val();

        var product_total = numeral(product_qty).value() * numeral(product_price).value();

        // var product_potongan = 0;
        // if(product_disc != ''){
        //     product_potongan = (product_total * numeral(product_disc).value() / 100);
        //     product_total = product_total - product_potongan;
        // }

        var mask_total = numeral(product_total).format('0,0');
        var real_price = numeral(product_price).value();

        var counter = $(".temp_total").length;

        if (product_id) {

            var product_price = numeral(product_price).value();
            if (product_name) {

                var ep = document.getElementsByName('temp_id[]');
                for (i = 0; i < ep.length; i++) {
                    if (ep[i].value.trim() == product_id.trim()) {

                        new PNotify({
                            title: 'Product Already Exist',
                            text: 'Product ' + product_name.trim() + ' , Already in Table ',
                            addclass: 'notification-danger',
                            icon: 'fa fa-bolt'
                        });

                        return;
                    }
                }
                var total = numeral(product_price).value() * numeral(product_qty).value();
                var markup = "<tr>" +
                    "<td data-title='ID' class='col-lg-1'><button id='delete' value='" + product_id +
                    "' type='button' class='btn btn-danger btn-xs btn-block'>" + product_id + "</button></td>" +
                    "<td data-title='Product'>" +
                    "<input class='form-control input-sm text-left' readonly name='detail[" + counter +
                    "][temp_product]' value='" + product_name + "'>" +
                    // "<div class='input-group input-group-sm'>"+
                    // "<input tabindex='"+counter+"3' type='text' name='detail[" + counter + "][temp_desc]' value='" + product_desc + "' class='form-control text-left'>"+
                    // "<span class='input-group-btn'>"+
                    // "<button class='btn btn-default' type='button'>Disc</button></span></div>"+
                    "<textarea rows='2' name='detail[" + counter +
                    "][temp_notes]' class='form-control text-left simple' placeholder='notes'>" +
                    product_notes + "</textarea>" +
                    "</td>" +
                    "<td data-title='Qty' class='text-right col-lg-1'>" +
                    "<input tabindex='" + counter +
                    "1' class='form-control input-sm text-right number temp_qty' name='detail[" + counter +
                    "][temp_qty]' value='" + product_qty + "'>" +
                    // "<input tabindex='"+counter+"4' class='form-control input-sm text-right number temp_disc' name='detail[" + counter + "][temp_disc]' value='" + product_disc + "'></td>"+
                    "<td data-title='Price' class='text-right col-lg-1'>" +
                    "<input tabindex='" + counter + "2' name='detail[" + counter +
                    "][temp_price]' class='form-control input-sm text-right number temp_price' value='" +
                    numeral(product_price).format('0,0') + "'>" +
                    // "<input name='detail[" + counter + "][temp_potongan]' readonly class='form-control input-sm text-right number temp_potongan' value='" + numeral(product_potongan).format('0,0') +"'></td>"+
                    "<td data-title='Total' class='text-right col-lg-1'><input type='text' name='detail[" +
                    counter +
                    "][temp_total]' readonly class='form-control input-sm text-right money temp_total' value='" +
                    mask_total + "'></td>" +
                    "<input type='hidden' value='" + product_id + "' name='detail[" + counter +
                    "][temp_id]'><input type='hidden' value='" + product_id + "' name='temp_id[]'>" +
                    "'" +
                    "</tr>";
                $("#transaction .markup").append(markup);
                sumTotal();
                $('#price').val("");
                $('#qty').val("");
                $('#disc').val("");
                $('#sub_total').val("");
                $('#notes').val("");

                $('#price').attr("placeholder", "").blur();
                $('#qty').attr("placeholder", "").blur();

                $('#product').val(0);
                $('#product').trigger("chosen:updated");

                return false;
            } else {

                new PNotify({
                    title: 'Choose Product',
                    text: 'Please Select Product !',
                    addclass: 'notification-danger',
                    icon: 'fa fa-bolt'
                });
            }
        } else {
            new PNotify({
                title: 'Price and Quantity',
                text: 'Please Input Price & Quantity !',
                addclass: 'notification-danger',
                icon: 'fa fa-bolt'
            });
        }
    }

    $('#from_id').change(function(e) {
        var id = $("#from_id option:selected").val();
        $.ajax({
            url: '{{ route("branch_api") }}',
            method: 'POST',
            data: {
                id: id,
                "_token": "{{ csrf_token() }}"
            },
            success: function(result) {
                if (result) {
                    $('#from_name').val(result.branch_name);
                    $('#from_phone').val(result.branch_phone);
                    $('#from_email').val(result.branch_email);
                    $('#from_address').val(result.branch_address);

                    var from_area = $('#from_area');
                    from_area.empty();
                    from_area.append('<option value="' + result
                        .branch_rajaongkir_area_id +
                        '">' + result.rajaongkir_area_province_name + ' - ' + result
                        .rajaongkir_area_type + ' ' + result.rajaongkir_area_city_name +
                        ' - ' + result.rajaongkir_area_name + '</option>');

                    from_area.val(result.branch_rajaongkir_area_id);
                    from_area.trigger("chosen:updated");
                }
            }
        });
    });

    $('#to_id').change(function(e) {
        var id = $("#to_id option:selected").val();
        $.ajax({
            url: '{{ route("customer_api") }}',
            method: 'POST',
            data: {
                id: id,
                "_token": "{{ csrf_token() }}"
            },
            success: function(result) {
                if (result) {
                    $('#to_name').val(result.crm_customer_contact_person);
                    $('#to_phone').val(result.crm_customer_contact_phone);
                    $('#to_email').val(result.crm_customer_contact_email);
                    $('#to_address').val(result.crm_customer_contact_address);

                    var to_area = $('#to_area');
                    to_area.empty();
                    to_area.append('<option value="' + result
                        .crm_customer_contact_rajaongkir_area_id +
                        '">' + result.rajaongkir_area_province_name + ' - ' + result
                        .rajaongkir_area_type + ' ' + result.rajaongkir_area_city_name +
                        ' - ' + result.rajaongkir_area_name + '</option>');

                    to_area.val(result.crm_customer_contact_rajaongkir_area_id);
                    to_area.trigger("chosen:updated");
                }
            }
        });
    });

    var markup_variant = '';

    $('#product').change(function(e) {
        var id = $("#product option:selected").val();
        $.ajax({
            url: '{{ route("product_api") }}',
            method: 'POST',
            data: {
                id: id,
                "_token": "{{ csrf_token() }}"
            },
            success: function(result) {
                if (result) {

                    console.log(result);
                    var value_qty = numeral(result.item_product_min_order).value();

                    var value_price = numeral(result.item_product_sell).value();
                    var mask_price = number_format(value_price);

                    var price = $('#price').val(mask_price);
                    var total = value_qty * value_price;

                    var sub_total = $('#sub_total').val(number_format(total));
                    // $('#notes').val(result.item_product_description.toString());

                    setTimeout(function() {
                        $('#qty').focus();
                        $('#qty').val(value_qty);
                    });
                }
            }
        });
    });

    $('#grand_tax_id').change(function() {
        var id = $("#grand_tax_id option:selected").val();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: "{{ route('tax_api') }}",
            method: 'POST',
            data: {
                id: id,
            },
            success: function(response) {
                if (response.code == 0) {

                    new PNotify({
                        title: 'Information Promo !',
                        text: response.message,
                        addclass: 'notification-danger',
                        icon: 'fa fa-bolt'
                    });

                    $("#grand_tax_id").val('');
                    $("#grand_tax_id").trigger("chosen:updated");
                    return false;
                }

                var tax_value = response.finance_tax_value;
                var tax_name = response.finance_tax_name;
                var tax_type = response.finance_tax_type;

                $('#grand_tax_value').val(tax_value);
                sumTotal();
            }
        });
    });

    $("#detail").on('input', '#qty', function() {
        calculate();
    });

    $("#detail").on('input', '#price', function() {
        calculate();
    });

    $("#detail").on('input', '#disc', function() {
        calculate();
    });

    $("#transaction").on('input', '.temp_qty', function() {
        var qty = $(this).val();
        var price = $(this).closest('tr').find('.temp_price');
        var total = $(this).closest('tr').find('.temp_total');

        var value_total = numeral(qty).value() * numeral(price.val()).value();
        var potongan = $(this).closest('tr').find('.temp_potongan');
        var disc = $(this).closest('tr').find('.temp_disc');
        if (disc != '') {
            var discount = (value_total * numeral(disc.val()).value()) / 100;
            potongan.val(numeral(discount).format('0,0'));
            value_total = value_total - discount;
        }

        total.val(numeral(value_total).format('0,0'));
        sumTotal();
    });

    $("#transaction").on('input', '.temp_price', function() {
        var price = $(this).val();
        var qty = $(this).closest('tr').find('.temp_qty');
        var total = $(this).closest('tr').find('.temp_total');

        var value_total = numeral(qty.val()).value() * numeral(price).value();

        var potongan = $(this).closest('tr').find('.temp_potongan');
        var disc = $(this).closest('tr').find('.temp_disc');
        if (disc != '') {
            var discount = value_total * numeral(disc.val()).value() / 100;
            potongan.val(numeral(discount).format('0,0'));
            value_total = value_total - discount;
        }

        total.val(numeral(value_total).format('0,0'));
        sumTotal();
    });

    $("#transaction").on('input', '.temp_disc', function() {
        var price = $(this).closest('tr').find('.temp_price');
        var qty = $(this).closest('tr').find('.temp_qty');
        var total = $(this).closest('tr').find('.temp_total');

        var value_total = numeral(qty.val()).value() * numeral(price.val()).value();

        var potongan = $(this).closest('tr').find('.temp_potongan');
        var disc = $(this).val();
        if (disc != '') {
            var discount = value_total * numeral(disc).value() / 100;
            potongan.val(numeral(discount).format('0,0'));
            value_total = value_total - discount;
        }

        total.val(numeral(value_total).format('0,0'));
        sumTotal();
    });

    $("#transaction").on('input', '#grand_discount_value', function() {
        sumTotal();
    });

    $("#transaction").on('input', '#ongkirs', function() {
        sumTotal();
    });

    $("#transaction").on('input', '#grand_tax_value', function() {
        sumTotal();
    });

    $('#qty').keypress(function(e) {
        if (e.which == '13') {
            addDetail();
            e.preventDefault();
        }
    });

    $('#sub_total').keypress(function(e) {
        if (e.which == '13') {
            addDetail();
            e.preventDefault();
        }
    });

    $('#transaction').arrowTable();

    $('#price').keypress(function(e) {
        if (e.which == '13') {
            addDetail();
            e.preventDefault();
        }
    });

    $(document).on('click', '#delete', function(e) {
        e.preventDefault();
        var url = $(this).attr('href');
        var id = $(this).attr('value');
        $.alertable.confirm('Are You sure to delete ?').then(function(e) {
            if (typeof url !== typeof undefined && url !== false) {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    url: url,
                    method: 'POST',
                    success: function() {
                        $('.delete-' + id).closest("tr").remove();
                        sumTotal();
                    }
                });
            } else {
                $('button[value="' + id + '"]').parents("tr").remove();
                sumTotal();
            }
            $("#product").val('');
            $("#product").trigger("chosen:updated");
        }, function(x) {
            console.log('Confirmation canceled');
        });
    });

    $("#add").click(function(e) {
        addDetail(e);
        e.preventDefault();
    });

});
</script>
@endpush