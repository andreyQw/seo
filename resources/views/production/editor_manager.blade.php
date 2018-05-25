@extends('layouts.dashboard_layout')
@section('name','Editor Manager')
@section('content')
    <link rel="stylesheet" href="{{ asset('css/production.css') }}">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.5.1/css/buttons.dataTables.min.css">
@role('super_admin|admin|pm|production')
    <div class="row">
        {!! Form::open(['route' => 'editor_search', 'class' => 'form-horizontal', 'method'=>'POST' ]) !!}
        {{ csrf_field() }}
        <div class="col-lg-8 search_input" style="padding-right: 0px">
            <input type="text" name="keyword" class="form-control input-sm" placeholder="Search here">
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
        {!! Form::close() !!}
        <div class="col-lg-12 marked">

            <table class="table table-responsive table-hover table-bordered assined context" >
                <thead style="background-color: #f15e33; color: white">
                <tr>
                    <th>Partner Name</th>
                    <th class="noExl">Priority</th>
                    <th>Content Topic</th>
                    <th>Assigned</th>
                </tr>
                </thead>
                <tbody style="background-color: white" >
                @foreach($productions as $production)
                @if(!$production->editor_id)
                    <tr class="gradeA">
                        <td>{{$production->partner->domain}}</td>
                        {{--@if(Auth::user()->id == $project->id || Auth::user()->hasAnyRole('super_admin|admin'))--}}
                        <td >
                            <select class="form-control feedback approve" production_id="{{$production->id}}"
                             name="priority" style="border: 0px; padding: 0px; ">
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
                       
                        <td>
                            {{$production->topic}}
                        </td>
                        <td >
                            <select class="form-control feedback choose_editor" style="border: 0px; padding: 0px; " 
                            name="editor" production_id="{{$production->id}}" writer="{{$production->writer->user->first_name}} {{$production->writer->user->last_name}}">
                                    
                                @if($production->editor_id)
                                    <option default>{{$production->editor->user->first_name}} {{$production->editor->user->last_name}}</option>
                                @else
                                    <option default>Choose Editor</option>
                                @endif
                                @foreach($editors as $editor)
                                @if($production->editor_id != $editor->id)
                                    <option style="border: 0px;" value="{{$editor->id}}" 
                                    >{{$editor->user->first_name}} {{$editor->user->last_name}}</option>
                                @endif
                                @endforeach
                            </select>
                        </td>
                    </tr>

                @endif
                @endforeach
                </tbody>

            </table>

        </div>

        @foreach($editors as $editor)
            <div class="col-lg-12 marked">
                <b>{{$editor->user->first_name}} {{$editor->user->last_name}}</b>
                <table class="table table-responsive table-hover table-bordered status" 
                id="editor{{$editor->id}}" production_id="{{$production->id}}">
                    <thead style="background-color: #f15e33; color: white">
                    <tr>
                        <th>Partner Name</th>
                        <th class="noExl">Priority</th>
                        <th>Content Topic</th>
                        <th>Content Writer</th>
                        <th>Status</th>
                    </tr>
                    </thead>
                    <tbody style="background-color: white" >
                    @foreach($productions as $production)
                        @if($production->editor_id == $editor->id && $production->content_edited != 'Finished')
                            <tr  class="gradeA">
                                <td>{{$production->partner->domain}}</td>
                                <td >
                                    <select class="form-control feedback approve" name="priority" style="border: 0px; padding: 0px; " production_id="{{$production->id}}">
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
                                <td class="topic">
                                    {{$production->topic}}
                                </td>
                                <td id="writer_name">
                                    {{$production->writer->user->first_name}} {{$production->writer->user->last_name}}
                                </td>
                                <td>
                                    <select class="form-control feedback approve" style="border: 0px; padding: 0px; " name="content_edited" production_id="{{$production->id}}">                                            
                                        <option style="border: 0px;" >{{$production->content_edited}}</option>                                      
                                        <option style="border: 0px;" >Finished</option>                                      
                                    </select>
                                </td>
                            </tr>
                        @endif
                    @endforeach
                    </tbody>
                </table>
            </div>
        @endforeach
    </div>
    </div>

@endrole


@role('editor')
<div class="row">     
<?php
$editor = Auth::user()->editor;
?>       
        
            <div class="col-lg-12 marked">
                <b>{{$editor->user->first_name}} {{$editor->user->last_name}}</b>
                <table class="table table-responsive table-hover table-bordered status" 
                id="editor{{$editor->id}}" >
                    <thead style="background-color: #f15e33; color: white">
                    <tr>
                        <th>Partner Name</th>
                        <th class="noExl">Priority</th>
                        <th>Content Topic</th>
                        <th>Content Writer</th>
                        <th>Status</th>
                    </tr>
                    </thead>
                    <tbody style="background-color: white" >
                    @foreach($productions as $production)
                        @if($production->editor_id == $editor->id && $production->content_edited != 'Finished')
                            <tr  class="gradeA">
                                <td>{{$production->partner->domain}}</td>
                                <td >
                                    <select class="form-control feedback approve" name="priority" style="border: 0px; padding: 0px; " production_id="{{$production->id}}">
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
                                <td class="topic">
                                    {{$production->topic}}
                                </td>
                                <td id="writer_name">
                                    {{$production->writer->user->first_name}} {{$production->writer->user->last_name}}
                                </td>
                                <td>
                                    <select class="form-control feedback approve" style="border: 0px; padding: 0px; " name="content_edited" production_id="{{$production->id}}">                                            
                                        <option style="border: 0px;" >{{$production->content_edited}}</option>                                      
                                        <option style="border: 0px;" >Finished</option>                                      
                                    </select>
                                </td>
                            </tr>
                        @endif
                    @endforeach
                    </tbody>
                </table>
            </div>
    </div>
    </div>

