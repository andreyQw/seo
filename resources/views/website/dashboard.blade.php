@extends('layouts.dashboard_layout') @section('name','Dashboard') @section('content')
    <link rel="stylesheet" href="{{ asset('css/chosen.css') }}">
    <link rel="stylesheet" href="{{ asset('css/website.css') }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/css/datepicker.min.css"> {{--{!! Form::open(['route' => 'clients.store', 'class' => 'form-horizontal', 'method'=>'POST' ]) !!}--}} {{ csrf_field() }}
<div class="row">
    <div class="col-lg-12  ">
        <div class="col-md-8  alignment_to_layout_fb">

            <table class="table table-responsive table-bordered table_head">
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
                            @foreach($project->niches as $niche) {{$niche->name}}
                            <br> @endforeach
                        </td>
                    </tr>
                </tbody>
            </table>

        </div>
        <h4 class="box-title col-sm-12" style="color: #f15d34"><i class="mdi mdi-arrow-down-drop-circle fa-fw" data-icon="v"> </i> Quality Control</h4>

        <div class="col-lg-12 alignment_to_layout_sb">
            <table class="table table-responsive table-hover table-bordered" id="editable-datatable">
                <thead>
                    <tr>
                        <th class="th_head"></th>
                        {{--
                        <th></th>--}}
                        <th class="th_head">Client Feedback</th>
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
                    <tr class="gradeA ">
                        <td class="table_other_cell">{{$production->partner->domain}}</td>
                        <td class="select_first_table_cell">
                        <select class="form-control feedback approve" domain="{{$production->partner->domain}}" project="{{$production->project_id}}" production_id="{{$production->id}}" style="border: 0px; padding: 0px; ">
                            <option style="border: 0px; color:#3b4685;" hidden selected value="">Choose</option>
                            <option style="border: 0px; background-color:#00c974; color:white" >Approved</option>
                            <option style="border: 0px; background-color:#f15d34 color:white;">Rejected PBN</option>
                        </select>

                        </td>
                        <td class="table_other_cell">{{$production->partner->tf}}</td>
                        <td class="table_other_cell">{{$production->partner->cf}}</td>
                        <td class="table_other_cell">{{$production->partner->da}}</td>
                        <td class="table_other_cell">{{$production->partner->dr}}</td>
                        <td class="table_other_cell">{{$production->partner->traffic}}</td>
                        @if($production->partner->cost > 30)
                        <td>
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
            <div class="col-lg-5 nopadding" style="text-align: left; color: #3b4685;">
                <button id="add_partners">Add Partners</button>
            </div>

        @foreach($project->orders as $order)
        @if(!$order->products()->where('project_id',$project->id)->where('product_id', 1)->count())
        @continue
        @endif
        <div class="col-sm-12 second_block_align">
            <h4 class="box-title" style="color: #3b4685"><i class="mdi mdi-arrow-down-drop-circle fa-fw" data-icon="v"> </i> Order Detail</h4>
        </div>
        <div class="col-sm-5 order_detail_block" style="color: #3b4685">
            <table class="table-responsive table table-hover table-bordered ">
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
                        <td>{{\Carbon\Carbon::createFromFormat('Y-m-d H:i:s',$order->created_at)->format('Y/m/d')}}</td>
                        <td>{{$order->products()->where('project_id', $project->id)->get()->sum('pivot.quantity')}}</td>
                    </tr>

                </tbody>
            </table>
        </div>
        <div class="third_block col-sm-12">
            <table class="table table-responsive table-hover table-bordered " id="editable-datatable" oid="{{ $order->id }}">
                <thead>
                    <tr>
                        <th></th>
                        <th>Client Approved</th>
                        <th>Topic Approved</th>
                        <th>Content Written</th>
                        <th>Content Edited</th>
                        <th>Content Personalized</th>
                        <th>Placement Live</th>
                    </tr>
                </thead>

                <tbody class="second_table_body">
                    @foreach($order->productions()->where('project_id', $project->id)->get() as $production)
                    <tr class="gradeA">
                        <td class="update" production_id="{{$production->id}}" order_id="{{$order->id}}"
                            project_id="{{$project->id}}" partner_url="{{$production->partner->domain}}"
                            style="cursor:pointer">{{$production->partner->domain}}
                            {{--<span>3</span>--}}
                        </td>
                        <td class="approve">{{$production->client_approved}}</td>
                        <td class="approve">{{$production->topic_approved}}</td>
                        <td class="approve">{{$production->content_written}}</td>
                        <td class="approve">{{$production->content_edited}}</td>
                        <td class="approve">{{$production->content_personalized}}</td>
                        <td class="approve">{{$production->live}}</td>
                    </tr>
                    @endforeach
                </tbody>

            </table>
        </div>
        {{--@endforeach--}} @endforeach {{--{!! Form::close() !!}--}}
        <h4 class="box-title col-sm-12" style="color: #f15d34"><i class="mdi mdi-arrow-down-drop-circle fa-fw" data-icon="v"> </i> Rejected</h4>

        <div class="col-lg-12 alignment_to_layout_sb">
            <table class="table table-responsive table-hover table-bordered" id="editable-datatable2">
                <thead>
                <tr>
                    <th class="th_head"></th>
                    {{--<th></th>--}}
                    <th class="th_head">Client Feedback</th>
                    <th class="th_head">TF</th>
                    <th class="th_head">CF</th>
                    <th class="th_head">DA</th>
                    <th class="th_head">DR</th>
                    <th class="th_head">Traffic</th>
                    <th class="th_head">Extra Cost</th>
                </tr>
                </thead>
                <tbody class="first_table_body"  id="reject_table">
                @foreach($productions as $production)

                    @if($production->client_approved == 'Rejected PBN')
                        <tr  class="gradeA ">
                            <td class="table_other_cell">{{$production->partner->domain}}</td>
                            <td class="select_first_table_cell">
                                <select class="form-control feedback approve"  domain="{{$production->partner->domain}}" project="{{$production->project_id}}" production_id="{{$production->id}}" style="border: 0px; padding: 0px; ">
                                    <option style="border: 0px;" >{{$production->client_approved}}</option>
                                    @if($production->client_approved == 'Approved')
                                        {{--<option style="border: 0px;" >Approved</option>--}}
                                        <option style="border: 0px;">Rejected PBN</option>
                                        <!-- <option style="border: 0px;">Working</option> -->
                                    @endif
                                    @if($production->client_approved == 'Rejected PBN')
                                        <option style="border: 0px;" >Approved</option>
                                        {{--<option style="border: 0px;">Rejected PBN</option>--}}
                                        <!-- <option style="border: 0px;">Working</option> -->
                                    @endif
                                    @if($production->client_approved == 'Working')
                                        <option style="border: 0px;" >Approved</option>
                                        <option style="border: 0px;">Rejected PBN</option>
                                        {{--<option style="border: 0px;">Working</option>--}}
                                    @endif
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

        <div class="modal fade" id="modal_add_partners" role="dialog">
            <div class="modal-dialog modal-dialog-staff modal-lg vertical-align-center ">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    {!! Form::open(['route' => 'websites.add_partner', 'class' => 'form-horizontal', 'method'=>'POST' ]) !!}
                    <div class="col-md-12 modal_view">
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-12  ">
                                    {{--
                                    <div class="row">--}}

                                        <div class="col-md-6 ">
                                            <h4 class="" style="color: #f15d34"> Pick a Partner</h4><br>
            <!-- Search -->            
            <div class="col-lg-2 search_input" style="padding-right: 0px; padding-left: 0px">
                <select type="text" name="key_priority" class="form-control " placeholder="Priority">
                    <option value="" disabled selected>Priority</option>
                    <option style="border: 0px;" >High</option>
                    <option style="border: 0px;">Medium</option>
                    <option style="border: 0px;">Low</option>
                </select>
            </div>
            <div class="col-lg-2 search_input" style="padding-right: 0px; padding-left: 0px">
                <select type="text" name="key_priority" class="form-control " placeholder="Priority">
                    <option value="" disabled selected>Priority</option>
                    <option style="border: 0px;" >High</option>
                    <option style="border: 0px;">Medium</option>
                    <option style="border: 0px;">Low</option>
                </select>
            </div>
            <div class="col-lg-1 search_input"
                 style="padding-left: 0px;padding-right: 5px; color: white; background-color:#3b4685 ">
                <button type="submit" class="btn btn-block search_btn" style="color: white; background-color:#3b4685 ">
                Search <i class="mdi mdi-magnify"></i></button>
            </div>
             <!-- End search -->                                
                                            <table class="table table-responsive table-hover table-bordered" id="pick">
                                                <thead id="th_head_pick">
                                                    <tr>
                                                        <th class="th_head">Domain</th>
                                                        <th class="th_head">Nich</th>
                                                        <th class="th_head">Cost</th>
                                                        <th class="th_head">#</th>
                                                        <th class="th_head">TF</th>
                                                        <th class="th_head">CF</th>
                                                        <th class="th_head">DA</th>
                                                        <th class="th_head">DR</th>
                                                        <th class="th_head">Traffic</th>
                                                        <th class="th_head">Cost</th>
                                                        <th class="th_head">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody class="first_table_body">
                                                    @foreach($partners as $partner) {{--@if($production->client_approved != 'Approved')--}}
                                                    <tr class="gradeA ">
                                                        <td class="table_other_cell">{{$partner->domain}}</td>
                                                        <td class="table_other_cell"></td>
                                                        <td class="table_other_cell"></td>
                                                        <td class="table_other_cell"></td>
                                                        <td class="table_other_cell">{{$partner->tf}}</td>
                                                        <td class="table_other_cell">{{$partner->cf}}</td>
                                                        <td class="table_other_cell">{{$partner->da}}</td>
                                                        <td class="table_other_cell">{{$partner->dr}}</td>
                                                        <td class="table_other_cell">{{$partner->traffic}}</td>
                                                        @if($partner->cost > 30)
                                                        <td>
                                                            <div class=" badge">${{$partner->cost - 30}}</div>
                                                        </td>
                                                        @else
                                                        <td class="center"></td>
                                                        @endif
                                                        <td class="table_other_cell">
                                                            <input type="checkbox" name="new_partner_id[]" value="{{$partner->id}}"> Add</td>

                                                    </tr>

                                                    {{--@endif--}} @endforeach
                                                </tbody>

                                            </table>

                                        </div>


                                        <div class="col-md-6 ">
                                            <h4 class="" style="color: #f15d34"> Partner Added</h4><br>

        <table class="table table-responsive table-hover table-bordered" id="added">
            <thead id="th_head_added">
                <tr>
                    <th class="th_head">Domain</th>
                    <th class="th_head">Nich</th>
                    <th class="th_head">Cost</th>
                    <th class="th_head">#</th>
                    <th class="th_head">TF</th>
                    <th class="th_head">CF</th>
                    <th class="th_head">DA</th>
                    <th class="th_head">DR</th>
                    <th class="th_head">Traffic</th>
                    <th class="th_head">Cost</th>
                    <th class="th_head">Action</th>
                </tr>
            </thead>
            <tbody class="first_table_body">
                @foreach($productions as $production) 
                @if($production->client_approved != 'Approved')
                <tr class="gradeA" id="current_partner{{$production->partner->id}}">
                    <td class="table_other_cell">{{$production->partner->domain}}</td>
                    <td class="table_other_cell"></td>
                    <td class="table_other_cell"></td>
                    <td class="table_other_cell"></td>
                    <td class="table_other_cell">{{$production->partner->tf}}</td>
                    <td class="table_other_cell">{{$production->partner->cf}}</td>
                    <td class="table_other_cell">{{$production->partner->da}}</td>
                    <td class="table_other_cell">{{$production->partner->dr}}</td>
                    <td class="table_other_cell">{{$production->partner->traffic}}</td>
                    @if($production->partner->cost > 30)
                    <td>
                        <div class=" badge">${{$production->partner->cost - 30}}</div>
                    </td>
                    @else
                    <td class="center"></td>
                    @endif
                    <td class="table_other_cell"><button type="button" project_id="{{$production->project->id}}" partner_id="{{$production->partner->id}}" class="close del_partner">&times; Del</button>
                    </td>

                </tr>

                @endif 
                @endforeach
            </tbody>

        </table>

                                        </div>


                                        <input type="hidden" name="project_id" value="{{$project->id}}"> {{--
                                    </div>--}}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class="row">
                            <div class="col-md-offset-6 col-md-2 block_btn_modal">
                                <button type="submit" class="btn btn-default btn-lg modal_btn">Save</button>
                            </div>
                            <div class=" col-md-2 block_btn_modal">
                                <button type="button" data-dismiss="modal" class="btn btn-default btn-lg modal_btn modal_btn_cancel">Cancel</button>
                            </div>
                            <div class=" col-md-2 block_btn_modal">
                                <button class="btn  btn-lg modal_btn modal_btn_cancel">Draft</button>
                            </div>
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
        <script src={{ asset( 'js/moment.min.js') }}></script>
        <script src="{{ asset('js/chosen.jquery.js') }}"></script>
        <script src="{{ asset('js/chosen.proto.js') }}"></script>
        <script src="{{ asset('js/chosen.jquery.min.js') }}"></script>
        <script src="{{ asset('js/chosen.proto.min.js') }}"></script>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/js/bootstrap-datepicker.min.js"></script>
        <script src="https://cloud.tinymce.com/stable/tinymce.min.js"></script>
        {{--<script src="{{asset('js/updates/client.js')}}"></script>--}}
        <script>
            $('#editable-datatable').DataTable({
                "bInfo": false,
                "bPaginate": false,
                "searching": false,
                "lengthChange": false,
                "ordering": false
            });
            $('#editable-datatable2').DataTable({
                "bInfo": false,
                "bPaginate": false,
                "searching": false,
                "lengthChange": false,
                "ordering": false
            });
            $(document).ready(function() {
                $('#pick').DataTable({
                    "columns": [
                        //                    { "width": "35%" },
                        null,
                        null,
                        null,
                        null,
                        null,
                        null,
                        null,
                        null,
                        null,
                        null,
                        null,
                    ],
                    //                "bInfo": false,
                    "bPaginate": false,
                    "searching": false,
                    "lengthChange": false,
                    "scrollX": true,
                    "ordering": false,
                    dom: 'fB<"toolbar_pick">t',
                    // initComplete: function () {

                    //     this.api().columns().every( function () {
                    //         var column = this;
                    //         var select = $('<select><option value=""></option></select>')
                    //             .appendTo( $(column.header()) )
                    //             .on( 'change', function () {
                    //                 var val = $.fn.dataTable.util.escapeRegex(
                    //                     $(this).val()
                    //                 );

                    //                 column
                    //                     .search( val ? '^'+val+'$' : '', true, false )
                    //                     .draw();
                    //             } );

                    //         column.data().unique().sort().each( function ( d, j ) {
                    //             select.append( '<option value="'+d+'">'+d+'</option>' )
                    //         } );
                    //     } );
                    // }
                });
                //            $("div.toolbar_pick").html('<b>Pick a Partner</b>');

                $('#added').DataTable({
                    "columns": [
                        //                    { "width": "35%" },
                        null,
                        null,
                        null,
                        null,
                        null,
                        null,
                        null,
                        null,
                        null,
                        null,
                        null,
                    ],
                    //                "bInfo": false,
                    "bPaginate": false,
                    "searching": false,
                    "lengthChange": false,
                    "scrollX": true,
                    "ordering": false,
                    dom: 'fB<"toolbar_added">t',
                });
                //            $("div.toolbar_added").html('<b>Partner Added</b>');
                $("div.toolbar_added").html('<h6>'+{{$order->products()->where('project_id', $project->id)->get()->sum('pivot.quantity')}}+' Placement Needed</h6>');

                $('td.approve').each(function() {
                    var x = $(this).text();
                    if (x == 'Approved') $(this).css({
                        backgroundColor: '#00c974'
                    });
                    if (x == 'Finished') $(this).css({
                        backgroundColor: '#00c974'
                    });
                    if (x == 'Rejected PBN') $(this).css({
                        backgroundColor: '#f15d34'
                    });
                    if (x == 'Working') $(this).css({
                        backgroundColor: '#fbaa3d'
                    });
                    if (x == 'No') $(this).css({
                        backgroundColor: 'gray'
                    });
                    if (x == 'Not Working') $(this).css({
                        backgroundColor: '#f15d34'
                    });
                    if (x == 'Done') $(this).css({
                        backgroundColor: 'cyan'
                    });
                    if (x == 'Live') $(this).css({
                        backgroundColor: 'gray'
                    });
                });
                $('.feedback').each(function() {
                    var x = $(this).val();
                    if (x == 'Approved') $(this).css({
                        backgroundColor: '#00c974'
                    });
                    if (x == 'Rejected PBN') $(this).css({
                        backgroundColor: '#f15d34'
                    });
                    if (x == 'Working') $(this).css({
                        backgroundColor: '#fbaa3d'
                    });
                    if (x == 'No') $(this).css({
                        backgroundColor: 'gray'
                    });

                });
                $('.feedback').change(function() {
                    var x = $(this).val();
                    if (x == 'Rejected PBN') {
                        $(this).css({backgroundColor: '#f15d34'});
                        $(this).parents("tr").hide();
                        $('.dataTables_empty').hide();
                        $("#reject_table").append($(this).parents("tr").show());
                    }
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

            $('#add_partners').click(function() {
                $('#modal_add_partners').modal('show');
            });

            $('.update').click(function() {
                var production_id = $(this).attr('production_id');
                var token = "{{ csrf_token() }}";
                var url = "{{route('load_updates_nobs')}}";
                console.log(url);
                $.ajax({
                    type: "POST",
                    url: url,
                    data: {
                        production_id: production_id,
                        _token: token
                    },
                    success: function(data) {
                        $('body').append(data);
                        $('#product').chosen({
                            no_results_text: "Oops, nobody found!",
                            width: '100%'
                        });
                        $('#product2').chosen({
                            no_results_text: "Oops, nobody found!",
                            width: '100%'
                        });
                    },
                    error: function (err) {
                        console.log(err);
                    }
                });
            });

            //del
            $('.del_partner').click(function() {
                var project_id = $(this).attr('project_id');
                var partner_id = $(this).attr('partner_id');
                $('#current_partner' + partner_id).css({
                    display: 'none'
                });
                var token = "{{ csrf_token() }}";
                var url = "{{route('websites.del_partner')}}";
                $.ajax({
                    type: "POST",
                    url: url,
                    data: {
                        partner_id: partner_id,
                        project_id: project_id,
                        _token: token
                    },
                    success: function(data) {
                        console.log(data);
                    },
                });
            });

            $("input[name='quantity']").TouchSpin({
                min: 1,
                max: 100,
                step: 1,
                decimals: 0,
                boostat: 5,
                maxboostedstep: 10
            });
            $('#quantity_hidden').val($("input[name='quantity']").val());
            $("input[name='quantity']").on('change', function(e) {
                var umn = $(this).val();
                var price = $('#product_price').val();
                console.log(price);
                $('#total_row').text(umn * price);
                $('#quantity_hidden').val(umn);
            })

            $('.expire').datepicker({
                autoclose: true,
                minViewMode: 1,
                multidate: 1,
                format: 'mm/yyyy'
            }).on('changeDate', function(selected) {
                startDate = new Date(selected.date.valueOf());
                startDate.setDate(startDate.getDate(new Date(selected.date.valueOf())));
            });

            $('document').ready(function () {
                console.log(window.outerHeight);
                var he = window.outerHeight / 100 * 70;
                $('.wrapper-for-massage-mm').css('height', Math.floor(he) + 'vh');
                console.log($('.wrapper-for-massage-mm'));
            });

        </script>
        @endsection
