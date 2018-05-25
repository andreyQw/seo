@extends('layouts.dashboard_layout')

@section('name', 'Orders')

@section('content')

    @include('order.order_edit_modal')

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/css/datepicker.min.css">
    <link rel="stylesheet" href="{{ asset('css/order_manager_style.css') }}">

    <div class="row orders_cont">
        <div class="header-order-manager">
            <div class="col-md-12 col-sm-12 col-xs-12">
               <div class="col-md-7 col-sm-3 col-xs-12 all_orders"> <span class="add_anchors_links">All orders</span></div>
               <div class="col-md-5 col-sm-9 col-xs-12 first-table">
                <table>
                <tr>
                    <th><a href="{{ route('allOrdersClient')}}">All </a><span>({{ $allOrdersCount }})</span></th>
                    <th><a href="{{ route('ordersOnHoldFilter')}}">On Hold </a><span>({{ $on_holdOrdersCount }})</span></th>
                    <th><a href="{{ route('ordersCompletedFilter')}}">Completed
                    </a><span>({{ $completedCount }})</span></th>
                    <th><a href="{{ route('ordersRefundedFilter')}}">Refunded </a> <span>({{ $refundedOrdersCount }})</span></th>
                </tr>
                </table>
                </div>
            </div>
               <div class="col-md-12 col-sm-12 col-xs-12 header-button">
                <div class="col-md-2 col-sm-6 select-bulk-action">
                    <select class="form-control" id="bulk_action" name="bulk_action">
                        <option selected="selected" value="default">Bulk Action</option>
                        <option value="approve">Approve</option>
                        <option value="edit">Edit</option>
                        <option value="delete">Delete</option>
                        <option value="refunded">Refund</option>
                    </select>
                </div>
                <div class="col-md-1 col-sm-6 button-apply">
                    <button id="orderAction">Apply</button>
                </div>
                <div class="col-md-3 col-sm-6 col-xs-12 all-dates">
                    <div id="reportrange" class="pull-right">
                       <div class="inside-all-dates">
                        <i class="glyphicon glyphicon-calendar fa fa-calendar"></i>&nbsp;
                        <span></span> <b class="caret"></b></div>
                    </div>
                </div>
                <div class="col-md-5 col-sm-6 col-xs-12 search-customer">
                    <input id="search_customer" type="text"
                           class=""
                           name="search_customer"
                           value=""
                           placeholder="Search for a Customer">
                </div>
                <div class="col-md-1 col-sm-4 col-xs-12 button-filter">
                    <button id="find_by_name_btn">Filter</button>
                </div>
                </div>
        </div>
        <div id="table_insert" class="col-md-12 col-sm-12 col-xs-12">
            <table class="table table-striped orders_table">
                <tr>
                    <th>                  
                    <label>
                        <input class="checkbox" type="checkbox" id="check_all" name="checkbox-test">
                        <span class="checkbox-custom"></span>
                        <span class="label-1">Invoice No</span>
                    </label>
                    </th>
                    <th>Orders</th>
                    <th>Purchased</th>
                    <th>Status</th>
                    <th>Date</th>
                    <th>Total</th>
                    <th>Action</th>
                </tr>
                @if($orders)
                @foreach($orders as $order)
                    <tr>
                    <td>
                <label>
                    <input class="checkbox data_order" type="checkbox" id="{{ 'orderId_'.$order->id }}" name="checkbox-test">
                    <span class="checkbox-custom"></span>
                    <span class="label">{{ $order->invoice->id }}</span>
                </label>
                              
                               
                    </td>
                    <td>
                        <div>
                            <span>#{{ $order->id }}</span>
                        </div>
                        By
                        {{ $order->user->first_name}}
                        {{ $order->user->last_name}}
                        <span class="order_email">{{ $order->user->email}}</span>
                    </td>
                    <td>{{ count($order->projects)}} items</td>
                    <td>
                        <select name="status" id="row_ord" class="row_ord">
                            <option value="completed" ord_id="{{$order->id}}" @if($order->approve_status == 'completed')selected="selected"@endif>Completed</option>
                            <option value="on_hold" ord_id="{{$order->id}}" @if($order->approve_status == 'on_hold')selected="selected"@endif>On hold</option>
                            <option value="refunded" ord_id="{{$order->id}}" @if($order->approve_status == 'refunded')selected="selected"@endif>Refund</option>
                        </select>
                    </td>
                    <td>{{ Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $order->created_at)->format('Y/m/d') }}</td>
{{--                    <td>{{ Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $order->updated_at)->format('Y/m/d') }}</td>--}}
                    <td>$ <span> {{ $order->amount }}</span></td>
                    <td>
                        <a href="/order/invoice/look/@if($order->invoice->id){{$order->invoice->id}}@endif" target="_blank">
                            <i class="mdi mdi-eye icon_show"></i>
                        </a>
                        <a href="/order/invoice/download/@if($order->invoice->id){{$order->invoice->id}}@endif">
                            <i class="mdi mdi-file-pdf-box icon_pdf"></i>
                        </a>
                        {{--<a href="">--}}
                            {{--<i class="mdi mdi-printer icon_print"></i>--}}
                        {{--</a>--}}
                    </td>
                    </tr>
                @endforeach
                @endif


            </table>
            {{ $orders->links() }}
        </div>
    </div>
    <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.css" />

@endsection

@section('script')
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/js/bootstrap-datepicker.min.js"></script>
<script type="text/javascript" src="//cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.js"></script>

<script src="{{ asset('js/ajs/editOrder.js') }}"></script>
<script src="{{ asset('js/ajs/order_manager.js') }}"></script>

<script></script>
@endsection