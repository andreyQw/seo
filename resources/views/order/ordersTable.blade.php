<div>
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
{{--                <td>{{ Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $order->updated_at)->format('Y/m/d') }}</td>--}}
                <td>$ <span> {{ $order->amount }}</span></td>
                <td>
                    <a href="/order/invoice/look/{{$order->invoice->id}}" target="_blank">
                        <i class="mdi mdi-eye icon_show"></i>
                    </a>
                    <a href="/order/invoice/download/{{$order->invoice->id}}">
                        <i class="mdi mdi-file-pdf-box icon_pdf"></i>
                    </a>
                    {{--<a href=""><i class="mdi mdi-printer icon_print"></i></a>--}}
                </td>
            </tr>
        @endforeach
    @endif


</table>

    {{ $orders->links() }}
</div>
