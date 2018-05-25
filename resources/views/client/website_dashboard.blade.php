@extends('layouts.dashboard_layout')
@section('name','Dashboard')
@section('content')
    <link rel="stylesheet" href="{{ asset('css/chosen.css') }}">
    <link rel="stylesheet" href="{{ asset('css/website.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/css/datepicker.min.css">
{{--{!! Form::open(['route' => 'clients.store', 'class' => 'form-horizontal', 'method'=>'POST' ]) !!}--}}
    {{ csrf_field() }}
<div class="row">
    <div class="col-lg-12  ">
        <div class="col-md-8  alignment_to_layout_fb">

            <table class="table table-bordered table_head">
                <thead>
                    <tr>
                        <th class="th_header">Web</th>
                        <th class="th_header">Bio</th>
                        <th class="th_header">Link &amp; Anchors</th>
                        <th class="th_header">Nich</th>
                    </tr>
                </thead>
                <tbody style="height: 46px">
                    <tr>

                        <td style="background-color: #ffffff;" class="first_block_inside_cell ">{{$project->url}}</th>
                        @if($project->bio)
                            @if(!$project->bio->help)
                                <td style="background-color: #00c974; color: #ffffff;" class="first_block_inside_cell">Confirmed</td>
                            @else
                                <td style="background-color: #fdab3d; color: #ffffff;" class="first_block_inside_cell ">Unconfirmed</td>
                            @endif
                        @else
                                <td style="background-color: #fdab3d; color: #ffffff;" class="first_block_inside_cell ">Unconfirmed</td>
                        @endif
                        </td>
                            @if(count($project->anchors))
                                <td style="background-color: #00c974; color: #ffffff;" class="first_block_inside_cell">Confirmed</td>
                            @else
                                <td style="background-color: #fdab3d; color: #ffffff;" class="first_block_inside_cell ">Unconfirmed</td>
                            @endif

                        <td style="background-color: #ffffff;" class="first_block_inside_cell">
                            @foreach($project->niches as $niche)
                                {{$niche->name}}<br>
                            @endforeach
                        </td>
                    </tr>
                </tbody>
            </table>

               </div>
                <h4 class="box-title col-sm-12" style="color: #f15d34"><i class="mdi mdi-arrow-down-drop-circle fa-fw" data-icon="v"> </i> Quality Control</h4>
                <div class="col-lg-5" style="text-align: center; color: #3b4685">
                        <table  class="table noborder alignment_to_layout" style="width: 40%">
                            <tr>
                                <th style="min-width: 200px; color: #333; font-weight: 100;" colspan="3">Number of Placements</th>
                            </tr>
                            <tr  class="gradeA">
                                <td Width=20%><div class="btn-lg amount_of_placements">
                                       {{$quantity}} </div></td>
                                <td><button id="buy_more">Buy More</button></td>
                            </tr>
                        </table>
                </div>
                        <div class="col-lg-12 alignment_to_layout_sb">
                        <table class="table table-hover table-bordered" id="editable-datatable">
                            <thead>
                            <tr>
                                <th class="th_head"></th>
                                {{--<th></th>--}}
                                <th class="th_head">Client FeedBack</th>
                                <th class="th_head">TF</th>
                                <th class="th_head">CF</th>
                                <th class="th_head">DA</th>
                                <th class="th_head">DR</th>
                                <th class="th_head">Traffic</th>
                                <th class="th_head">Extra Cost</th>
                            </tr>
                            </thead>
                        <tbody class="first_table_body">
                        @foreach($productions as $production)
                        @if(!$production->client_approved)
                            <tr  class="gradeA ">
                                <td class="table_other_cell">{{$production->partner->domain}}</td>
                                <td class="select_first_table_cell">
                                    <select class="form-control feedback approve" domain="{{$production->partner->domain}}" project="{{$production->project_id}}" production_id="{{$production->id}}" style="border: 0px; padding: 0px; ">
                                        <option style="border: 0px; color:#3b4685;" hidden selected value="">Choose</option>
                                        <option style="border: 0px; background-color:#00c974;" >Approved</option>
                                        <option style="border: 0px; background-color:#f15d34;">Rejected PBN</option>
                                    </select>
                                </td>
                                <td class="table_other_cell">{{$production->partner->tf}}</td>
                                <td class="table_other_cell">{{$production->partner->cf}}</td>
                                <td class="table_other_cell">{{$production->partner->da}}</td>
                                <td class="table_other_cell">{{$production->partner->dr}}</td>
                                <td class="table_other_cell">{{$production->partner->traffic}}</td>
                                @if($production->partner->cost > 30)
                                    <td >
                                        <div class=" badge">${{$production->partner->cost - 30}}</div>
                                    </td>
                                @else
                                <td class="center"></td>
                                @endif
                            </tr>

                        @endif
                        @endforeach
                            </tbody>

                        </table>
