@extends('layouts.dashboard_layout')
@section('name','Go Live Manager')
@section('content')
    <link rel="stylesheet" href="{{ asset('css/production.css') }}">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.5.1/css/buttons.dataTables.min.css">
    <div class="row">
        {!! Form::open(['route' => 'search_live', 'class' => 'form-horizontal', 'method'=>'POST' ]) !!}
        {{ csrf_field() }}

        <div class="col-md-12 search_bio">
            <div class="form-row search_partner">
                <div class="textsearch_user">Search Here</div>
                <div class="form-group input_search_cont">
                    <div class="input-group-lg search_input_group">
                        <input class="form-control search_input" id="search_partner" type="search" name="search_partner" placeholder="Enter Keyword">
                        <span class="input-group-btn">
                <button class="btn btn-default search_button" type="submit"><span class="glyphicon glyphicon-search"></span></button>
                    </span>
                    </div>
                </div>
            </div>
        </div>

        {!! Form::close() !!}
        <div class="col-lg-12 marked">
            {{--<h4 class="box-title" style="color: #3b4685">{{$partner->domain}}</h4>--}}
            {{--<input type="text" name="keyword" class="form-control input-sm" placeholder="Search here"><br>--}}
            @foreach($partners as $partner)
                <table class="table table-responsive table-hover table-bordered context" id="topic{{$partner->id}}">
                    <thead style="background-color: #f15e33; color: white">
                    <tr>
                        <th>Client</th>
                        <th>Priority</th>
                        <th>Content</th>
                        <th>Content Status</th>
                        <th>Date Sent</th>
                        <th>Live links</th>
                        <th>Payment</th>
                    </tr>
                    </thead>
                    <tbody style="background-color: white" >
                    @foreach($productions as $production)
                        @if($production->partner_id == $partner->id)
                            <tr  class="gradeA">
                                <td>{{$production->project->url}}</td>
                                {{--@if(Auth::user()->id == $project->user_id || Auth::user()->hasAnyRole('super_admin|admin'))--}}
                                <td >
                                    <select class="form-control feedback" production_id="{{$production->id}}" name="priority" style="border: 0px; padding: 0px; ">
                                        <option style="border: 0px;" >{{$production->priority}}</option>
                                        @if($production->priority == 'High')
                                            {{--<option style="border: 0px;" >High</option>--}}
                                            <option style="border: 0px;">Medium</option>
                                            <option style="border: 0px;">Low</option>
                                        @endif
                                        @if($production->priority == 'Medium')
                                            <option style="border: 0px;" >High</option>
                                            {{--<option style="border: 0px;">Medium</option>--}}
                                            <option style="border: 0px;">Low</option>
                                        @endif
                                        @if($production->priority == 'Low')
                                            <option style="border: 0px;" >High</option>
                                            <option style="border: 0px;">Medium</option>
                                            {{--<option style="border: 0px;">Low</option>--}}
                                        @endif
                                    </select>
                                </td>

                                <td>
                                    @if($production->content)
                                        {{--<i class="mdi mdi-folder"></i>--}}
                                        <a class="btn btn-primary " href="storage/content/{{$production->content}}"
                                        >Download <i class="mdi mdi-download" ></i></a>
                                    @else
                                        No File
                                    @endif
                                </td>
                                <td><select class="form-control feedback" production_id="{{$production->id}}"
                                 style="border: 0px; padding: 0px; " name="content_status">
                                        <option default>{{$production->content_status}}</option>
                                        <option style="border: 0px;" >Approved</option>
                                        <option style="border: 0px;">Sent</option>
                                        <option style="border: 0px;">Live</option>
                                    </select></td>
                                <td>{{\Carbon\Carbon::createFromFormat('Y-m-d H:i:s',$production->project->created_at)->format('Y-m-d')}}</td>

                                <td><input class="form-control feedback" name="live_link" style="border: 0px; padding: 0px; "
                                value="{{$production->live_link}}" production_id="{{$production->id}}"/></td>
                                <td>
                                    <select class="form-control feedback" production_id="{{$production->id}}"
                                     style="border: 0px; padding: 0px; " name="payment">
                                        <option default>{{$production->payment}}</option>
                                        <option style="border: 0px;" >Paid</option>
                                        <!-- <option style="border: 0px;">Awaiting</option> -->
                                    </select>
                                </td>
                            </tr>
                        @endif
                    @endforeach
                    @endforeach
                    </tbody>

                </table>
        </div>
    </div>


