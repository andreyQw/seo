@extends('layouts.dashboard_layout')

@section('name', 'Links & Anchor Manager')

@section('content')


   <!-- <link rel="stylesheet" href="{{ asset('css/link_anchor_style.css') }}">-->
    <link rel="stylesheet" href="{{ asset('css/client_link_anchor_style.css') }}">
    <div class="modal fade" id="confirm_link_modal" tabindex="1" role="dialog" aria-labelledby="link_modal_label" aria-hidden="true">
        <div class="modal-dialog anchor_modal_dialog">
            <div class="modal-content">
                <div class="modal-header anchor_modal_header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title anchor_modal_title" id="link_modal_label">Link & Anchor</h4>
                </div>
                <div class="modal-body anchor_modal_body" id="">

                    <div class="alert alert-danger" style="margin-left: 10px; margin-right: 10px;">
                        After confirming links & anchors, you can not change them only by contacting the support. Continue?
                    </div>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary continue">Continue</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="change_link_modal" tabindex="1" role="dialog" aria-labelledby="link_modal_label" aria-hidden="true">
        <div class="modal-dialog anchor_modal_dialog">
            <div class="modal-content">
                <div class="modal-header anchor_modal_header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title anchor_modal_title" id="link_modal_label">Link & Anchor</h4>
                </div>
                <div class="modal-body anchor_modal_body" id="">

                    <div class="alert alert-danger" style="margin-left: 10px; margin-right: 10px;">
                        Please contact support if you wish to change an anchor or target URL.
                    </div>

                </div>
            </div>
        </div>
    </div>

    <div class="col-md-12 col-xs-12 links_anchor_cont">

        <div>
            <div class="header_links_anchors">

                <span class="add_anchors_links">Add Websites</span>
                @if($need > 0)
                    <button class="btn btn-default confirm_links_anchor" type="submit" form="link_and_anchor_form"><span class="glyphicon glyphicon-plus-sign"></span>Confirmed</button>
                @else
                    <button class="btn btn-default change_links_anchor" type="submit" data-toggle="modal" data-target="#change_link_modal"><span class="glyphicon glyphicon-pencil"></span>Change</button>
                @endif

            </div>

            <div class="form_links_anchor col-md-12 nopadding-left nopadding-right">

                <form action="{{ route('link_confirm') }}" method="POST" id="link_and_anchor_form">

                    {{ csrf_field() }}

                    <div class="form-row websites_placements">

                        <div class="form-group col-lg-6 col-md-12 col-xs-12 first_links_form nopadding-left">

                            <label for="websites_select">Select a Website</label>

                            <select name="site" id="websites_select" class="form-control">
                                @foreach(Auth::user()->projects as $project)
                                    <option href="{{ url('link-anchor/' . $project->id) }}" value="{{ $project->id }}" @if($project->id == $select_id) selected @endif>
                                        {{ $project->url }}
                                    </option>
                                @endforeach
                            </select>

                        </div>
                        <div class="form-group col-lg-3 col-md-12 col-xs-12 last_links_form">

                            <label for="qu_placement">Number of Placements</label>

                            <input class="form-control" type="text" id="qu_placement" placeholder="{{ $quantity }}" disabled>

                        </div>

                    </div>

                    @if($need > 0)

                        @for($i = 0; $i < $need; $i++)

                            <div class="form-row link_and_anchor">

                                <div class="form-group col-lg-6 col-md-12 col-xs-12 first_links_form nopadding-left">

                                    <label for="anchor">Anchor Text*</label>

                                    <input type="text" required class="form-control" name="anchor[]" id="anchor">

                                </div>
                                <div class="form-group col-lg-6 col-md-12 col-xs-12 last_links_form nopadding-right">

                                    <label for="url">Target URL</label>

                                    <input type="text" required class="form-control" value="{{$domain}}@if(substr($domain, -1) != '/')/@endif" pattern="{{$domain}}@if(substr($domain, -1) != '/')/@endif[A-Za-z0-9-/_]*$" name="url[]" id="url">

                                </div>

                            </div>

                        @endfor

                    @endif
                    @if(!empty($anchors))

                        @foreach($anchors as $anchor)

                            <div class="form-row link_and_anchor">

                                <div class="form-group col-lg-6 col-md-12 col-xs-12 first_links_form nopadding-left">

                                    <label for="anchor">Anchor Text*</label>

                                    <input value="{{ $anchor->text }}" name="{{ $anchor->id }}" type="text" class="form-control" id="anchor" disabled>

                                </div>
                                <div class="form-group col-lg-6 col-md-12 col-xs-12 last_links_form nopadding-right">

                                    <label for="url">Target URL</label>

                                    <input value="{{ $anchor->url }}" name="{{ $anchor->id }}" type="text" class="form-control" id="url" disabled>

                                </div>

                            </div>

                        @endforeach

                    @endif

                </form>

            </div>
        </div>

    </div>

        <div class="row extra_info_cont">

            <div>
                <div class="header_links_anchors">

                    <span class="add_anchors_links">Extra information</span>

                </div>

                <div class="ei_cont">

                    <textarea id="ei" form="link_and_anchor_form" name="description" placeholder="Add extra information"></textarea>

                </div>
            </div>

        </div>

@endsection

@section('script')

    <script>

        $('#websites_select').on('change', function (e) {
            window.location.href = $(e.currentTarget.options[e.currentTarget.selectedIndex]).attr('href');
        });

        function warn (e) {
            e.preventDefault();

            $('#confirm_link_modal').modal('show');
        }

        $('#link_and_anchor_form').on('submit', warn);

        $('.continue').on('click', function (e) {
            $('#link_and_anchor_form').off('submit', warn);
            $('#confirm_link_modal').modal('hide');
            $('.continue').hide();
            $('#link_and_anchor_form').trigger('submit');

        })

        /*$('.change_links_anchor').on('click', function (e) {

            $('.links_and_anchor_change').empty();

            var anchors = document.body.querySelectorAll('#anchor');
            var urls = document.body.querySelectorAll('#url');

            for(var i = 0; i < anchors.length && i < urls.length; i++){

                console.log(anchors[i].value);
                console.log(urls[i].value);

                $('.links_and_anchor_change').prepend('<textarea name="anchors[' + anchors[i].getAttribute('name') + '][text]">' + anchors[i].value + '</textarea><input type="text" name="anchors[' + anchors[i].getAttribute('name') + '][url]" value="' + urls[i].value + '">');

            };

        });*/

    </script>

@endsection
