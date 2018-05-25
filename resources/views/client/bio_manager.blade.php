@extends('layouts.dashboard_layout') @section('name', 'Bio Manager') @section('content')

<link rel="stylesheet" href="{{ asset('css/bio_manager_style.css') }}">

 @if(!empty($projects))

<div class="row bio_cont">

    <!--Button-ADD-NEW-WEBSITE-->
   
    <div>

        <!--/*******/-->
      
        </div>

        <!--/*************/-->
        <div class="header_bio">
            <span class="add_bio">Add Websites</span>
            <button class="btn btn-default confirm_bio" type="submit" form="bio_form"><span class="glyphicon glyphicon-plus-sign"></span>Confirmed</button>
        </div>

        <div class="form_bio">

            @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            <form action="{{ route('bio_confirm') }}" method="POST" id="bio_form" enctype="multipart/form-data">

                {{ csrf_field() }}

                <div class="form-row websites_placements">

                    <div class="form-group col-md-5 first_links_form">

                        <div class="form-row">
                            <div class="form-group col-md-7" style="padding-left: 0; padding-right: 8px; margin-bottom: 21px;">
                                <label for="website_select">Website Name</label>
                                <select name="site" id="website_select" class="form-control">
												@foreach($projects as $project)
													<option value="{{ $project->id }}">{{ $project->url }}</option>
												@endforeach
											</select>
                            </div>
                            <div class="form-group col-md-5" style="padding-left: 15px; padding-right: 10px; margin-bottom: 21px;">
                                {{--<input type="text" class="form-control" id="inform_nobs">--}}
                                <button class="btn btn-default btn-block" id="inform_nobs">Inform NO BS to do the bio</button>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-12" style="padding-left: 0; padding-right: 10px;">
                                <label for="load_bio_screen" id="label_load_screen">
												Upload Image

											</label>
                                <div class="cont_load">
                                    <span id="new_screen_name"></span>
                                    <button class="btn btn-default" id="upload_new"><span class="glyphicon glyphicon-open"></span>Upload New</button>
                                    <input required type="file" name="screen" accept="image/jpeg,image/png" class="form-control" id="load_bio_screen">
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="form-group col-md-7 last_links_form" style="padding-left: 35px; padding-right: 35px;">

                        <label for="bio_write" class="label_bio_write">Write Bio</label>

                        <textarea required name="bio_write" id="bio_write" class="form-control"></textarea>

                    </div>

                </div>

            </form>

        </div>
    </div>




@endif @if(!empty($confirmed))

<div class="modal fade" id="bio_modal" tabindex="1" role="dialog" aria-labelledby="bio_label" aria-hidden="true">
    <div class="modal-dialog bio_modal_dialog">
        <div class="modal-content">
            <div class="modal-header bio_modal_header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title bio_modal_title" id="bio_label">Bio</h4>
            </div>
            <div class="modal-body bio_modal_body" id="">

                <form action="{{ route('bio_edit') }}" method="POST" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <div class="image_bio custom-photo-div">
                    </div>
                    <div class="info_bio">
                        <p id="bio_site_name"></p>
                        <p id="title_bio_info">Bio</p>
                        <p id="bio_write_info"></p>
                    </div>
                    <input type="hidden" name="id" value="">
                </form>

            </div>
        </div>
    </div>
</div>

<div class="row confirmed_bio_cont">

    @foreach($confirmed as $confirm)

    <div class="col-md-3 col-sm-6 col-xs-6">

        <div class="btn bio_client_contact" id="{{ $confirm->bio->id }}" data-toggle="modal" data-target="#bio_modal">
            <div class="bio_manager_info_cont custom-photo-div" style="background-image: url({{ asset('storage/bio_img/' . $confirm->bio->image) }})"></div>
            <!--<img src="{{ asset('storage/bio_img/' . $confirm->bio->image) }}" class="screen_bio_info" alt="...">
						<div class="caption" style="position: relative;">-->
            <p id="url_bio_info">{{ $confirm->url }}</p>
        </div>
    </div>



    @endforeach
</div>

@endif @endsection @section('script')

<script>
    $('#label_load_screen').on('click', function(e) {
        e.preventDefault();
    });
    $('#upload_new').on('click', function(e) {
        e.preventDefault();
    });

    $('input[type=file]').on('change', function(e) {

        $('#new_screen_name').text(e.currentTarget.files[0].name);

    });

    $('#inform_nobs').on('click', function(e) {

        e.preventDefault();

        var site_id = $('#website_select :selected').val();

        console.log(site_id);

        $.ajax({
            method: 'POST',
            url: 'bio/help',
            data: {
                id: site_id,
                '_token': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(data) {
                location.reload();
            },
            error: function(err) {
                console.log(err);
            }
        })

    });

    $('.bio_client_contact').on('click', function(e) {

        var id = $(e.currentTarget).attr('id');
console.log(id);
        $.ajax({
            method: 'POST',
            url: '/bio/modal',
            data: {
                'id': id,
                '_token': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(data) {

                $('#bio_write_info').show();
                $('#bio_write_info').html(data.text);

                $('#z_text').hide();
                $('#screen').hide();
                $('#text_bio').hide();
                $('.save_new_bio').hide();

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

    function submit_form(e) {
        $('.confirm_bio').attr('form', '');
    }

    $('#bio_form').on('submit', submit_form);

</script>

@endsection
