
var number_of_WebSite = $("#numOfWeb");
var tr_placement = $("#tr-placement");
var tr_quantity = $("#quantity");
var row_sum_prod_name = $(".row_sum_prod");
var sum_prod_name = $(".product-sum-name");
var sum_prod_qty = $(".span-calc-qty");
var sum_prod_total = $(".span-calc-total");

//discount_type(discount_id) 1->%, 2->$
var discount_type; 
var discount;
var apply_click = null;

// $('#quantity').on('change', function(e) {
//     console.log('qweqwe');
//    // console.log(e.currentTarget);
// });


// Handler for .ready() called for jQuery 3.0 syntax is recommended.
$(function() {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    apply_click = true;
    renderRowProd();
    changeInputValue();
    subtotalCalc();
    applyDefaultDiscount();
});

function renderRowProd() {
    $(".t_body").empty();
    $(".row_for_insert").empty();

    for (var i = 0; i < number_of_WebSite.val(); i++) {
        tr_placement.attr('id', 'trProd_' + i);
        tr_quantity.attr('id', 'trQty_' + i);
        row_sum_prod_name.attr('id', 'rowSumProd_' + i);
        sum_prod_name.attr('id', 'sumProdName_' + i);
        sum_prod_qty.attr('id', 'sumProdQty_' + i);
        sum_prod_total.attr('id', 'sumProdTotal_' + i);


        var tr_prod_html = tr_placement.get(0).outerHTML;
        var row_sum_prod_html = row_sum_prod_name.get(0).outerHTML;

        $(".t_body").append(tr_prod_html);
        $(".row_for_insert").append(row_sum_prod_html);
    }
}

$( "#numOfWeb").blur(function() {
    var number_of_WebSite = Number($("#numOfWeb").val());
    var web_site_price = $("#web_price").val();
    $(".span-calc-qty-web").text(number_of_WebSite);

    $(".span-calc-total-web").text(web_site_price * number_of_WebSite);

    renderRowProd();
    changeInputValue();
    subtotalCalc();
    // discountApply();
    applyDefaultDiscount();
});

function changeInputValue() {
    $('.change_q').on('click', function (e) {
        var price = Number($("#product_price").val());

        if(e.target.value === "+"){
            var tr_row_id = $(e.currentTarget).parent().parent().attr('id');
            var clearId = getIdNumber(tr_row_id);
            var tr_qty_class = '#trQty_' + clearId;

            var current_value = Number($(e.currentTarget).children(tr_qty_class).val()) + 1;
            if(current_value > 99){current_value = 99;}
            $(e.currentTarget).children(tr_qty_class).val(current_value);

            var total = Number(price) * Number(current_value);

            var sum_prod_qty_id = '#sumProdQty_'+clearId;
            var sum_prod_total_id = '#sumProdTotal_'+clearId;
            var tr_prod_qty = $(tr_qty_class).val();
            var sum_prod_qty = $(sum_prod_qty_id);
            var div_class_bull = $(e.currentTarget).parent();

            $($(div_class_bull)[0].nextElementSibling).children('#total_row').text(total);
            $(sum_prod_qty).text(tr_prod_qty);
            $(sum_prod_total_id).text(total);
            subtotalCalc();


            var discount_type_id = $('#coupon_id').data('discountId');
            var discount_amount = $('#coupon_id').data('amount');
            console.log('test +', discount_type_id, discount_amount);
            discountApply(discount_type_id, discount_amount);
        }

        if(e.target.value === "-"){
            var tr_row_id = $(e.currentTarget).parent().parent().attr('id');
            var clearId = getIdNumber(tr_row_id);
            var tr_qty_class = '#trQty_' + clearId;

            var current_value = Number($(e.currentTarget).children(tr_qty_class).val()) - 1;
            if(current_value < 1){current_value = 1;}

            $(e.currentTarget).children(tr_qty_class).val(current_value);

            var total_ = Number(price) * Number(current_value);
            var prod_qty_id_ = '#sumProdQty_'+clearId;
            var prod_total_id_ = '#sumProdTotal_'+clearId;
            // console.log(prod_qty_id_);
            var tr_prod_qty_ = $(tr_qty_class).val();
            var sum_prod_qty_ = $(prod_qty_id_);
            sum_prod_qty_.text(tr_prod_qty_);

            var div_class_bull = $(e.currentTarget).parent();
            $($(div_class_bull)[0].nextElementSibling).children('#total_row').text(total_);
            $(prod_total_id_).text(total_);
            subtotalCalc();

            var discount_type_id = $('#coupon_id').data('discountId');
            var discount_amount = $('#coupon_id').data('amount');
            console.log('test -', discount_type_id, discount_amount);
            discountApply(discount_type_id, discount_amount);
        }
    });
}

//take id like "trProd_0" and return just number "0"
function getIdNumber(compoundId) {
    var compoundIdArr = compoundId.split("_");
    var clearId = compoundIdArr[1];
    return Number(clearId);
}

