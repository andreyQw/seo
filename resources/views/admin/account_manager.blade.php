@extends('layouts.dashboard_layout')

@section('name', 'Account Manager')

@section('button_navbar')



     @role('super_admin|admin')
        <button type="button" class="btn btn-success header-btn-add-new" data-toggle="modal" data-target="#newAccount"><span class="glyphicon glyphicon-plus-sign"></span> Add New</button>
    @endrole

@endsection

@section('content')

    <link rel="stylesheet" href="{{ asset('css/account_manager_style.css') }}">

    @if ($errors->has('name'))
        <div class="alert alert-danger">{{ $errors->first('first_name') }}</div>
    @endif

    @if ($errors->has('email'))
        <div class="alert alert-danger">{{ $errors->first('last_name') }}</div>
    @endif

    @if ($errors->has('phone'))
        <div class="alert alert-danger">{{ $errors->first('email') }}</div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="col-md-12 search_bio">

        <form class="form-horizontal" action="{{ route('account.manager.search') }}" method="POST">
            {{ csrf_field() }}

            <div class="form-row search_bio_input">
                <div class="textsearch_user">Search Here</div>
                <div class="form-group input_search_cont">
                    <div class="input-group-lg search_input_group">
                        <input class="form-control search_input" id="search_bio" type="search" name="search" placeholder="Enter Keyword">
                        <span class="input-group-btn">
                    <button class="btn btn-default search_button" type="button"><span class="glyphicon glyphicon-search"></span></button>
                        </span>
                    </div>
                </div>
            </div>
        </form>

    </div>

    @foreach($accounts as $account)

        <div class="container_user">
            <div class="thumbnail user_manager_info_cont btn" id="{{ $account->id }}" data-toggle="modal" data-target="#myModal">
                <div class="col-lg-12 custom-photo-user" style="background-image: url(
                        @if($account->logo)
                            {{ asset('storage/account_logos/' . $account->logo) }}
                        @else
                            {{ asset('img/user_anonim.png') }}
                        @endif
                );">
                </div>
                <div class="caption">
                    <p id="full_name_user"> {{ $account->name }} </p>
                    <p id="online_ago_user"> {{ $account->last_activity() }} </p>
                </div>
            </div>

        </div>

    @endforeach

    @include('admin.new_account')

@endsection

@section('script')

    <script>

        // PREVIEW LOAD PHOTO
        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                  $('#load_photo_acc').css('background-image', "url('"+ e.target.result + "')");
                    // $('#load_photo_acc').attr('url', e.target.result);
                };

                reader.readAsDataURL(input.files[0]);
            }
        }

        $("#photo").change(function(){
            readURL(this);
        });

    </script>

@endsection
