@extends('layouts.dashboard_layout')
@section('name','Dashboard')
@section('content')
    <link rel="stylesheet" href="{{ asset('css/website.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/css/datepicker.min.css">
{{--{!! Form::open(['route' => 'clients.store', 'class' => 'form-horizontal', 'method'=>'POST' ]) !!}--}}
    {{ csrf_field() }}


    {{--MODAL --}}

    <div class="modal fade" id="modal_new_website" role="dialog">
        <div class="modal-dialog modal-sm vertical-align-center">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                {!! Form::open(['route' => 'placements.add_more', 'class' => 'form-horizontal', 'method'=>'POST' ]) !!}
                <div class="col-sm-12 modal_view">
                <div class="modal-body">
                        <table class="table table-bordered table_modal">
                            <thead >
                            <tr>
                                <th >Product</th>
                                <th >QTY</th>
                                <th >Total</th>
                            </tr>
                            </thead>
                            <tbody >
                            {{--@foreach($products as $product)--}}
                                {{--<tr>--}}
                                {{--<td >--}}
                                    {{--<div class="bull">--}}
                                        {{--<img src="{{asset('img/orderFormLayout/bull.png')}}" alt="">--}}
                                    {{--</div>--}}
                                    {{--<span class="product">{{$product->title}}</span>--}}
                                    {{--<input id="prod_name" type="hidden" name="product_id[]" value="{{$product->id}}">--}}
                                    {{--<input id="project_id" type="hidden" name="project_id" value="{{$project->id}}">--}}
                                {{--</td>--}}
                                {{--<td>--}}
                                        {{--<input id="quantity{{$product->id}}" type="text" product_id="{{$product->id}}" class="col-md-3" value="1" name="quantity" required>--}}
                                        {{--<input id="quantity_hidden{{$product->id}}" product_id="{{$product->id}}" type="hidden" class="quantity_hidden" value="1" name="quantity_product[]" required>--}}
                                {{--</td>--}}
                                {{--<td >--}}
                                    {{--<span class="product">USD $</span> <span id="total_row{{$product->id}}" class="product">{{$product->price}}</span>--}}
                                    {{--<input id="product_price{{$product->id}}" type="hidden" name="product_price[]" value="{{$product->price}}">--}}
                                {{--</td>--}}
                            {{--</tr>--}}
                            {{--@endforeach--}}
                            </tbody>
                        </table>

                    <p class="title_checkout">Payment Option</p>
                    <div class="col-md-12 col-lg-12 cust_info_block">
                        <!--<input type="radio" name="payment_method" value="payPal" checked> PayPal
                        <img src="{{asset('img/payPal.png')}}" alt="">-->
                       <label style="color: #9d9d9d;">
                                <input type="radio" class="radio" id="radio_paypal"
                                       name="payment_method" 
                                       value="payPal">
                                       {{--route_cust="{{ route('addPaypal', [$order]) }}">--}}
                                <span class="radio-custom"></span>
                                PayPal<br>
                                </label>
                                
                                <img src="{{asset('img/payPal.png')}}" alt="" style="margin: 0 10px">
                                <span style="color: #9d9d9d; font-size: 30px;"> | </span>
                                <label style="color: #9d9d9d;">
                                <input type="radio" class="radio" id="radio_stripe"
                                       name="payment_method" 
                                       value="stripe"
                                       {{--route_cust="{{ route('addPayStripe', [$order]) }}"--}}
                                       checked >
                                    <span class="radio-custom"></span>
                                    Credit Card (Stripe) <br>
                                </label>
                                <img src="{{asset('img/stripe_new.png')}}" alt="">

                        <div class="stripe_errors">
                            @if ($errors->has('message'))
                                <span class="help-block alert-danger">
                                                <strong>{{ $errors->first('message') }}</strong>
                                            </span>
                            @endif
                        </div>
                        <div class="form-group col-md-12 col-lg-12">
                            {{--4242 4242 4242 4242--}}
                            <div class="col-md-4 col-lg-4 null_my" style="padding-left:0">
                            <input id="card_num"
                                   data-stripe="number"
                                   maxlength="16"
                                   type="text"
                                   class="form-control margin_10 col-md-4 col-lg-4"
                                   name="card_number"
                                   value="4242424242424242"
                                   placeholder="Card Number"
                                   >
                                   </div>
                            @if ($errors->has('card_number'))
                                <span class="help-block alert-danger">
                                                <strong>{{ $errors->first('card_number') }}</strong>
                                            </span>
                            @endif
