@extends('layouts.dashboard_layout')
@section('name','Topic Manager')
@section('content')
    <link rel="stylesheet" href="{{ asset('css/production.css') }}">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.5.1/css/buttons.dataTables.min.css">
    <div class="row">
        {!! Form::open(['route' => 'search_partner', 'class' => 'form-horizontal', 'method'=>'POST' ]) !!}
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
            @if($partner)
            <table class="table table-hover table-bordered table-responsive context" id="topic{{$partner->id}}">
                <thead style="background-color: #f15e33; color: white">
                <tr>
                    <th>Client</th>
                    <th class="noExl">Priority</th>
                    <th>Topic</th>
                    <th>Date Sent</th>
                    <th>RSOS</th>
                    <th>RSOS Keywords</th>
                    <th>Topic Status</th>
                </tr>
                </thead>
                <tbody style="background-color: white" >
                @foreach($productions->where('topic_approved', '<>', 'Approved') as $production)
                    @if($production->partner_id == $partner->id)
                    <tr  class="gradeA">
                        <td>{{$production->project->url}}</td>
                        {{--@if(Auth::user()->id == $project->user_id || Auth::user()->hasAnyRole('super_admin|admin'))--}}
                            <td >
                            <select class="form-control feedback" production_id="{{$production->id}}" name="priority" style="border: 0px; padding: 0px; "
                            ><option style="border: 0px;" >{{$production->priority}}</option>
                                @if($production->priority == 'High')                               
                                <option style="border: 0px;">Medium</option>
                                <option style="border: 0px;">Low</option>
                                @endif
                                @if($production->priority == 'Medium')
                                <option style="border: 0px;" >High</option>                                
                                <option style="border: 0px;">Low</option>
                                @endif
                                @if($production->priority == 'Low')
                                <option style="border: 0px;" >High</option>
                                <option style="border: 0px;">Medium</option>                                
                                @endif
                            </select>
                            </td>
                        <td>
                            <textarea class="content-cell feedback topic_text" production_id="{{$production->id}}"                                      
                                      name="topic">{{$production->topic}}</textarea>
                        </td>
                        <td>{{\Carbon\Carbon::createFromFormat('Y-m-d H:i:s',$production->project->created_at)->format('Y-m-d')}}</td>
                         {{--@if($production->rsos)--}}
                                <td>
                                    <select class="form-control rsos feedback" style="border: 0px; padding: 0px; " name="rsos" rsos_id="{{$production->id}}" 
                                    production_id="{{$production->id}}">
                                        <option style="border: 0px;" value="0" {{$production->rsos ? '' : 'selected'}}>No</option>
                                        <option style="border: 0px;" value="1" {{$production->rsos ? 'selected' : ''}} >Yes</option>
                                    </select>
                                </td>
                                <td>
                                    <textarea class="content-cell feedback" name="keywords" id="keywords{{$production->id}}" 
                                    production_id="{{$production->id}}">{{$production->keywords}}</textarea>
                                </td>
                        {{--@endif--}}
                        <td>
                            <select class="form-control feedback topic_select" production_id="{{$production->id}}"
                                    style="border: 0px; padding: 0px; @if(!$production->topic) display:none; @endif " name="topic_approved">
                                    <option value="" disabled selected>Choose</option>
                                <!-- <option value="" selected hidden>{{$production->topic_approved}}</option> -->
                                @if($production->topic_approved == 'Approved')
                                    {{--<option style="border: 0px;" >Approved</option>--}}
                                    <option style="border: 0px;">Rejected</option>
                                    <option style="border: 0px;">Sent</option>

                                @elseif($production->topic_approved == 'Rejected')
                                    <option style="border: 0px;" >Approved</option>
                                    {{--<option style="border: 0px;">Rejected PBN</option>--}}
                                    <option style="border: 0px;">Sent</option>

                                @elseif($production->topic_approved == 'Sent')
                                    <option style="border: 0px;" >Approved</option>
                                    <option style="border: 0px;">Rejected</option>
                                    {{--<option style="border: 0px;">Working</option>--}}
                                @else
                                    <option style="border: 0px;" >Approved</option>
                                    <option style="border: 0px;">Rejected</option>
                                    <option style="border: 0px;">Sent</option>
                                @endif
                                {{--<option style="border: 0px;" >Approved</option>--}}
                                {{--<option style="border: 0px;">Sent</option>--}}
                                {{--<option style="border: 0px;">Rejected</option>--}}
                            </select>
                        </td>
                    </tr>
                @endif
                @endforeach
                @endif
                @endforeach
                </tbody>

            </table>
        </div>
    </div>


