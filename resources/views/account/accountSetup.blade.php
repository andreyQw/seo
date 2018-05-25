@extends('layouts.dashboard_layout')

@section('name', 'Account Setup')

@section('content')

   <link rel="stylesheet" href="{{ asset('css/account_settings_style.css') }}">

    <form action="{{ route('editAccount') }}" method="post" enctype="multipart/form-data" id="personal_info_form">
        {{ csrf_field() }}

        <div class="row personal_info">
            <div class="col-sm-12 col-xs-12 nopadding">

            <div class="header_pi">
                <span class="name_block_set">Your Detail</span>
            </div>

            <div class="form_set">
                <div class="col-md-12 col-sm-12 col-xs-12">
                @if($errors->any())
                    @foreach ($errors->all() as $error)
                        <div class="alert alert-danger">{{ $error }}</div>
                    @endforeach
                @endif

                {{--<div>--}}
                {{--{{ var_dump(Auth::user()->orders()->first()->projects) }}--}}
                {{--</div>--}}
                <div class="col-sm-12 col-md-2">
                <div class="form-group">
                    <label class="photo_load" for="photo">
                       <div style="background-image: url({{asset('img/photo_users/user_anonim.png')}})" id="load_photo_user" ></div>
                        <span id="descript_upload">Upload Picture</span>
                        <input accept="image/jpeg,image/png" id="photo" value="Upload Photo"
                               name="photo" type="file" class="form-control">
                    </label>
                </div>
                 </div>

                   <div class="col-sm-12 col-md-5">
                    <div class="form-group left_form_group" id="first_pi">
                        <label for="first_name">Your Name</label>
                        <input id="first_name" name="first_name"
                               type="text" class="form-control" value="{{Auth::user()->first_name}}"
                               {{--type="text" class="form-control" value="{{$order->user->first_name}}"--}}
                               required>
                    </div>
                      <div class="form-group left_form_group" id="phone_pi">
                        <label for="phone">Phone No</label>
                        <input id="phone" name="phone" type="phone" class="form-control"
                               placeholder="0800123456789"
                               value="{{Auth::user()->phone }}"
                               required>
                    </div>
            </div>
                    <div class="col-sm-12 col-md-5">
                    <div class="form-group right_form_group" id="second_pi">
                        <label for="country">Country</label>
                        <select class="form-control margin_10" id="country" name="country">
                            <option selected="selected">Australia (AU)</option>
                            <option>Canada (CA)</option>
                            <option>Denmark (DK)</option>
                            <option>France (FR)</option>
                            <option>Hong Kong (HK)</option>
                            <option>Italy (IT)</option>
                            <option>Japan (JP)</option>
                            <option>New Zealand (NZ)</option>
                            <option>Singapore (SG)</option>
                            <option>Switzerland (CH)</option>
                            <option>United Kingdom (GB)</option>
                            <option>United States (US)</option>
                        </select>
                    </div>

                    <div class="form-group right_form_group" id="mail_pi">
                        <label for="email">Email</label>
                        <input id="email" name="email" type="email"
                               class="form-control"
                               value="{{Auth::user()->email}}"
                               required>
                    </div>
                </div>
                </div>
            </div>
          </div>
        </div>

        <div class="row change_pass">
          <div class="col-sm-12 col-xs-12 nopadding">
            <div>
                <div class="header_pi">
                    <span class="name_block_set">Set Password</span>
                    {{--<button class="btn btn-default save_personal_info" type="submit" form="change_pass_form">--}}
                    {{--<span class="glyphicon glyphicon-plus-sign"></span>Save--}}
                    {{--</button>--}}
                </div>

                <div class="form_set">
                    {{--<form action="{{ route('change_pass') }}" method="post" id="change_pass_form">--}}

                    {{--{{ csrf_field() }}--}}

                    @if (session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif

                    {{--@if ($errors->has('new_pass'))--}}
                    {{--<div class="alert alert-danger">--}}
                    {{--{{ $errors->first('new_pass') }}--}}
                    {{--</div>--}}
                    {{--@endif--}}


                        <div class="form-group col-md-6 left_form_group">
                            <label for="password">Password</label>
                            <input id="password" name="password"
                                   type="password" class="form-control"
                                   required>
                        </div>
                        <div class="form-group col-md-6 right_form_group">
                            <label for="password_confirmation">Confirm Password</label>
                            <input id="password_confirmation" name="password_confirmation"
                                   type="password"  class="form-control"
                                   required>
                        </div>


                    {{--</form>--}}
                </div>
            </div>
          </div>
        </div>


        <div class="row change_notify">
          <div class="col-sm-12 col-xs-12 nopadding">


            <div class="header_pi">
                <div class="form-group col-md-10 left_form_group">
                    <span class="name_block_set">Website Confirmation</span>
                </div>
                {{--<div class="form-group col-md-2 right_form_group">--}}
                {{--<button class="btn btn-warning" type="submit" form="change_notifi">--}}
                {{--<span class="glyphicon glyphicon-plus-sign"></span>--}}
                {{--Do it Later--}}
                {{--</button>--}}
                {{--</div>--}}

            </div>

            <div class="form_set">

                <table>
                    <tr>
                        <th>Website Name</th>
                        <th>Type of Product</th>
                        <th>No of Units</th>
                        <th>Niche</th>
                        <th>Bio</th>
                        <th></th>
                    </tr>

                    @foreach(Auth::user()->orders()->first()->projects as $project)

                        @foreach($project->products as $product)

                            {{--{{var_dump($project->products)}}--}}

                            <tr id="{{'tr_proj_'.$project->id}}">
                                <td>

                                    <input type="hidden" name="project_id[]" value="{{$project->id}}">
                                    <input name="project_name[]"
                                           type="text" class="form-control website_name"
                                           value="{{ $project->url }}"
                                           id="{{'proj_name_'.$project->id}}"
                                           disabled>
                                </td>
                                <td>
                                    <input name="project_name[]"
                                           type="text" class="form-control type_of_product"
                                           value="{{ $product->title }}"
                                           disabled>
                                </td>
                                <td>
                                   <input name="project_name[]"
                                           type="text" class="form-control no_of_units"
                                           value="{{ $product->pivot->quantity }}"
                                           disabled>
                                </td>
                                <td>
                                    {{--<select name="niche[]" multiple>--}}
                                    <select name="niche[]" class="select_last_block" required>
                                        <option selected value="" hidden>Nich Here</option>
                                        @foreach($niches as $niche)
                                            <option value="{{$niche->id}}">{{$niche->name}}</option>
                                        @endforeach
                                    </select>
                                </td>
                                <td>
                                    <div class="alert alert-success success-bio-send-mm" id="{{'show_success_div_'.$project->id}}" style="display: none">
                                        <p>Bio was send</p>
                                    </div>
                                    {{--<select name="notific[]">--}}
                                        {{--<option selected value="i_will_do_my_bio">I will do my bio</option>--}}
                                        {{--<option value="no_bS_to_do_my_bio">No BS to do my bio</option>--}}
                                    {{--</select>--}}
                                    @if($project->bio == null)
                                    <button id="{{ 'proj_id_nobs_do_'.$project->id }}"
                                            class="btn btn-warning project_nobs_my_bio btn-lg"
                                            {{--data-toggle="modal"--}}
                                            {{--data-target="#bio_modal"--}}
                                            type="button"
                                            proj_id_nobs_do="{{ $project->id }}"

                                    >No BS to do my bio</button>
                                    @endif
                                </td>
                                <td>
                                    @if($project->bio == null)
                                    <button id="{{'proj_'.$project->id}}"
                                            class="btn btn-primary project_doit_now_bio btn-lg"
                                            data-toggle="modal"
                                            data-target="#bio_modal"
                                            project_name="{{ $project->url }}"
                                            type="button"

                                    >Do it Now</button>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    @endforeach
                </table>
            </div>
        </div>
        </div>

        <div class="row confirm_changes">
          <div class="col-md-12 col-sm-12 col-xs-12 nopadding">


            <button class="btn btn-default confirm_account_setiings" type="submit" form="personal_info_form"><span class="glyphicon glyphicon-plus-sign"></span>Confirmed</button>
        </div>
        </div>
    </form>
    {{--11111111111111111111--}}
    <div class="col-xs-12">
    <div class="modal fade"
         id="bio_modal"
         tabindex="1" role="dialog" aria-labelledby="bio_label" aria-hidden="true">
        <div class="modal-dialog bio_modal_dialog">
            <div class="modal-content">
                <div class="modal-header bio_modal_header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title bio_modal_title" id="bio_label">Bio</h4>
                    <hr class="bio_popup_line">
                </div>
                <div class="modal-body bio_modal_body" id="bio_modal">
                    <div id="please_wait" style="display: none" class="alert alert-success">
                        <p>please_wait...</p>
                    </div>
                    <div id="form_errors"></div>
                    {{--222222222222222--}}

                    {{--222222222222222222--}}
                    {{--{!! Form::open(['route'=>'confirmBio','method'=>'POST','files'=>true, 'class'=> 'form-control', 'id'=>'bio_form']) !!}--}}
                    <form id="bio_form" action="{{ route('confirmBio') }}" method="POST" enctype="multipart/form-data" files=true>
                    {{ csrf_field() }}


                        <div class="right_colmn col-xs-12">

                        <div class="form-group">
                            <label for="load_bio_screen" id="label_load_screen" class="popup_caption">
                                Upload Image

                            </label>
                            <div class="cont_load">
                                <span id="new_screen_name"></span>
                                <button id="upload_new" type="submit" onsubmit="return false;" class="btn btn-default"><span class="glyphicon glyphicon-open"></span>Upload New</button>
                                <input form="bio_form" id="load_bio_screen" required type="file" name="image" accept="image/jpeg,image/png" class="form-control">
                            </div>
                        </div>
                        <div class="form-group last_links_form">

                            <label for="bio_write" class="popup_caption">Write Bio</label>

                            <textarea form="bio_form" name="bio_write" id="bio_write" class="form-control" required></textarea>

                        </div>
                    </div>
                    <div class="left_colmn col-xs-12">
                        <div class="info_bio">
                        {{----}}
                            <div class="form-group">
                                <label for="website_select" class="popup_caption">Website Name</label>
                                <input type="text" name="site" id="website_select" class="form-control" readonly>
                                <input id="project_id_in_bio" type="hidden" name="project_id"  value="">
                            </div>
                           {{--<div class="form-group">--}}
                                {{--<input type="text" class="form-control" id="inform_nobs">--}}
                                {{--<button class="btn btn-default btn-block btn_inform" id="inform_nobs">Inform NO BS to do the bio</button>--}}
                            {{--</div> --}}
                        </div>

                        <div class="col-sm-offset-2 col-sm-8">
                        <button id="bio_save" class="btn btn-default save_personal_info btn-lg " type="button" form="bio_form"><span class="glyphicon glyphicon-plus-sign"></span>Save</button>
                        </div>
                    </div>

                    </form>
                    {{--{!! Form::close() !!}--}}
                </div>
            </div>
        </div>
    </div>
    </div>
    {{--1111111111111111111--}}
@endsection

@section('script')

    <script>
        $('.project_nobs_my_bio').on('click', function(e) {
//            console.log(e.currentTarget);
//            proj_id_nobs_do
            var proj_id = e.currentTarget.getAttribute('proj_id_nobs_do');
            console.log('/account/noBsDoBio/'+proj_id);


            $.get("/account/noBsDoBio/"+proj_id, function(data, status){
                console.log(data);
                var proj_id = data.proj_id;

                $('#proj_id_nobs_do_'+proj_id).hide();
                $('#proj_'+proj_id).hide();
                var id_div_success = 'show_success_div_'+ $("input[name='project_id']").val();
                console.log(id_div_success);

                $("#"+id_div_success).css("display", "block");
                $('#new_screen_name').text('');
                $('#bio_write').val('');
                $('#bio_modal').modal('hide');

                var id_div_success = 'show_success_div_'+ proj_id;
//                console.log(id_div_success);

                $("#"+id_div_success).css("display", "block");
//                alert("Data: " + data + "\nStatus: " + status);
            });

        });


        $('.project_doit_now_bio').on('click', function(){

//                $('form ').submit(function() {
//                    return false;
//                });

//            send_bio_ajax();
            var proj_id = $(this).attr('id').substring(5);
            var proj_name = $(this).attr('project_name');
            console.log(proj_id);
            console.log(proj_name);

            $("#new_screen_name").text('');

            $("#project_id_in_bio").val(proj_id);
            $("#website_select").val(proj_name);
        });

        //        console.log(proj_id);

        // PREVIEW LOAD FILE
        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#load_photo_user').css('backgroundImage', 'url(' + e.target.result + ')');
//                    $('#load_photo_user').attr('src', e.target.result);
                };

                reader.readAsDataURL(input.files[0]);
            }
        }
        $("#photo").change(function(){
            readURL(this);
        });


        $('#load_bio_screen').on('change', function (e) {

            $('#new_screen_name').text(e.currentTarget.files[0].name);

        });
