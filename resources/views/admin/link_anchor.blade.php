@extends('layouts.dashboard_layout') @section('name', 'Link & Anchor Manager') @section('content')
    <link rel="stylesheet" href="{{ asset('css/link_anchor_style.css') }}">
  <!--  <link rel="stylesheet" href="{{ asset('css/bio_manager_style.css') }}">-->

<div class="col-md-12 search_bio">

    <form class="form-horizontal" action="{{ route('search_anchors') }}" method="POST">
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

<div class="row" id="main_cont_bios">
    <div class="modal fade" id="anchors_modal" tabindex="1" role="dialog" aria-labelledby="anchors_staff_label" aria-hidden="true">
        <div class="modal-dialog anchor_staff_modal_dialog">
            <div class="modal-content">
                <div class="modal-header anchors_staff_modal_header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title anchors_modal_title" id="bio_label">Link & Anchor</h4>
                    <hr class="popup_line_link_anchor">
                </div>
                
                <div class="modal-body anchors_modal_body" id="">
                    <div> <h4 class="modal-title anchors_modal_title" id="site_name">Websitename here</h4></div>
                    
                    <form action="{{ route('admin_edit_anchors') }}" method="POST">
                       {{--<p id="site_name"></p>--}}
                        {{ csrf_field() }}
                        <div class="links_and_anchor_info">

                        </div>
                        <button class="btn btn-default save_anchors" type="submit"><span class="glyphicon glyphicon-plus-sign"></span>Save</button>
                        <input type="hidden" name="id" value="">
                    </form>
                    <p class="desc_site"></p>

                </div>
            </div>
        </div>
    </div>

    @foreach($projects as $project)

    <div class="container_bios">
        <div class="thumbnail bio_manager_info_cont btn" id="{{ $project->id }}" @if(!$project->anchors->count()) style="border: 1px solid cyan;" @endif data-toggle="modal" data-target="#anchors_modal">
            <div class="edit_bio_icon"></div>

            <div class="screen_bio_info custom-photo-div" style="background-image: url(@if($project->bio) {{ asset('storage/bio_img/' . $project->bio()->first()->image) }} @else {{ asset('storage/bio_img/default.png') }} @endif);">
                <i class="mdi mdi-settings power edit_link_anchor_icon"></i>
                <!--<img src="@if($project->bio) {{ asset('storage/bio_img/' . $project->bio()->first()->image) }} @else {{ asset('storage/bio_img/default.png') }} @endif" class="screen_bio_info" alt="...">-->
                <div class="opasiti_own"></div>
            </div>        
            <div class="caption">
                <p id="url_bio_info">{{ $project->url }}</p>
            </div>
        </div>

    </div>

    @endforeach

</div>

@endsection @section('script')

<script>
    $('.bio_manager_info_cont').on('click', function(e) {

        var id = $(e.currentTarget).attr('id');

        $.ajax({
            method: 'POST',
            url: '/link-anchor/modal',
            data: {
                'id': id,
                '_token': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(data) {

                $('.links_and_anchor_info').empty();
                $('.desc_site').empty();
                $('.desc_site').text(data.project.description);

                if ($(e.target).attr('class') == 'mdi mdi-settings power edit_link_anchor_icon') {

                    $('.save_anchors').show();

                    if (data.project.anchors.length > 0) {
                        if (data.project.url[data.project.url.length - 1] !== '/') {
                            var url_data = data.project.url + '/';
                        } else {
                            var url_data = data.project.url;
                        }
                        data.project.anchors.forEach(function(i) {
                            $('.links_and_anchor_info').append('<textarea name="anchors[' + i.id + '][text]">' + i.text + '</textarea><input pattern="' + url_data + '[A-Za-z0-9-/_]*$" type="text" name="anchors[' + i.id + '][url]" value="' + i.url + '">');
                        });
                    } else {
                        $('.save_anchors').hide();
                        $('.links_and_anchor_info').append('<div class="alert alert-info">Links & Anchors not confirmed!</div>');
                    }

                } else {

                    $('.save_anchors').hide();

                    if (data.project.anchors.length > 0) {
                        data.project.anchors.forEach(function(i) {
                            $('.links_and_anchor_info').append('<p class="anchor_text">' + i.text + '</p><p class="link">' + i.url + '</p>');
                        });
                    } else {
                        $('.links_and_anchor_info').append('<div class="alert alert-info">Links & Anchors not confirmed!</div>');
                    }

                }

                console.log(data.project.anchors);

                $('.bio_modal_body').attr('id', data.project.id);
                $('#site_name').html(data.project.url);
                $('input[name=id]').val(data.project.id);

            },
            error: function(err) {
                console.log(err);
            }
        });

    });

</script>

@endsection
