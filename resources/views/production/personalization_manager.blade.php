@extends('layouts.dashboard_layout')
@section('name','Personalization Manager')
@section('content')
    <link rel="stylesheet" href="{{ asset('css/production.css') }}">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.5.1/css/buttons.dataTables.min.css">
    <div class="row">
        {!! Form::open(['route' => 'personalization_search', 'class' => 'form-horizontal', 'method'=>'POST' ]) !!}
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

            <table class="table table-hover table-responsive table-bordered assined context" >
                <thead style="background-color: #f15e33; color: white">
                <tr>
                    <th>Partner Name</th>
                    <th class="noExl">Priority</th>
                    <th>Content Topic</th>
                </tr>
                </thead>
                <tbody style="background-color: white" >
                @foreach($productions as $production)
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
                        <td>
                            {{$production->topic}}
                        </td>

                    </tr>


                @endforeach
                </tbody>

            </table>

        </div>

        <div class="col-lg-12 marked">
            <table class="table table-responsive table-hover table-bordered status context" >
                <thead style="background-color: #f15e33; color: white">
                <tr>
                    <th>Partner Name</th>
                    <th class="noExl">Priority</th>
                    <th>Editor</th>
                    <th>Content writer</th>
                    <th>Bio/Photos status</th>
                    <th>Archors/Links status</th>
                    <th></th>
                    <th>Overall Status</th>
                </tr>
                </thead>
                <tbody style="background-color: white" >
                @foreach($productions as $production)
                    <tr  class="gradeA">
                        <td>{{$production->partner->domain}}</td>
                        {{--@if(Auth::user()->id == $project->id || Auth::user()->hasAnyRole('super_admin|admin'))--}}
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

                        <td>{{$production->editor->user->first_name}} {{$production->editor->user->last_name}}</td>
                        <td>{{$production->writer->user->first_name}} {{$production->writer->user->last_name}}</td>

                        <td>
                            <select class="form-control feedback approve" style="border: 0px; padding: 0px; " name="bio_status" production_id="{{$production->id}}">                                    
                                <option style="border: 0px;" >{{$production->bio_status ? $production->bio_status : 'No'}}</option>
                                @if($production->bio_status == 'Finished')
                                {{--<option style="border: 0px;" >Finished</option>--}}
                                <option style="border: 0px;">Getting There</option>
                                @endif
                                @if($production->bio_status == 'Getting There')
                                <option style="border: 0px;" >Finished</option>
                                {{--<option style="border: 0px;">Getting There</option>--}}
                                @endif
                                @if(!$production->bio_status)
                                <option style="border: 0px;" >Finished</option>
                                <option style="border: 0px;">Getting There</option>
                                @endif
                                {{--<option style="border: 0px;">Not Working</option>--}}
                            </select>
                        </td>
                        <td>
                            <select class="form-control feedback approve" style="border: 0px; padding: 0px; " name="archor_status" production_id="{{$production->id}}">
                                <option style="border: 0px;" >{{$production->archor_status ? $production->archor_status : 'No'}}</option>
                                @if($production->archor_status == 'Finished')
                                    {{--<option style="border: 0px;" >Finished</option>--}}
                                    <option style="border: 0px;">Getting There</option>
                                @endif
                                @if($production->archor_status == 'Getting There')
                                    <option style="border: 0px;" >Finished</option>
                                    {{--<option style="border: 0px;">Getting There</option>--}}
                                @endif
                                @if(!$production->archor_status)
                                    <option style="border: 0px;" >Finished</option>
                                    <option style="border: 0px;">Getting There</option>
                                @endif
                            </select>
                        </td>
                        <td>

                            <div class="form-group col-lg-2">
                                <button class="btn btn-primary custom-file-upload" project_id="{{$production->project_id}}"
                                        production_id="{{$production->id}}"><i class="mdi mdi-upload"></i> Upload</button>
                            </div>

                        </td>
                        <td><div class="feedback approve">{{$production->overall}}</div>
                            <!-- <select class="form-control feedback approve" style="border: 0px; padding: 0px; " name="overall">
                                <option style="border: 0px;" >{{$production->overall}}</option>
                                <option style="border: 0px;" >Finished</option>
                                <option style="border: 0px;">Working</option>
                                <option style="border: 0px;">Not Working</option>
                            </select> -->
                        </td>
                    </tr>


                @endforeach
                </tbody>

            </table>

        </div>
    </div>
    </div>
    {{--MODAL --}}

    <div class="modal fade" id="modal_buy_more" role="dialog">
        <div class="modal-dialog modal-sm vertical-align-center">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                {!! Form::open(['route' => 'production.store', 'class' => 'form-horizontal', 'method'=>'POST' , 'files'=>'true']) !!}
                {{ csrf_field() }}
                <div class="container">
                    <div class="col-md-5 ">

                        <input id="project_id" type="hidden" name="project_id" >
                        <input id="production_id" type="hidden" name="production_id">
                            <div class="form-group">
                                <div class="input-group input-file" name="choose_file">
                                    <input type="text" class="form-control" required placeholder='Choose a file...' />
                                    <span class="input-group-btn">
        		<button class="btn btn-default btn-choose" type="button">Choose</button>
    		</span>


                                </div>
                            </div>
                            <!-- COMPONENT END -->
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary pull-right"  ><i class="mdi mdi-upload"></i> Upload</button>
                            </div>
                    </div>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>

