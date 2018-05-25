$(function() {

    var start = moment().subtract(29, 'days');
    var end = moment();

    function cb(start, end) {
        $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
    }

    $('#reportrange').daterangepicker({
        startDate: start,
        endDate: end,
        maxDate: moment(),
//            autoApply: true,
        ranges: {
            'Today': [moment(), moment()],
            'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
            'Last 7 Days': [moment().subtract(6, 'days'), moment()],
            'Last 30 Days': [moment().subtract(29, 'days'), moment()],
            'This Month': [moment().startOf('month'), moment().endOf('month')],
            'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        }
    }, cb);
//        console.log(moment());
    cb(start, end);

    $('#reportrange').on('apply.daterangepicker', function(ev, picker) {
        console.log(picker.startDate.format('YYYY-MM-DD'));
        console.log(picker.endDate.format('YYYY-MM-DD'));

        $.ajax({
            url: '/order/ordersDateFilter',
            type: "GET",
//                data: data,
            data: {
                '_token': $('meta[name="csrf-token"]').attr('content'),
                'start_date': picker.startDate.format('YYYY-MM-DD'),
                'end_date': picker.endDate.format('YYYY-MM-DD')
            },
//                dataType: dataType,
            success: function( data ){
                $('#table_insert').html(data);
//                    console.log( data );
            },
            error: function( err ){
                console.log( err );
            }
        });
    });
});

//88888888888888888888888888888888888888888888888888888888888888888888888888

$('#orderAction').on('click',function () {
    var select_action = $('#bulk_action option:selected').val();
    var selected_order = (function() {
        var order_id = [];
        $(".data_order:checkbox:checked").each(function() {
            order_id.push(this.id);
        });
        return order_id;
    })();

    switch (select_action) {
        case 'default':
            return false;
            console.log(select_action);
//                break;
        case 'refunded':
            console.log(select_action);
            if(selected_order.length == 0){
                alert('Please select order for refunded');
            }else {
                console.log(select_action);
                var orders_id = clearOrderId(selected_order);
                console.log(orders_id);
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: '/order/refundedOrder',
                    type: "POST",
                    data: {'orders_id':orders_id},
//                dataType: dataType,
                    success: function( data ){
                        console.log( data );
//                                $('#table_insert').html(data);
                        location.reload();
//                    console.log( data );
                    },
                    error: function( err ){
                        console.log( err );
                    }
                });
            }
            break;
        case 'approve':
            if(selected_order.length == 0){
                alert('Please select order for approve');
            }else {
                var orders_id = clearOrderId(selected_order);

                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: '/order/approveOrder',
                    type: "POST",
                    data: {'orders_id':orders_id},
//                dataType: dataType,
                    success: function( data ){
                        console.log( data );
//                                $('#table_insert').html(data);
                        location.reload();
                    },
                    error: function( err ){
                        console.log( err );
                    }
                });
            }
            break;
        case 'edit':
            console.log(select_action);