//render subtotal and final_total order
function subtotalCalc(){
    var sum_prod_IDs = [];
    var subtotal = 0;
    $(".row_for_insert").find(".row_sum_prod").each(function(){ sum_prod_IDs.push(this.id); });
    for (var i = 0; i < sum_prod_IDs.length; i++) {
        var clearId = getIdNumber(sum_prod_IDs[i]);
        var sum_total_id = '#sumProdTotal_' + clearId;
        var prod_val = $(sum_total_id).text();
        subtotal = Number(subtotal) + Number(prod_val);
    }

    $("#subtotal").text(subtotal);

    var discount_amount_minus = (Number(subtotal) * Number(discount))/100;
    $("#discount_amount_minus").text(discount_amount_minus);

    var web_total = $(".span-calc-total-web").text();
    var sum_total_final = $("#sum_total_final").text(Number(subtotal) - Number(web_total));
}

function discountApply(discount_type, discount){

    var subtotal = $('#subtotal').text();
    // discount_type = 2;
    if (discount_type == 1){
        console.log('%');

        var total_with_discount_type_1 = Number($("#sum_total_final").text()) * (100 - Number(discount))/100;
        $("#sum_total_final").text(total_with_discount_type_1);

        // console.log(Number(subtotal));
        // console.log(Number(discount));

        var discount_amount_minus = (Number(subtotal) * Number(discount))/100;
        $("#discount_amount_minus").text(discount_amount_minus);

        console.log(total_with_discount_type_1);
        // а=1040*(100-23):100=800
    }else if(discount_type == 2){
        console.log('$');

        var total_with_discount_type_2 = Number($("#sum_total_final").text()) - Number(discount);

        $("#sum_total_final").text(total_with_discount_type_2);
        $("#discount_amount_minus").text(discount);
    }else{
        var subtotal = $('#subtotal').text();
        $("#sum_total_final").text(subtotal);
    }
}

function applyDefaultDiscount() {
    // var data_coupon_id = $('#coupon_id');
    var data_coupon_id = $('#coupon_id').data('couponId');
    var discount_type_id = $('#coupon_id').data('discountId');
    var discount_amount = $('#coupon_id').data('amount');

    discountApply(discount_type_id, discount_amount);
    
    
    console.log(data_coupon_id, discount_type_id, discount_amount);
}

$('#btn-my').on('click', function() {
    //First Order
    if (!apply_click){
        var coupon = $('#coupon').val();
        console.log(coupon);

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: '/getCoupon',
            type: "POST",
            data: {'coupon_name':coupon},
            success: function(data) {
                console.log(data);

                if (data !== 'coupon_not_found'){
                    apply_click = true;
                    discount_type = data.discount_id;
                    discount = data.amount;

                    $('#coupon_id').attr('data-discount-id', data.discount_id);
                    $('#coupon_id').data('discountId', data.discount_id);

                    $('#coupon_id').attr('data-amount', data.amount);
                    $('#coupon_id').data('amount', data.amount);


                    $('#coupon_id').attr('data-coupon-id', data.id);
                    $('#coupon_id').data('couponId', data.id);
                    // if (data.expiry_date == null || data.expiry_date > 1){
                    //     console.log(new Date());
                    // }
                    $('.coupon_not_found').text('');

                    $('#coupon_id').val(data.id);
                    $('#span_coupon_name').text(data.name);

                    // console.log(data.name);
                    $('#coupon_row').show();

                    subtotalCalc();
                    discountApply(discount_type, discount);
                }else {
                    $('.coupon_not_found').text('Coupon not found');
                }
                // console.log(data);
                // console.log(new Date());
                // discount_type = 2;
                // $("#sum_total_final").text();
                // $("#sum_total_final").text(Number(subtotal) + Number(web_total));
                // console.log(data);


            },
            error: function (er) {
                $('.coupon_not_found').text('');
                console.log(er);
            }
        });
        return false;
    }else{
        $('.coupon_not_found').text('Coupon already applied !');
        $('#coupon_id').val();
        // console.log(apply_click);
    }
});


$('.linkRemoveCoupon').on('click', function(event){
    event.preventDefault();

    $('#coupon_row').hide();
    // console.log($('#data'));
    $('#coupon_id').attr('data-discount-id', '');
    $('#coupon_id').data('discountId', '');

    $('#coupon_id').attr('data-amount', '');
    $('#coupon_id').data('amount', '');

    $('#coupon_id').attr('data-coupon-id', '');
    $('#coupon_id').data('couponId', '');
    discount = 0;
    // $('#coupon_id').val('');


    apply_click = null;
    subtotalCalc();

    // $('#sum_total_final').text(subtotal);
    $('.coupon_not_found').text('');

    var discount_type_id = $('#coupon_id').data('discountId');
    var discount_amount = $('#coupon_id').data('amount');


    // discountApply(discount_type_id, discount_amount);
    // $('#')
});