</div>
        @if(count($project->orders))
        @foreach($project->orders as $order)
        @if(!$order->products()->where('project_id',$project->id)->where('product_id', 1)->count())
        @continue
        @endif
               <div class="col-sm-12 second_block_align">
                <h4 class="box-title" style="color: #3b4685"><i class="mdi mdi-arrow-down-drop-circle fa-fw" data-icon="v"> </i> Order Detail</h4>
                </div>
            <div class="col-sm-5 order_detail_block" style="color: #3b4685">
{{--                @foreach($account->orders as $i=>$order)--}}
                <table class="table table-hover table-bordered ">
                            <thead>
                            <tr>
                                <th>Order Number</th>
                                <th>Date</th>
                                <th>Placements ordered</th>
                            </tr>
                            </thead>
                            <tbody>

                            <tr>
                                <td>{{$order->id}}</td>
                                <td>{{\Carbon\Carbon::createFromFormat('Y-m-d H:i:s',$order->created_at)->format('Y.m.d')}}</td>
                                <td>{{$order->products()->where('project_id', $project->id)->get()->sum('pivot.quantity')}}</td>
                            </tr>

                            </tbody>
                        </table>
            </div>
            <div class="third_block col-sm-12">
             <table class="table table-hover table-bordered " oid="{{ $order->id }}" id="editable-datatable">
                            <thead>
                            <tr>
                                <th></th>
                                {{--<th></th>--}}
                                <th>Client Approved</th>
                                <th>Topic Approved</th>
                                <th>Content Written</th>
                                <th>Content Edited</th>
                                <th>Content Personalized</th>
                                <th>Placement Live</th>
                            </tr>
                            </thead>

                        <tbody class="second_table_body" >
                        @foreach($order->productions()->where('project_id', $project->id)->get() as $production)
                            <tr  class="gradeA">
                                <td  style="cursor:pointer" class="update" production_id="{{$production->id}}">{{$production->partner->domain}} </td>
                                <td class="approve">{{$production->client_approved}}</td>
                                <td class="approve">{{$production->topic_approved}}</td>
                                <td class="approve">{{$production->content_written}}</td>
                                <td class="approve">{{$production->content_edited}}</td>
                                <td class="approve">{{$production->content_personalized}}</td>
                                <td class="approve">{{$production->live}}</td>
                            </tr>
                            @endforeach
                            </tbody>

                        </table></div>
                {{--@endforeach--}}
                @endforeach
            @endif
                </div>
            </div>
        </div>
    <h4 class="box-title col-sm-12" style="color: #f15d34"><i class="mdi mdi-arrow-down-drop-circle fa-fw" data-icon="v"> </i> Rejected</h4>

    <div class="col-lg-12 alignment_to_layout_sb">
        <table class="table table-hover table-bordered" id="editable-datatable2">
            <thead>
            <tr>
                <th class="th_head"></th>
                {{--<th></th>--}}
                <th class="th_head">Client FeedBack</th>
                <th class="th_head">TF</th>
                <th class="th_head">CF</th>
                <th class="th_head">DA</th>
                <th class="th_head">DR</th>
                <th class="th_head">Traffic</th>
                <th class="th_head">Extra Cost</th>
            </tr>
            </thead>
            <tbody class="first_table_body" id="reject_table">
            @foreach($productions as $production)

                @if($production->client_approved == 'Rejected PBN')
                    <tr  class="gradeA ">
                        <td class="table_other_cell">{{$production->partner->domain}}</td>
                        <td class="select_first_table_cell">
                            <select class="form-control feedback approve"  project="{{$production->project_id}}" production_id="{{$production->id}}" style="border: 0px; padding: 0px; ">
                                <option style="border: 0px;background-color:#f15d34;" >{{$production->client_approved}}</option>
                                <option style="border: 0px; background-color:#00c974;" >Approved</option>
                            </select>
                        </td>
                        <td class="table_other_cell">{{$production->partner->tf}}</td>
                        <td class="table_other_cell">{{$production->partner->cf}}</td>
                        <td class="table_other_cell">{{$production->partner->da}}</td>
                        <td class="table_other_cell">{{$production->partner->dr}}</td>
                        <td class="table_other_cell">{{$production->partner->traffic}}</td>
                        @if($production->partner->cost > 30)
                            <td >
                                <div class=" badge">${{$production->partner->cost - 30}}</div>
                            </td>
                        @else
                            <td class="center"></td>
                        @endif
                    </tr>

                @endif
            @endforeach
            </tbody>

        </table>
    </div>
    {{--{!! Form::close() !!}--}}

    {{--MODAL --}}

    <div class="modal fade" id="modal_buy_more" role="dialog">
        <div class="modal-dialog modal-sm vertical-align-center">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                {!! Form::open(['route' => 'placements.add_more', 'class' => 'form-horizontal', 'method'=>'POST' ]) !!}
                <div class="col-sm-12 modal_view buy_more_modal">
                <div class="modal-body">
                  <div class="wrapper_modal_table">


                        <table class="table table-bordered table_modal">
                            <thead >
                            <tr>
                                <th >Product</th>
                                <th >QTY</th>
                                <th >Total</th>
                            </tr>
                            </thead>
                            <tbody >
                            @foreach($products as $product)
                                <tr>
                                <td >
                                    <div class="bull">
                                        <img src="{{asset('img/orderFormLayout/bull.png')}}" alt="">
                                    </div>
                                    <span class="product">{{$product->title}}</span>
                                    <input id="prod_name" type="hidden" name="product_id[]" value="{{$product->id}}">
                                    <input id="project_id" type="hidden" name="project_id" value="{{$project->id}}">
                                </td>
                                <td>
                                        <input id="quantity{{$product->id}}" type="text" product_id="{{$product->id}}" class="col-md-3" value="1" name="quantity" required>
                                        <input id="quantity_hidden{{$product->id}}" product_id="{{$product->id}}" type="hidden" class="quantity_hidden" value="1" name="quantity_product[]" required>
                                </td>
                                <td >
                                    <span class="product">USD $</span> <span id="total_row{{$product->id}}" class="product">{{$product->price}}</span>
                                    <input id="product_price{{$product->id}}" type="hidden" name="product_price[]" value="{{$product->price}}">
                                </td>
                            </tr>
                            @endforeach
                            </tbody>
                        </table>
                      </div>
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
                            <input id="card_num" required
                                   data-stripe="number" pattern="[0-9]{16}"
                                   maxlength="16"
                                   type="text"
                                   class="form-control margin_10 col-md-4 col-lg-4"
                                   name="card_number"
                                   value=""
                                   placeholder="Card Number"
                                   >
                                   </div>
                            @if ($errors->has('card_number'))
                                <span class="help-block alert-danger">
                                                <strong>{{ $errors->first('card_number') }}</strong>
                                            </span>
                            @endif