@endsection
@section('script')
    <script src="{{asset('js/jquery-datatables-editable/jquery.dataTables.js')}}"></script>
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
            var table_id = '#topic{{$partner->id}}';
          $(table_id).DataTable({
                "columns": [
                    null,
                    null,
                    { "width": "35%" },
                    null,
                    null,
                    null,
                    null,
                ],
                "order": [[ 6, "desc" ]],
                "bInfo": false,
                "bPaginate": false,
                "searching": false,
                "lengthChange": false,
                // "scrollX": true,
                dom: 'fB<"toolbar{{$partner->id}}">t',
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

             $("div.toolbar{{$partner->id}}").html('<b>{{$partner->domain}}</b>');
             @endforeach

            $('.feedback').each(function(){
                var x = $(this).text();
                console.log(x);
                if (x == 'Rejected') $(this).css('border-bottom', 'solid 5px red');
                if (x == 'Sent') $(this).css('border-bottom', 'solid 5px orange');
                if (x == 'High') $(this).css('border-bottom', 'solid 5px red');
                if (x == 'Low') $(this).css('border-bottom', 'solid 5px green');
                if (x == 'Medium') $(this).css('border-bottom', 'solid 5px orange');
            });
            $('.feedback').each(function(){
                var x = $(this).val();
                if (x == 'Rejected') $(this).css('border-bottom', 'solid 5px red');
                if (x == 'Working') $(this).css('border-bottom', 'solid 5px orange');
                if (x == 'Sent') $(this).css('border-bottom', 'solid 5px orange');
                if (x == 'High') $(this).css('border-bottom', 'solid 5px red');
                if (x == 'Low') $(this).css('border-bottom', 'solid 5px green');
                if (x == 'Medium') $(this).css('border-bottom', 'solid 5px orange');

            });
            $('.topic_text').change(function () {
                $($($(this).closest('tr')).find('.topic_select')).show();
            });
            $('.feedback').change(function () {
                var x = $(this).val();
                var name = $(this).attr('name');
                if (x == 'Approved') {
                    $(this).css({backgroundColor: '#00c974'});
                    $(this).parents("tr").hide();
                }
                if (x == 'Rejected') {
                    $(this).css('border-bottom', 'solid 5px red');
                    var partner_id = $(this).attr('partner_id');
                    var oTable = $(partner_id).DataTable();
                    console.log(oTable);
                    oTable.order( [ 6, 'asc' ] ).draw(false);
                }
                if (x == 'Working') $(this).css('border-bottom', 'solid 5px orange');
                if (x == 'Sent') $(this).css('border-bottom', 'solid 5px orange');
                if (x == 'High') $(this).css('border-bottom', 'solid 5px red');
                if (x == 'Low') $(this).css('border-bottom', 'solid 5px green');
                if (x == 'Medium') $(this).css('border-bottom', 'solid 5px orange');
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

        //rsos
        $('.rsos').change(function () {
            var x = $(this).val();
            var rsos_id = $(this).attr('rsos_id');
            console.log(x);
//            $('#keywords'+rsos_id).css('display','block');
            if(x == 0){
            $('#keywords'+rsos_id).css('display','none');
            }
            if(x ==1) {
            $('#keywords' + rsos_id).css('display', 'block');
            }

        });
        //search start
//        $(function() {
//
//            var mark = function() {
//                var keyword = $("input[name='keyword']").val();
//                var options = {};
//                $(".marked").unmark({
//                    done: function() {
//                        $(".marked").mark(keyword, options);
//                    }
//                });
//            };
//            $("input[name='keyword']").on("input", mark);
//        });
        // search end
    </script>
@endsection