<div class="col-md-4 col-lg-4 null_my">
                            <input id="cvc" type="text"
                                   maxlength="4"
                                   data-stripe="cvc"
                                   class="form-control margin_10 col-md-4 col-lg-4"
                                   name="cvc" value=""
                                   placeholder="CVC Code"
                                   >
                            </div>
                            @if ($errors->has('cvc'))
                                <span class="help-block alert-danger">
                                                <strong>{{ $errors->first('cvc') }}</strong>
                                            </span>
                            @endif

                            
                             <div class="form-group col-md-4 col-lg-4 null_my">
                                <input id="expiry"
                                       type="text"
                                       name="expiry"
                                       class="form-control expire"
                                       placeholder="Expire"
                                       >

                                @if ($errors->has('expiry'))
                                    <span class="help-block alert-danger">
                                                <strong>{{ $errors->first('expiry') }}</strong>
                                                </span>
                                @endif
                            </div>
                        </div>
                        <input type="hidden" name="currency" id="currency"
                               value="usd">
                    </div>
                </div>
            </div>
                <div class="modal-footer">
                   <div class="col-md-offset-8 col-md-4 block_btn_modal">
                    <button type="submit" class="btn btn-default btn-lg modal_btn">Pay Now</button>
                    </div>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>

@endsection
@section('script')
    {{--<script src="{{asset('js/jquery-datatables-editable/jquery.dataTables.js')}}"></script>--}}
    {{--<script src={{ asset('js/moment.min.js') }}></script>--}}

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/js/bootstrap-datepicker.min.js"></script>

    <script>

        $(document).ready(function() {
            {{--$('.table').DataTable();--}}
        $('td.approve').each(function(){
            var x = $(this).text();
                if (x == 'Approved') $(this).css({backgroundColor: '#00c974'});
                if (x == 'Rejected PBN') $(this).css({backgroundColor: '#f15d34'});
                if (x == 'Working') $(this).css({backgroundColor: '#fbaa3d'});
                if (x == 'No') $(this).css({backgroundColor: 'gray'});
                if (x == 'Done') $(this).css({backgroundColor: 'cyan'});
                if (x == 'Live') $(this).css({backgroundColor: 'gray'});
        });
        $('.feedback').each(function(){
            var x = $(this).val();
            if (x == 'Approved') $(this).css({backgroundColor: '#00c974'});
            if (x == 'Rejected PBN') $(this).css({backgroundColor: '#f15d34'});
            if (x == 'Working') $(this).css({backgroundColor: '#fbaa3d'});
            if (x == 'No') $(this).css({backgroundColor: 'gray'});

        });
            $('.feedback').change(function () {
                var x = $(this).val();
                if (x == 'Approved') $(this).css({backgroundColor: '#00c974'});
                if (x == 'Rejected PBN') $(this).css({backgroundColor: '#f15d34'});
                if (x == 'Working') $(this).css({backgroundColor: '#fbaa3d'});
                if (x == 'No') $(this).css({backgroundColor: 'gray'});
                var token = "{{ csrf_token() }}";
                var url = "{{route('clients.store')}}";
                var id = $(this).attr('project');
                var partner_id = $(this).attr('partner_id');
                $.ajax({
                    type: "POST",
                    url: url,
                    data: {x:x,partner_id:partner_id,project_id:id, _token:token},
                    success: function(data) {
                        console.log(data);
                    },
                });
            })
        });

        $('#buy_more').click(function() {
            $('#modal_buy_more').modal('show');
        });
//        var product_id = $(this).attr('product_id');
//        console.log(product_id);
        $("input[name='quantity']").TouchSpin({
            min: 1,
            max: 100,
            step: 1,
            decimals: 0,
            boostat: 5,
            maxboostedstep: 10
        });
        $('.quantity_hidden').each(function(){
            var x = $(this).attr('product_id');
            $('#quantity_hidden'+x).val($('#quantity'+x).val());
            $('#quantity'+x).on('change', function(e){
                var umn = $(this).val();
                var price = $('#product_price'+x).val();
                console.log(price);
                $('#total_row'+x).text(umn*price);
                $('#quantity_hidden'+x).val(umn);
            })
        })
//        $('#quantity_hidden').val($("input[name='quantity']").val());
//        $("input[name='quantity']").on('change', function(e){
//            var umn = $(this).val();
//            var price = $('#product_price').val();
//            console.log(price);
//            $('#total_row').text(umn*price);
//            $('#quantity_hidden').val(umn);
//        })
        $('.expire').datepicker({
            autoclose: true,
            minViewMode: 1,
            multidate: 1,
            format: 'mm/yyyy'
        }).on('changeDate', function(selected){
            startDate = new Date(selected.date.valueOf());
            startDate.setDate(startDate.getDate(new Date(selected.date.valueOf())));
        });

    </script>
@endsection