//                console.log(selected_order.length);
            if(selected_order.length > 1){
                alert('please select only one order for edit');
                return false;
            }else if(selected_order.length == 0){
                alert('Please select one order for edit');
            }
            else{
//                    console.log(selected_order);
                var order_id = clearOrderId(selected_order)[0];
                var t_body_childs = $('#t_body').children();
                var sum_body_childs = $('#sum_proj_all').children();
//                    console.log(t_body_childs);
                for(var q = 0; q < t_body_childs.length; q++){
                    if (q !== 0){
                        t_body_childs[q].remove();
                        sum_body_childs[q].remove();
                    }
                }

                $('#order_modal').modal('show');
                //999999999999999999999999999999999999
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: '/order/getOrderAjax/'+order_id,
                    type: "GET",
//                        data: {orders_id},
                    success: function( data ){
                        console.log( data );
                        $('#order_id').val(data.order_id);
                        // $('#user_id').val(data.order_id);
//                            $('#tr_project').remove();
                        var sub_total_sum = 0;
                        for (var i = 0; i < data.projects.length; i++){
                            var tr_project = $('#tr_project').clone();
                            var sum_proj_row = $('#sum_proj_row').clone();
//                                console.log(data.projects[i]);
                            tr_project.attr('id', $('.row_table').length);
                            // tr_project.attr('id', 'trProject_'+data.projects[i].project_id);
                            // tr_project.children().eq(0).attr('id', 'projId_'+data.projects[i].project_id);
                            tr_project.children().eq(0).children().attr('id', 'urlId_'+ $('.row_table').length);
                            tr_project.children().eq(0).children().attr('value', data.projects[i].project_url);

                            // console.log(tr_project.children().eq(1).children('select')[0].options);
                            jQuery.each(tr_project.children().eq(1).children('select')[0].options, function () {

                                if($(this).val() == data.projects[i].product_id){
                                    this.selected = true;
                                }
                            });

                            tr_project.children().eq(2).children().children('input')
                                .attr('id', 'quantity_'+ $('.row_table').length )
                                .val(data.projects[i].product_quantity);
                            tr_project.children().eq(2).children().children('input')
                                .attr('prod_price', data.projects[i].product_price);
                            tr_project.children().eq(2).children().children('input')
                                .attr('proj_id', data.projects[i].project_id);
                            tr_project.children().eq(2).children().children('input')
                                .attr('row', $('.row_table').length);
                            tr_project.children().eq(3).children('span.product')
                                .attr('id', 'total_row_'+ $('.row_table').length )
                                .text(Number(data.projects[i].product_quantity) * Number(data.projects[i].product_price));
                            sub_total_sum += Number(data.projects[i].product_quantity) * Number(data.projects[i].product_price);
                            tr_project.children().eq(3).children('input').val(data.projects[i].project_id);


                            // console.log(sum_proj_row.children('span#pr_qty'));
                            // console.log(Number(data.projects[i].product_quantity) * Number(data.projects[i].product_price));

                            sum_proj_row.children('span#pr_title').text(data.projects[i].product_title);
                            sum_proj_row.children('span#pr_qty').text(data.projects[i].product_quantity);
                            sum_proj_row.children('span.rght').children('span#pr_total')
                                .text(Number(data.projects[i].product_quantity) * Number(data.projects[i].product_price));


                            $('#numb_of_proj').text(data.projects.length);
                            sum_proj_row.show();
                            $('#sum_proj_all').append(sum_proj_row);

                            tr_project.show();
//                                    console.log( );
                            $('#t_body').append(tr_project);
//                                console.log(tr_project);
                        }
                        // console.log(sub_total_sum);
                        $('#subtotal').text(sub_total_sum);

                        var coupon_row = $('#coupon_row');
                        coupon_row.show();
                        //discount_type(discount_id) 1->%, 2->$
                        var total_discount = 0;
                        for (var j = 0; j < data.coupons.length; j++){
                            console.log(data.coupons[j].name);
                            console.log(coupon_row.find('span#span_coupon_name'));

                            coupon_row.find('span#span_coupon_name').text(data.coupons[j].name);
                            if (data.coupons[j].discount_id == 1){
                                coupon_row.find('span#discount_amount_minus')
                                    .text(sub_total_sum * Number(data.coupons[j].amount)/100);
                                total_discount += sub_total_sum * Number(data.coupons[j].amount)/100;
                            }else {
                                coupon_row.find('span#discount_amount_minus')
                                    .text(data.coupons[j].amount);
                                total_discount += Number(data.coupons[j].amount);
                            }
                            // coupon_row.find('span#span_coupon_name');
                        }
                        $('#sum_total_final').text(sub_total_sum - total_discount);
                        $('#email').val(data.email);
//                            $('#t_body');
//                    console.log( data );
                    },
                    error: function( err ){
                        console.log( err );
                    }
                });
                //9999999999999999999999999999999999999
            }

            break;
        case 'delete':
            console.log(select_action);
            console.log(selected_order);
            if(selected_order.length == 0){
                alert('Please select order for delete');
            }else {
                console.log(select_action);
                var orders_id = clearOrderId(selected_order);
                console.log(orders_id);
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: '/order/deleteOrder',
                    type: "POST",
                    data: {'orders_id':orders_id},
                    success: function( data ){
                        console.log( data );
                        // $('#table_insert').html(data);
                        location.reload();
                    },
                    error: function( err ){
                        console.log( err );
                    }
                });

            }
    }
});

