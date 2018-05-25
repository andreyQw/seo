
@extends('layouts.dashboard_layout')

@section('name', 'Bio Request Manager')

@section('content')
 <link rel="stylesheet" href="{{ asset('css/request_bio_manager_style.css') }}">
   
    <div class="row">


        {{-- MODAL WINDOW --}}
        <div id="save_text_bio" class="modal fade">
            <div class="modal-dialog">
                <div class="modal-content">
                    {{-- Заголовок модального окна --}}
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        <h4 class="modal-title">Add Bio</h4>

                    </div>
                    {{-- Основное содержимое модального окна --}}
                    <div class="modal-body">
                        <p>Bio</p>
                        <textarea name="" class="bio_text" cols="30" rows="10" style="resize: none"></textarea>
                    </div>
                    {{-- Футер модального окна --}}
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary save_bio_req" data-dismiss="modal">Save Bio</button>
                    </div>
                </div>
            </div>
        </div>
        {{-- END MODAL WINDOW --}}

       <!-- <div class="col-md-12 search_bio">

            <form class="form-horizontal" action="{{ route('bio_request_search') }}" method="POST">
                {{ csrf_field() }}

                <div class="form-row search_bio_input">
                    <label for="search_bio" class="control-label col-md-1" style="text-align: left;">Search Here</label>
                    <div class="col-md-11 form-group input_search_cont">
                        <input type="text" id="search_bio" class="form-control" name="search">
                    </div>
                </div>

            </form>

        </div>-->
        
        
        
        <div class="col-md-12 search_bio">
    <form class="form-horizontal" action="{{ route('bio_request_search') }}" method="POST">
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
        

        @if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif
    <div class="col-md-12">
       <div class="table-bio-wrapper">
        <table class="table table-bordered request-bio-table" style="background-color: #fff;">
            <thead>
                <tr>
                    <th>Client</th>
                    <th>Website Name</th>
                    <th>Bio Image</th>
                    <th>Bio Text</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
               
                @foreach($projects as $project)

                    <tr>
                        <form action="{{ url('/bio/requests/submit/' . $project->id) }}" method="POST" enctype="multipart/form-data">
                            <td>
                                {{ $project->account->name }}
                            </td>
                            <td>
                                {{ $project->url }}
                            </td>
                            
                            <td style="width: 195px; position: relative;">
                                <input accept="image/jpeg,image/png" required type="file" name="screen" id="image" class="form-control stub-for-path-file" style="top: 0;">
                                <i class="mdi mdi-folder bio-folder"></i>
                                <span id="path-to-file-bio">Upload img</span>
                            </td>
                            
                            <td class="nopadding">
                                <input class="request-bio-text" style="cursor: pointer" required type="text" name="text" id="i{{ $project->id }}" data-toggle="modal" data-target="#save_text_bio">
                            </td>
                            <td style="width: 100px;">
                                <button class="submit-request-bio" type="submit">Submit</button>
                            </td>
                            {{ csrf_field() }}
                        </form>
                    </tr>

                @endforeach
            </tbody>
        </table> 
        </div>
    </div>
    </div>

@endsection

@section('script')

    <script>

        $('input[name=text]').on('focus', function (e) {

            $(e.currentTarget)[0].blur();

            $('.bio_text').val($(e.currentTarget)[0].value);
            $('.bio_text').attr('id', $(e.currentTarget)[0].getAttribute('id'));

        });

        $('.save_bio_req').on('click', function (e) {

            var id = 'input#' + $('.bio_text').attr('id');
            $(id).val($('.bio_text').val());
            $('.bio_text').empty();
            $('.bio_text').val('');
            $('.bio_text').attr('id', '');

        });
        
        $('input[name=screen]').on('change', function (e) {
           $(e.target).parent().find('span').text(e.currentTarget.files[0].name);
       });

        /*$('input[type=file]').on('change', function (e) {

            $('#new_screen_name').text(e.currentTarget.files[0].name);

        });*/

    </script>

@endsection