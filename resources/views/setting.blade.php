@extends('layouts.dashboard_layout')

@section('name', 'Account Setting')

@section('content')

    <div class="row personal_info">

        <div>
            <div class="header_pi">
                <span class="name_block_set">Personal Information</span>
                <button class="btn btn-default save_personal_info" type="submit" form="personal_info_form"><span class="glyphicon glyphicon-plus-sign"></span>Save</button>
            </div>

            <div class="form_set">
                <form action="{{ route('change_personal_info') }}" method="post" enctype="multipart/form-data" id="personal_info_form">

                    {{ csrf_field() }}

                    @if ($errors->has('photo'))
                        <div class="alert alert-danger">
                            {{ $errors->first('photo') }}
                        </div>
                    @elseif($errors->has('first_name'))
                        <div class="alert alert-danger">
                            {{ $errors->first('first_name') }}
                        </div>
                    @elseif($errors->has('last_name'))
                        <div class="alert alert-danger">
                            {{ $errors->first('last_name') }}
                        </div>
                    @elseif($errors->has('email'))
                        <div class="alert alert-danger">
                            {{ $errors->first('email') }}
                        </div>
                    @elseif($errors->has('phone'))
                        <div class="alert alert-danger">
                            {{ $errors->first('phone') }}
                        </div>
                    @endif
                    {{--<div class="form-group">--}}

                        {{--<label class="photo_load" for="photo">--}}
                            {{--<img src="{{ asset('storage/photo_users/' . Auth::user()->photo) }}" id="load_photo_user" alt="">--}}
                            {{--<span id="descript_upload">Upload photo</span>--}}
                            {{--<input accept="image/jpeg,image/png" id="photo" value="Upload Photo" name="photo" type="file" class="form-control">--}}
                        {{--</label>--}}
                    {{--</div>--}}

                    <div class="form-group">
                        <label class="photo_load" for="photo">
                            <img src="{{asset('storage/photo_users/' . Auth::user()->photo)}}" id="load_photo_user" alt="">
                            <span id="descript_upload">Upload New Picture</span>
                            <input accept="image/jpeg,image/png" id="photo" value="Upload Photo"
                                   name="photo" type="file" class="form-control">
                        </label>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6 left_form_group" id="first_pi">
                            <label for="first_name">First Name</label>
                            <input id="first_name" name="first_name" required type="text" class="form-control" value="{{ Auth::user()->first_name }}">
                        </div>
                        <div class="form-group col-md-6 right_form_group" id="second_pi">
                            <label for="last_name">Last Name</label>
                            <input id="last_name" name="last_name" required type="text" class="form-control" value="{{ Auth::user()->last_name }}">
                        </div>
                    </div>
                    <div class="form-row bottom_row_group">
                        <div class="form-group col-md-6 left_form_group" id="phone_pi">
                            <label for="phone">Phone</label>
                            <input id="phone" name="phone" type="phone" class="form-control" placeholder="0800123456789" pattern="[0-9]{6,18}" value="{{ Auth::user()->phone }}">
                        </div>
                        <div class="form-group col-md-6 right_form_group" id="mail_pi">
                            <label for="email">E-mail</label>
                            <input id="email" name="email" type="email" required class="form-control" value="{{ Auth::user()->email }}">
                        </div>
                    </div>

                </form>
            </div>
        </div>

    </div>

    <div class="row change_pass">

        <div>
            <div class="header_pi">
                <span class="name_block_set">Change Password</span>
                <button class="btn btn-default save_personal_info" type="submit" form="change_pass_form"><span class="glyphicon glyphicon-plus-sign"></span>Save</button>
            </div>

            <div class="form_set">
                <form action="{{ route('change_pass') }}" method="post" id="change_pass_form">

                    {{ csrf_field() }}

                    @if (session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif

                    @if ($errors->has('new_pass'))
                        <div class="alert alert-danger">
                            {{ $errors->first('new_pass') }}
                        </div>
                    @endif

                    <div class="form-row bottom_row_group">
                        <div class="form-group col-md-6 left_form_group">
                            <label for="password">Old Password</label>
                            <input id="password" name="password" required type="password" class="form-control">
                        </div>
                        <div class="form-group col-md-6 right_form_group">
                            <label for="new_pass">New Password</label>
                            <input id="new_pass" name="new_pass" type="password" required class="form-control">
                        </div>
                    </div>

                </form>
            </div>
        </div>

    </div>


        <div class="row change_notify">

            <div>
                <div class="header_pi">
                    <span class="name_block_set">Change Notification</span>
                    <button class="btn btn-default save_personal_info" type="submit" form="change_notifi"><span class="glyphicon glyphicon-plus-sign"></span>Save</button>
                </div>

                <div class="form_set">
                    <form action="{{ route('change_notifi') }}" method="post" enctype="multipart/form-data" id="change_notifi">

                        {{ csrf_field() }}

                        @foreach(Auth::user()->projects as $project)

                            <div class="form-row sites_notify">

                                <label for="{{ $project->url }}" class="col-xs-11">
                                    <p id="first">Notification {{ $project->url }}</p>
                                    <p id="last"></p>
                                    <hr class="settings_notification_line">
                                </label>

                                <div class="col-xs-1">
                                    <input type="checkbox" name="id[{{ $project->id }}]" class="custom-control-input" id="{{ $project->url }}" @if($project->pivot->enable_notifi) checked @endif>
                                    <i></i>
                                    
                                </div>
                                    
                            </div>

                        @endforeach

                    </form>
                </div>
            </div>

        </div>

@endsection

@section('script')

    <script>

        // PREVIEW LOAD PHOTO
        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#load_photo_user').attr('src', e.target.result);
                };

                reader.readAsDataURL(input.files[0]);
            }
        }

        $("#photo").change(function(){
            readURL(this);
        });

    </script>

@endsection
