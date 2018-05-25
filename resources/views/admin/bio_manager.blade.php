@extends('layouts.dashboard_layout') @section('name', 'Bio Manager') @section('content')
    <link rel="stylesheet" href="{{ asset('css/bio_manager_style.css') }}">

<div class="col-md-12 search_bio">
    <form class="form-horizontal" action="{{ route('bio_search') }}" method="POST">
        {{ csrf_field() }}

        <div class="form-row search_bio_input">
            <div class="textsearch_user">Search Users</div>
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






<div class="row" id="main_cont_bios">
   
   
    <div class="modal fade" id="bio_modal" tabindex="1" role="dialog" aria-labelledby="bio_label" aria-hidden="true">
        <div class="modal-dialog bio_modal_dialog">
            <div class="modal-content">
                <div class="modal-header bio_modal_header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title bio_modal_title" id="bio_label">Bio</h4>
                    <hr class="bio_popup_line">
                </div>
                <div class="modal-body bio_modal_body" id="">

                    <form action="{{ route('bio_edit') }}" method="POST" enctype="multipart/form-data">
                        {{ csrf_field() }}

                        <div class="image_bio custom-photo-user" style="background-image: url();">
                            <div id="z_text">Upload File</div>
                            <input accept="image/jpeg,image/png" type="file" name="image" id="screen">
                           
                        </div>
                        <div class="info_bio">
                            <p id="bio_site_name"></p>
                            <p id="title_bio_info">Bio</p>
                            <p id="bio_write_info"></p>
                            <textarea name="text" id="text_bio"></textarea>
                            <a href="{{ route('bio_download') }}" class="btn btn-default download_bio"><span class="glyphicon glyphicon-save"></span>Download Bio</a>
                            <button class="btn btn-default save_new_bio" type="submit"><span class="glyphicon glyphicon-plus-sign"></span>Save</button>
                        </div>
                        <input type="hidden" name="id" value="">
                    </form>

                </div>
            </div>
        </div>
    </div>

    @foreach($bios as $bio)

    <div class="container_bios">
        <div class="thumbnail bio_manager_info_cont btn" id="{{ $bio->id }}" data-toggle="modal" data-target="#bio_modal" style="">
            <div class="screen_bio_info custom-photo-div" style="background-image: url({{asset('storage/bio_img/' . $bio->image) }})">
                <i class="mdi mdi-settings power edit_bio_icon"></i>
              <div class="opasiti_own"></div>
            </div>
            <div class="caption">
                <p id="url_bio_info">{{ $bio->project->url }}</p>
            </div>
        </div>

    </div>

    @endforeach

</div>

@endsection @section('script')

<script>
    $('.bio_manager_info_cont').on('click', function(e) {

        console.log(e);

        var id = $(e.currentTarget).attr('id');

        $.ajax({
            method: 'POST',
            url: '/bio/modal',
            data: {
                'id': id,
                '_token': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(data) {

                if ($(e.target).attr('class') == 'mdi mdi-settings power edit_bio_icon') {

                    $('#z_text').show();
                    $('#screen').show();
                    $('#text_bio').show();
                    $('#text_bio').val(data.text);
                    $('.save_new_bio').show();

                    $('#bio_write_info').hide();
                    $('.download_bio').hide();

                } else {

                    $('#bio_write_info').show();
                    $('#bio_write_info').html(data.text);
                    $('.download_bio').show();
                    $('.download_bio').attr('href', '/bio/download/' + data.id);

                    $('#z_text').hide();
                    $('#screen').hide();
                    $('#text_bio').hide();
                    $('.save_new_bio').hide();

                }

                $('.bio_modal_body').attr('id', data.id);
                
       $('.image_bio').css('backgroundImage', 'url(/storage/bio_img/' + data.img + ')');
                
                $('#bio_site_name').html(data.url);
                $('input[name=id]').val(data.id);

            },
            error: function(err) {
                console.log(err);
            }
        });

    });

    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function(e) {
                $('.image_bio img').attr('src', e.target.result);
            }

            reader.readAsDataURL(input.files[0]);
        }
    };

    $("#screen").change(function() {
        readURL(this);
    });

</script>

@endsection