<div class="col-md-4 col-lg-4 null_my">
                            <input id="cvc" type="text" required pattern="[0-9]{3}"
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
                                <input id="expiry" required
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
    {{--update placement modal--}}
    <div class="modal mm" id="modal_update" role="dialog">
        <div class="modal-dialog modal-dialog-update modal-lg  vertical-align-center  placement-update">
            <div class="modal-content" id="updates">


            </div>
        </div>
    </div>

    {{--update placement modal end--}}
@endsection
@section('script')
    <script src="{{asset('js/jquery-datatables-editable/jquery.dataTables.js')}}"></script>
    <script src={{ asset('js/moment.min.js') }}></script>
    <script src="{{ asset('js/chosen.jquery.js') }}"></script>
    <script src="{{ asset('js/chosen.proto.js') }}"></script>
    <script src="{{ asset('js/chosen.jquery.min.js') }}"></script>
    <script src="{{ asset('js/chosen.proto.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/js/bootstrap-datepicker.min.js"></script>

    <script>
        $('#product').chosen({
            no_results_text: "Oops, nothing found product!",
            width: '100%'
        });
        $('#product').trigger('chosen:updated');

        $('#editable-datatable').DataTable({
            "bInfo": false,
            "bPaginate": false,
            "searching": false,
            "lengthChange": false,
            "ordering": false,
            "scrollX": true,
        });
        $('#editable-datatable2').DataTable({
            "bInfo": false,
            "bPaginate": false,
            "searching": false,
            "lengthChange": false,
            "ordering": false,
            "scrollX": true,
        });

        $('.update').click(function() {
            var production_id = $(this).attr('production_id');
            var token = "{{ csrf_token() }}";
            var url = "{{route('load_updates_client')}}";
            console.log(url);
            $.ajax({
                type: "POST",
                url: url,
                data: {
                    production_id: production_id,
                    _token: token
                },
                success: function(data) {
                    /*$('#updates').html(data);
                    $('#modal_update').modal('show');
                    // add comment
                    $('.add_comment').click(function (e) {
                        console.log(e.currentTarget);

                        $(e.currentTarget.nextElementSibling).show();
                    })*/
                    $('body').append(data);


                    $('#product').chosen({
                        no_results_text: "Oops, nothing found product!",
                        width: '100%'
                    });
                },
                error: function (err) {

                }
            });
        });

        $(document).ready(function() {

        $('td.approve').each(function(){
            var x = $(this).text();
                if (x == 'Approved') $(this).css({backgroundColor: '#00c974'});
                if (x == 'Rejected PBN') $(this).css({backgroundColor: '#f15d34'});
                if (x == 'No') $(this).css({backgroundColor: 'gray'});
                if (x == 'Done') $(this).css({backgroundColor: 'cyan'});
                if (x == 'Live') $(this).css({backgroundColor: 'gray'});
                if (x == 'Finished') $(this).css({backgroundColor: '#00c974'});
        });
        $('.feedback').each(function(){
            var x = $(this).val();
            if (x == 'Approved') $(this).css({backgroundColor: '#00c974'});
            if (x == 'Rejected PBN') $(this).css({backgroundColor: '#f15d34'});
            if (x == 'Working') $(this).css({backgroundColor: '#fbaa3d'});
            if (x == 'No') $(this).css({backgroundColor: 'gray'});

        });
            $('.feedback').change(function (e) {
                var x = $(this).val();

                if (x == 'Rejected PBN') {
                    $(this).css({backgroundColor: '#f15d34'});
                    $(this).parents("tr").hide();
                    $('.dataTables_empty').hide();
                    $("#reject_table").append($(this).parents("tr").show());
                }
                if (x == 'Working') $(this).css({backgroundColor: '#fbaa3d'});
                if (x == 'No') $(this).css({backgroundColor: 'gray'});
                var token = "{{ csrf_token() }}";
                var url = "{{route('clients.store')}}";
                var id = $(this).attr('project');
                var production_id = $(this).attr('production_id');
                var domain = $(this).attr('domain');
                var select_jq = $(this);
                $.ajax({
                    type: "POST",
                    url: url,
                    data: {x:x,production_id:production_id,project_id:id, _token:token},
                    success: function(data) {
                        if(data > 0){
                            $('table[oid=' + data + '] tbody').append('<tr  class="gradeA">'+
                                '<td  style="cursor:pointer" class="update" production_id="' + production_id + '">' + domain + ' </td>' +
                                '<td class="approve" style="background-color: #00c974;">Approved</td>' +
                                '<td class="approve"></td>' +
                                '<td class="approve"></td>' +
                                '<td class="approve"></td>' +
                                '<td class="approve"></td>' +
                                '<td class="approve"></td>' +
                            '</tr>');
                            select_jq.parents("tr").hide();
                        }else{
                            console.log(select_jq.children());
                            jQuery.each(select_jq.children(), function () {
                                if(!$(this).val()){
                                    this.selected = true;
                                }
                            });
                        }
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
