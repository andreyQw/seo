@extends('layouts.dashboard_layout')
@section('name', 'News Feed')

@section('content')
        
        
        <link rel="stylesheet" href="{{ asset('css/news_feed_style.css') }}">
        <link rel="stylesheet" href="{{ asset('css/preloader_style.css') }}">
         <div class="col-md-12 col-sm-12 col-xs-12 block_feed">
        <div class="block_feed_inside col-md-12 col-sm-12 col-xs-12">
            <div class="full_feed_block col-sm-12 col-sm-12 col-xs-12">

                @include('feed.events', ['dates' => $dates])

            </div>
        </div>

    </div>

    <div class="col-md-12 col-sm-12 col-xs-12" style="text-align: center; background-color: #fff;">
        <div class="loader" style="display: none;">
            <div class="circle"></div>
            <div class="circle"></div>
            <div class="circle"></div>
        </div>
    </div>
    
   @endsection

@section('script')

    <script>

        $(function(){

            var feed_count = {{ $count_feed }};

            $(window).on('scroll', function (e) {
                if($(window).scrollTop()+$(window).height()>=$(document).height()){

                    var date = $('.day_correspondence h3');
                    date = $(date[date.length - 1]).text();

                    var cont = $('.pid_help');
                    var pid = $(cont[cont.length - 1]).data('pid');
                    var count = $(cont[cont.length - 1]).data('count');

                    console.log(cont.length);

                    if(cont.length < feed_count){

                        $('.loader').show();

                        $.ajax({
                            method: 'POST',
                            url: '/feed/load',
                            data: {
                                '_token': $('meta[name="csrf-token"]').attr('content'),
                                'date': date,
                                'pid': pid,
                                'count': count,
                                'offset': cont.length
                            },
                            success: function (data) {
                                $('.loader').hide();
                                $('.full_feed_block').append(data);
                                $('.full_prod').click(function (e) {
                                    e.preventDefault();
                                    $($(e.target).parent()).hide();
                                    $($(e.target).attr('href')).show();
                                });
                            },
                            error: function (err) {
                                console.log(err);
                            }
                        });
                    }

                }
            });

            $('.full_prod').click(function (e) {
                e.preventDefault();
                $($(e.target).parent()).hide();
                $($(e.target).attr('href')).show();
            });


        });

    </script>

@endsection