//        $("#upload_new").change(function() {
//            readURL(this);
//        });



        var send = false;
        $('#bio_save').on('click', function(e) {
            if (send){
                return false;
            }
            send = true;
            $("#please_wait").css("display", "block");

            var waiting = 0;
//            var bio_site_name = $('#proj_name_'+proj_id);
//            console.log('qwe');
//            console.log(e.target);

            $("#form_errors").children().remove();
            var $form = $('#bio_form');

//            console.log( + 'qweq');
            console.log(new FormData($("#bio_form")[0]));
            $.ajax({
                processData: false,
                contentType: false,
                type: $form.attr('method'),
                url: $form.attr('action'),
                data: new FormData($("#bio_form")[0]),
                success : function ( data )
                {
                    if (data.error){
                        $("#new_screen_name").text('');
                        $("#please_wait").css("display", "none");
//                        $("#form_errors").children().remove();

                        var errors = data.error;
                        $("#load_bio_screen").val('');
                        console.log($("#load_bio_screen")[0].files);
                        console.log(data.error);

                        errors.forEach(function(value ) {
                            console.log(value );
                            $("#form_errors").append("<p style='color: red'>"+value+"</p>");
                        });
                        send = false;

                    }else if(data.success){
                        $("#new_screen_name").text('');
                        $("#please_wait").css("display", "none");
                        console.log(data.proj_id);
                        var proj_id = data.proj_id;

                        $('#proj_id_nobs_do_'+proj_id).hide();
                        $('#proj_'+proj_id).hide();
                        var id_div_success = 'show_success_div_'+ $("input[name='project_id']").val();
                        console.log(id_div_success);

                        $("#"+id_div_success).css("display", "block");
                        $('#new_screen_name').text('');
                        $('#bio_write').val('');
                        $('#bio_modal').modal('hide');
                        send = false;

                    }

                },
                error: function(errors){
//                    $("#form_errors").addClass("review-message-error").fadeIn(400).html(data);


//                    errorsHtml = '<div class="alert alert-danger"><ul>';
//                    $("#form_errors").html( errorsHtml );

                    console.log(errors);
                }

            }).done(function(data) {
//                console.log('success');
                console.log(data);
            }).fail(function(data) {
                console.log('Error:', data);
//                console.log('fail');
            });

            //отмена действия по умолчанию для кнопки submit
            e.preventDefault();
        });

        //            console.log('here');



        /////////////////////////////////////////////////////////////////////////////
        //        $('.project_bio').on('click', function(e) {
        //
        //            console.log(e);

        //            var id = $(e.currentTarget).attr('id');
        //            $.ajax({
        //                method: 'POST',
        //                url: '/bio/modal',
        //                data: {
        //                    'id': id,
        //                    '_token': $('meta[name="csrf-token"]').attr('content')
        //                },
        //                success: function(data) {
        //                    if ($(e.target).attr('class') == 'mdi mdi-settings power edit_bio_icon') {
        //                        $('#z_text').show();
        //                        $('#screen').show();
        //                        $('#text_bio').show();
        //                        $('#text_bio').val(data.text);
        //                        $('.save_new_bio').show();
        //                        $('#bio_write_info').hide();
        //                        $('.download_bio').hide();
        //                    } else {
        //                        $('#bio_write_info').show();
        //                        $('#bio_write_info').html(data.text);
        //                        $('.download_bio').show();
        //                        $('.download_bio').attr('href', '/bio/download/' + data.id);
        //
        //                        $('#z_text').hide();
        //                        $('#screen').hide();
        //                        $('#text_bio').hide();
        //                        $('.save_new_bio').hide();
        //                    }
        //                    $('.bio_modal_body').attr('id', data.id);
        //                    $('.image_bio img').attr('src', '/storage/bio_img/' + data.img);
        //                    $('#bio_site_name').html(data.url);
        //                    $('input[name=id]').val(data.id);
        //                },
        //                error: function(err) {
        //                    console.log(err);
        //                }
        //            });
        //        });
    </script>
    <script>
        // PREVIEW LOAD PHOTO
        //        function readURL(input) {
        //            if (input.files && input.files[0]) {
        //                var reader = new FileReader();
        //                reader.onload = function (e) {
        //                    $('#load_photo_user').attr('src', e.target.result);
        //                };
        //                reader.readAsDataURL(input.files[0]);
        //            }
        //        }
        //        $("#image_bio").change(function(){
        //            readURL(this);
        //        });
    </script>

@endsection
