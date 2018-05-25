@extends('layouts.dashboard_layout')

@section('name', 'Website Manager')

@section('button_navbar')

    @role('super_admin|admin')
        <button type="button" class="btn btn-success header-btn-add-new-website" data-toggle="modal" data-target="#newWebsite">Add New Website</button>
    @endrole

@endsection

@section('content')

    <link rel="stylesheet" href="{{ asset('css/website_manager_style.css') }}">

    <div class="col-md-12 search_bio">

        <form class="form-horizontal" action="{{ route('websites.search') }}" method="POST">
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

    @foreach($projects as $project)

        <div class="container_bios">

            <a href="{{ route('websites.show', $project->id) }}">
                <div class="thumbnail bio_manager_info_cont btn">
                    <div class="edit_bio_icon"></div>

                    <div class="screen_bio_info custom-photo-div" style="background-image: url(@if($project->bio) {{ asset('storage/bio_img/' . $project->bio()->first()->image) }} @else {{ asset('storage/bio_img/default.png') }} @endif);">
                        <div class="opasiti_own"></div>
                    </div>
                    <div class="caption">
                        <p id="url_bio_info">{{ $project->url }}</p>
                    </div>
                </div>
            </a>

        </div>

    @endforeach

    @include('admin.new_website_modal')

@endsection

@section('script')

    <script>

        $('.new_website_tab a[href="#la"]').tab('show');
        $('.new_website_tab a[href="#bio"]').tab('show');
        $('.new_website_tab a[href="#info"]').tab('show');

        $('#next_tab_bio').on('click', function (e) {

            e.preventDefault();

            $('.new_website_tab a[href="#bio"]').tab('show');

        });

        $('#next_tab_la').on('click', function (e) {

            e.preventDefault();

            $('.new_website_tab a[href="#la"]').tab('show');

        });

        $('input[name="placements"]').on('input', function (e) {
            var val_pl = $(this).val();
            var valid_str = '';
            for (var chr in val_pl){
                if(chr == 0){
                    if(Number(val_pl[chr]) > 0){
                        valid_str = valid_str + val_pl[chr];
                    }
                }else{
                    if(Number(val_pl[chr]) >= 0){
                        valid_str = valid_str + val_pl[chr];
                    }
                }
            }
            $(this).val(valid_str);

            var lay_main = $('#layout_anchors').clone();
            var lay_option = $('#no_placement option[value=0]').clone();
            $('.la_dinamic').empty();
            $('#no_placement').empty();
            $('.la_dinamic').append(lay_main);
            $('#no_placement').append(lay_option);

            for(var i = 0; i < Number($(this).val()); i++){
                var layout = $('#layout_anchors').clone();
                var option = $('#no_placement option[value=0]').clone();
                layout.attr('id', i+1);
                option.val(i+1);
                option.text(i+1);
                if(i+1 == 1){
                    layout.show();
                    $(option).attr('selected', true);
                }
                $('.la_dinamic').append(layout);
                $('#no_placement').append(option);
                option.show();
            }

        });

        $('#no_placement').change(function (e){

            var id_la = $(e.currentTarget.options[e.currentTarget.selectedIndex]).val();

            jQuery.each($('.la_cont'), function () {

                if($(this).attr('id') == id_la){
                    $(this).show();
                }else{
                    $(this).hide();
                }

            });

        });

        var pattern = '/[A-Za-z0-9-/_]*$';

        $('input[name="url"]').on('input', function (e) {

            jQuery.each($('input[name="link[]"]'), function () {
                $(this).attr('pattern', $(e.currentTarget).val() + pattern);
                $(this).val($(e.currentTarget).val() + '/');
            });

        });

        $('#new_website').on('submit', function (e) {

            if($('input[name="url"]').val() == ""){
                $('.new_website_tab a[href="#info"]').tab('show');
                $('.err_info').text('Invalid Website URL');
                $('.err_info').show();
                e.preventDefault();
            }else if($('select[name="company"] :selected').val() == ""){
                $('.new_website_tab a[href="#info"]').tab('show');
                $('.err_info').text('Field Company is Required');
                $('.err_info').show();
                e.preventDefault();
            }else if($('select[name="niche"] :selected').val() == ""){
                $('.new_website_tab a[href="#info"]').tab('show');
                $('.err_info').text('Field Niche is Required');
                $('.err_info').show();
                e.preventDefault();
            }else if($('input[name="placements"]').val() == "" || Number($('input[name="placements"]').val()) <= 0){
                $('.new_website_tab a[href="#info"]').tab('show');
                $('.err_info').text('Invalid Number of Placements');
                $('.err_info').show();
                e.preventDefault();
            }

        });
      
 
        $('input[name=image]').on('change', function (e) {

            $('#name_img_bio').text(e.currentTarget.files[0].name);

        });

    </script>

@endsection