@endsection
@section('script')
    <script src="{{asset('js/jquery-datatables-editable/jquery.dataTables.js')}}"></script>
    {{--<script src="{{asset('js/jquery.table2excel.js')}}"></script>--}}
    <script src="https://cdn.datatables.net/buttons/1.5.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.flash.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.html5.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/pdfmake.min.js"></script>
    <script src="https://cdn.jsdelivr.net/mark.js/8.6.0/jquery.mark.min.js"></script>

    <script>
        $(document).ready(function() {
            @foreach($partners as $partner)
          $('#topic{{$partner->id}}').DataTable({
                "columns": [
                    { "width": "20%" },
                    { "width": "10%" },
                    { "width": "10%" },
                    { "width": "10%" },
                    { "width": "10%" },
                    { "width": "30%" },
                    { "width": "10%" },
                ],
                "bInfo": false,
                "bPaginate": false,
                "searching": false,
                "lengthChange": false,
                // "scrollX": true,
                dom: 'f<"toolbar{{$partner->id}}">t',
                buttons: [
                    {
                        extend: 'csv',
                        "bSelectedOnly": true,
                        filename: function(){
                            var n = '{{\Carbon\Carbon::now()->format('Y-m-d')}}';
                            return 'NO-BS_' + n;
                        },
                        text: 'Download <i class="mdi mdi-download"></i>'
                    },
                ],

            });

            $("div.toolbar{{$partner->id}}").html(
            '<table><tr>' +
            '<th><b>{{$partner->domain}}</b></th><th><img src="{{asset('img/paypal_logo.png')}}" alt="" style="width: 40px; margin: 0 10px"></th>' +
            '<th style="color:gray; padding: 0 10px"> {{$partner->paypal_id}} </th>' +
            '<th style="color:gray; padding: 0 10px"> Cost Per Placement </th>' +
            '<th style="background-color:white; color:red; padding: 0 10px">$ {{$partner->cost}} </th>' +
            '</tr></table>'
            );
            @endforeach

           $('.feedback').each(function(){
                var x = $(this).text();
                if (x == 'Approved') $(this).css('border-bottom', 'solid 5px green');
                if (x == 'Rejected') $(this).css('border-bottom', 'solid 5px red');
                if (x == 'Sent') $(this).css('border-bottom', 'solid 5px orange');
                if (x == 'High') $(this).css('border-bottom', 'solid 5px red');
                if (x == 'Low') $(this).css('border-bottom', 'solid 5px green');
                if (x == 'Medium') $(this).css('border-bottom', 'solid 5px orange');
            });
            $('.feedback').each(function(){
                var x = $(this).val();
                if (x == 'Approved') $(this).css('border-bottom', 'solid 5px green');
                if (x == 'Rejected') $(this).css('border-bottom', 'solid 5px red');
                if (x == 'Sent') $(this).css('border-bottom', 'solid 5px orange');
                if (x == 'High') $(this).css('border-bottom', 'solid 5px red');
                if (x == 'Low') $(this).css('border-bottom', 'solid 5px green');
                if (x == 'Medium') $(this).css('border-bottom', 'solid 5px orange');

            });
            $('.feedback').change(function () {
                var x = $(this).val();
                var name = $(this).attr('name');
                if (x == 'Approved') $(this).css('border-bottom', 'solid 5px green');
                if (x == 'Rejected') $(this).css('border-bottom', 'solid 5px red');
                if (x == 'Sent') $(this).css('border-bottom', 'solid 5px orange');
                if (x == 'High') $(this).css('border-bottom', 'solid 5px red');
                if (x == 'Low') $(this).css('border-bottom', 'solid 5px green');
                if (x == 'Medium') $(this).css('border-bottom', 'solid 5px orange');
                if (x == 'Paid') {
                    $(this).parents("tr").hide();
                }
                var token = "{{ csrf_token() }}";
                var url = "{{route('production.topic_ajax')}}";
                var production_id = $(this).attr('production_id');
                $.ajax({
                    type: "POST",
                    url: url,
                    data: {x:x,name:name,production_id:production_id, _token:token},
                    success: function(data) {
                        console.log(data);
                    },
                });
            });


        });  //end document ready

    </script>
@endsection