@endrole

@endsection
@section('script')
    <script src="{{asset('js/jquery-datatables-editable/jquery.dataTables.js')}}"></script>

    <script src="https://cdn.jsdelivr.net/mark.js/8.6.0/jquery.mark.min.js"></script>

    <script>
        $(document).ready(function() {
            $('.assined').DataTable({
                "columns": [
                    { "width": "15%" },
                    { "width": "15%" },
                    { "width": "55%" },
                    { "width": "15%" }
                ],
                "bInfo": false,
                "bPaginate": false,
                "searching": false,
                "lengthChange": false,
                // "scrollX": true,
//                dom: 'f<"toolbar">t'
            });
            {{--$("div.toolbar").html('<b>{{$partner->domain}}</b>');--}}
            //second table

            $('.status').DataTable({
                "columns": [
                    { "width": "15%" },
                    { "width": "15%" },
                    { "width": "50%" },
                    { "width": "10%" },
                    { "width": "10%" }
                ],
                "bInfo": false,
                "bPaginate": false,
                "searching": false,
                "lengthChange": false,
                // "scrollX": true,
//                dom: 'f<"toolbar">t'
            });
            {{--$("div.toolbar").html('<b>{{$writer->user->first_name}} {{$writer->user->last_name}}</b>');--}}

            $('.approve').each(function(){
                var x = $(this).text();                
                if (x == 'Finished') $(this).css('border-bottom', 'solid 5px green');
                if (x == 'Not Working') $(this).css('border-bottom', 'solid 5px red');
                if (x == 'Medium') $(this).css('border-bottom', 'solid 5px orange');
                if (x == 'High') $(this).css('border-bottom', 'solid 5px red');
                if (x == 'Low') $(this).css('border-bottom', 'solid 5px green');
                if (x == 'Working') $(this).css('border-bottom', 'solid 5px orange');
            });
            $('.feedback').each(function(){
                var x = $(this).val();
                if (x == 'Finished') $(this).css('border-bottom', 'solid 5px green');
                if (x == 'Not Working') $(this).css('border-bottom', 'solid 5px red');
                if (x == 'Medium') $(this).css('border-bottom', 'solid 5px orange');
                if (x == 'High') $(this).css('border-bottom', 'solid 5px red');
                if (x == 'Low') $(this).css('border-bottom', 'solid 5px green');
                if (x == 'Working') $(this).css('border-bottom', 'solid 5px orange');

            });
            $('.feedback').change(function () {
                var x = $(this).val();
                var y = $(this).attr('name');
                var w = $(this).attr('writer');
                var production_id = $(this).attr('production_id');
                if(y == 'editor') {
                    var oi = $(this).parents("tr").clone();
                    $(this).parents("tr").hide();
                    $('.dataTables_empty').hide();
                    oi.append('<td><select class="form-control select_status" '+
                        'production_id="'+ production_id +'" style="border: 5px; border-bottom-color:orange; padding: 0px;"' +
                        ' name="content_edited">'+                        
                        '<option style="border: 5px; border-bottom-color:orange">Working</option>' +
                        '<option style="border: 0px;">Finished</option>'+
                    '</td>');
                    $("#editor"+x).append(oi);                    
                    $(oi).attr('class', 'writer_add');
                    $('.writer_add .choose_editor').remove();
                    $('.writer_add td').eq(3).html(w); 
                    $('.select_status').change(function () {
                    var x = $(this).val();
                    console.log(w);
                    if (x == 'Finished'){ 
                        $(this).parents("tr").hide();
                        }
                        var name = $(this).attr('name');
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
        })
                }
                if (x == 'Finished'){ 
                $(this).css('border-bottom', 'solid 5px green');
                $(this).parents("tr").hide();
                }
                if (x == 'Not Working') $(this).css('border-bottom', 'solid 5px red');
                if (x == 'Medium') $(this).css('border-bottom', 'solid 5px orange');
                if (x == 'High') $(this).css('border-bottom', 'solid 5px red');
                if (x == 'Low') $(this).css('border-bottom', 'solid 5px green');
                if (x == 'Working') $(this).css('border-bottom', 'solid 5px orange');
                var token = "{{ csrf_token() }}";
                var name = $(this).attr('name');
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