@endsection
@section('script')
    <script src="{{asset('js/jquery-datatables-editable/jquery.dataTables.js')}}"></script>

    <script src="https://cdn.jsdelivr.net/mark.js/8.6.0/jquery.mark.min.js"></script>

    <script>

        $('.custom-file-upload').on('click', function(){
            var project_id = $(this).attr('project_id');
            var production_id = $(this).attr('production_id');
            $('#modal_buy_more').modal('show');
            $('#project_id').val(project_id);
            $('#production_id').val(production_id);

        });
        $(document).ready(function() {
            $('.assined').DataTable({
                "columns": [
                    { "width": "20%" },
                    { "width": "15%" },
                    { "width": "65%" },
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
                   { "width": "30%" },
                   { "width": "10%" },
                   { "width": "10%" },
                   { "width": "10%" },
                   { "width": "10%" },
                   { "width": "10%" },
                   { "width": "10%" },
                   { "width": "10%" }
               ],
                "bInfo": false,
                "bPaginate": false,
                "searching": false,
                "lengthChange": false,
                // "scrollX": true,
//                dom: 'f<"toolbar2">t'
            });
//            $("div.toolbar2").html('<b>Nicola Tesla</b>');

        $('.approve').each(function(){
            var x = $(this).text();
            if (x == 'Finished') $(this).parents("tr").hide();;
            if (x == 'Not Working') $(this).css('border-bottom', 'solid 5px red');
            if (x == 'Medium') $(this).css('border-bottom', 'solid 5px orange');
            if (x == 'High') $(this).css('border-bottom', 'solid 5px red');
            if (x == 'Low') $(this).css('border-bottom', 'solid 5px green');
            if (x == 'Working') $(this).css('border-bottom', 'solid 5px orange');
            if (x == 'Getting There') $(this).css('border-bottom', 'solid 5px orange');
        });
        $('.feedback').each(function(){
            var x = $(this).val();
            if (x == 'Finished') $(this).css('border-bottom', 'solid 5px green');
            if (x == 'Not Working') $(this).css('border-bottom', 'solid 5px red');
            if (x == 'Medium') $(this).css('border-bottom', 'solid 5px orange');
            if (x == 'High') $(this).css('border-bottom', 'solid 5px red');
            if (x == 'Low') $(this).css('border-bottom', 'solid 5px green');
            if (x == 'Working') $(this).css('border-bottom', 'solid 5px orange');
            if (x == 'Getting There') $(this).css('border-bottom', 'solid 5px orange');

        });
        $('.feedback').change(function () {
            var x = $(this).val();
            if (x == 'Finished') $(this).css('border-bottom', 'solid 5px green');
            if (x == 'Not Working') $(this).css('border-bottom', 'solid 5px red');
            if (x == 'Medium') $(this).css('border-bottom', 'solid 5px orange');
            if (x == 'High') $(this).css('border-bottom', 'solid 5px red');
            if (x == 'Low') $(this).css('border-bottom', 'solid 5px green');
            if (x == 'Working') $(this).css('border-bottom', 'solid 5px orange');
            if (x == 'Getting There') $(this).css('border-bottom', 'solid 5px orange');
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

        //upload file
        function bs_input_file() {
            $(".input-file").before(
                function() {
                    if ( ! $(this).prev().hasClass('input-ghost') ) {
                        var element = $("<input type='file' class='input-ghost' style='visibility:hidden; height:0'>");
                        element.attr("name",$(this).attr("name"));
                        element.change(function(){
                            element.next(element).find('input').val((element.val()).split('\\').pop());
                        });
                        $(this).find("button.btn-choose").click(function(){
                            element.click();
                        });
                        $(this).find("button.btn-reset").click(function(){
                            element.val(null);
                            $(this).parents(".input-file").find('input').val('');
                        });
                        $(this).find('input').css("cursor","pointer");
                        $(this).find('input').mousedown(function() {
                            $(this).parents('.input-file').prev().click();
                            return false;
                        });
                        return element;
                    }
                }
            );
        }
        $(function() {
            bs_input_file();
        });
    </script>
@endsection