$("#check_all").on('click', function() {
    var ele = $('#check_all');
    if (ele.is(':checked')){
        //        console.log($(".data_order"));
        $(".data_order").each( function() {
//            console.log($('#'+this.id));
            $('#'+this.id).prop("checked", true);
        });
    }
    else {
        $(".data_order").each( function() {
//                console.log($('#'+this.id));
            $('#'+this.id).prop("checked", false);
        });
    }
});

$("#find_by_name_btn").on('click', function () {
    var name = $("#search_customer").val();

    console.log(name);
    var data = {'path_name' : name};
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url: '/order/ordersNameFilter',
        type: "GET",
        data: data,
        success: function( data ){
            $('#table_insert').html(data);
            // console.log( data );
        },
        error: function( err ){
            console.log( err );
        }
    });
});

function clearOrderId(arr) {
    var clearArrId = new Array();

    for (var i = 0; i < arr.length; i++) {
        console.log(arr[i].substring(8));
        clearArrId.push(arr[i].substring(8));
//            clearArrId = arr[i].length;
    }
    return clearArrId;
}

function changeQty(event) {
    if (event.target.value === "+") {
        var proj_id = $(event.currentTarget).children('input').attr('row');
        var price = $(event.currentTarget).children('input').attr('prod_price');
        var qty = $(event.currentTarget).children('input').val();

        console.log((Number(qty) + 1));

        $(event.currentTarget).children('input').val(Number(qty) + 1);
        $('#total_row_' + proj_id).text((Number(qty) + 1) * price);
    }

    if (event.target.value === "-") {
        var proj_id = $(event.currentTarget).children('input').attr('row');
        var price = $(event.currentTarget).children('input').attr('prod_price');
        var qty = $(event.currentTarget).children('input').val();

        if(Number(qty) <= 1) return false;
        // $('#product_price').val();
        console.log((Number(qty) - 1));

        $(event.currentTarget).children('input').val(Number(qty) - 1);
        $('#total_row_' + proj_id).text((Number(qty) - 1) * price)
    }
}

function prod_change(event) {
    var price = event.currentTarget.options[event.currentTarget.selectedIndex].getAttribute('prodprice');

    // console.log($(event.currentTarget).parent().parent().attr('id'));
    var row_id = $(event.currentTarget).parent().parent().attr('id') ;
    var qty = $('#quantity_' + row_id).val();
    $('#quantity_' + row_id).attr('prod_price', price);
    $('#total_row_' + row_id).text(Number(qty) * price);
    console.log(price);
}

function deleteProjRow(event) {
    $(event.currentTarget).parent().parent().remove();
}

$('select.row_ord').on('change', function(event)
{
    var status = this.value;
    var order_id = event.currentTarget.options[event.currentTarget.selectedIndex].getAttribute('ord_id');
    var orders_id = [order_id];
    // console.log(status);

    var url;
    switch (status)
    {
        case "completed":
            // alert('completed');
            url = '/order/approveOrder';
            break;
        case "on_hold":
            url = '/order/onHoldOrder';
            // alert('on_hold');
            break;
        case "refunded":
            url = '/order/refundedOrder';
            // alert('refunded');
            break;
        // default:
        //     alert('Default case');
    }
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url: url,
        type: "POST",
        data: {'orders_id':orders_id},
//                dataType: dataType,
        success: function( data ){
            // console.log( data );
            location.reload();
//                    console.log( data );
        },
        error: function( err ){
            console.log( err );
        }
    });
    
});