@extends('layouts.dashboard_layout')
@section('name', 'Client Dashboard')
@section('content')

 <link rel="stylesheet" href="{{ asset('css/client_dasboard_style.css') }}">
 <link rel="stylesheet" href="{{ asset('css/news_feed_style.css') }}">
 <link rel="stylesheet" href="{{ asset('css/preloader_style.css') }}">

<div class="col-xs-12 col-md-12">
    <div class="block_order_overview col-md-8">
        <div class="block_order_overview_inside col-md-12">
            <h3 id="order">Order Overview</h3>
            <hr>
            <div class="row row_first">
                <div class="cell col-lg-offset-3 col-lg-3 col-md col-md-6 col-xs-6">
                    <div class="cell_first">
                        <img src="{{ asset('img/placements_ordered.png') }}" alt="">
                        <p>Placements Ordered</p>
                        <h4>{{ $anal['ordered'] }}</h4>
                    </div>
                </div>
                <div class="cell col-lg-3 col-md-6 col-xs-6">
                    <div class="cell_second">
                        <img src="{{ asset('img/live_placements.png') }}" alt="">
                        <p>Live Placements</p>
                        <h4>{{ $anal['live'] }}</h4>
                    </div>
                </div>
            </div>
            <div class="row row_second">
                <div class="cell col-lg-2 col-md-6 col-xs-6">
                    <div class="cell_last">
                        <img src="{{ asset('img/quality_control.png') }}" alt="">
                        <p>Quality Control</p>
                        <h4>{{ $anal['qc'] }}</h4>
                    </div>
                </div>
                <div class="cell col-lg-2 col-md-6 col-xs-6">
                    <div class="cell_last">
                        <img src="{{ asset('img/writing_content.png') }}" alt="">
                        <p>Writing Content</p>
                        <h4>{{ $anal['wc'] }}</h4>
                    </div>
                </div>
                <div class="cell col-lg-2 col-md-6 col-xs-6">
                    <div class="cell_last">
                        <img src="{{ asset('img/editorial.png') }}" alt="">
                        <p>Editorial</p>
                        <h4>{{ $anal['e'] }}</h4>
                    </div>
                </div>
                <div class="cell col-lg-2 col-md-6 col-xs-6">
                    <div class="cell_last">
                        <img src="{{ asset('img/personalization.png') }}" alt="">
                        <p>Personalization</p>
                        <h4>{{ $anal['p'] }}</h4>
                    </div>
                </div>
                <div class="cell col-lg-2 col-md-6 col-xs-12">
                    <div class="cell_last">
                        <img src="{{ asset('img/writing_on_site.png') }}" alt="">
                        <p>Waiting On Site</p>
                        <h4>{{ $anal['waiting'] }}</h4>

                    </div>
                </div>

            </div>
        </div>
    </div>



    <div class="col-md-4 inside_block_wesites">
        <div class="block_websites">
            <h3 id="order">Websites</h3>
            <hr>
            <div id="myCarousel" class="carousel slide" data-ride="carousel" data-interval="false">
                <!-- Wrapper for slides -->
                <div class="carousel-inner">
                    @foreach(Auth::user()->projects as $project)

                         @if($loop->first || $loop->index%6 == 0)
                            <div class="item @if($loop->first) active @endif">
                         @endif

                            @if($loop->iteration%2 != 0)
                                <div class="block_for_website">
                            @endif
                                    <a href="{{ route('client.web', $project->id) }}">
                                        <div class="@if($loop->iteration%2 != 0)first_web_block @else second_web_block @endif">
                                            @if($project->bio)
                                                <div class="img" style="background-image: url({{ asset('storage/bio_img/' . $project->bio->image) }});"></div>
                                            @else
                                                <div class="img" style="background-image: url({{ asset('storage/bio_img/default.png') }});"></div>
                                            @endif
                                            <p>{{ $project->url }}</p>
                                        </div>
                                    </a>
                            @if($loop->last || $loop->iteration%2 == 0)
                                </div>
                            @endif


                        @if(($loop->index != 0 && $loop->iteration%6 == 0) || $loop->last)
                            </div>
                        @endif

                    @endforeach

                    <a href="#myCarousel" data-slide="prev">
                             <span class="arrow-left"><i class="mdi mdi-arrow-left"></i></span>
                          </a>
                    <a href="#myCarousel" data-slide="next">
                            <span class="arrow-right"><i class="mdi mdi-arrow-right"></i></span>
                        </a>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-8 block_invoices">
        <div class="block_invoices_inside col-md-12">
            <h3 id="order" style="display: block; padding-top: 10px;">Invoices</h3>

            <span style="display: inline-block; float: right;">{{ $orders->render() }}</span>
            <div class="wrapper-table-mm ">


        <table class="table table-bordered table-striped table-mm">
            <thead>
                <tr>
                    <th scope="col">Invoice No</th>
                    <th scope="col">Orders</th>
                    <th scope="col">Purchased</th>
                    <th scope="col">Date</th>
                    <th scope="col">Total</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($orders as $order)

                    <tr>
                        <td scope="row">{{ str_pad(strval($order->invoice->id), 5, '0', STR_PAD_LEFT) }}</td>
                        <td> #{{ $order->id }} <br> By {{ $order->user->first_name }} {{ $order->user->last_name }} <a href="">{{ $order->user->email }}</a></td>
                        <td>{{ $order->products->sum('pivot.quantity') }} items</td>
                        <td>{{ (new \DateTime($order->created_at))->format('M j, Y') }}</td>
                        <td>${{ $order->amount }}</td>
                        <td> <a href="{{ route('invoice.look', $order->invoice->id) }}"><img src="{{ asset('img/eye_dash_client.png') }}" alt=""></a>
                            <a href="{{ route('invoice.download', $order->invoice->id) }}"><img src="{{ asset('img/pdf_dash_client.png') }}" alt=""></a></td>
                    </tr>

                @endforeach
            </tbody>
        </table>
        </div>
    </div>
    </div>

    <div class="col-md-12 block_feed">
        <div class="block_feed_inside col-md-12">
            <h3 id="order">Feed</h3>
            <div class="full_feed_block">

                <div class="col-md-12 event_feed" {{--style="height: 100%;"--}}>
                    @include('feed.events', ['dates' => $dates])
                </div>

            </div>

            <div class="loader" style="display: block; margin: 0 auto;">
                <div class="circle"></div>
                <div class="circle"></div>
                <div class="circle"></div>
            </div>
        </div>
    </div>
</div>

@endsection
@section('script')
    {{--<script src="{{asset('js/jquery-datatables-editable/jquery.dataTables.js')}}"></script>--}}

    <script>

        $(document).ready(function(){

            $('.loader').hide();

            $('#myCarousel').carousel('pause');

            var feed_count = {{ $count_feed }};

            $('.full_feed_block').on('scroll', function (e) {
                if($('.full_feed_block').scrollTop() + $('.full_feed_block').height()>=document.querySelector('.full_feed_block').scrollHeight){

                    console.log(document.querySelector('.full_feed_block').clientWidth);
                    console.log(document.querySelector('.full_feed_block').offsetWidth);

                    var date = $('.day_correspondence h3');
                    date = $(date[date.length - 1]).text();

                    var cont = $('.pid_help');
                    var pid = $(cont[cont.length - 1]).data('pid');
                    var count = $(cont[cont.length - 1]).data('count');

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
                                $('.event_feed').append(data);
                                $('.full_prod').click(function (e) {
                                    e.preventDefault();
                                    $($(e.target).attr('href')).show();
                                    $($(e.target).parent()).hide();
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
                $($(e.target).attr('href')).show();
                $($(e.target).parent()).hide();
            });

        });

        {{--$(document).ready(function() {--}}
            {{--$('.table').DataTable();--}}
        {{--});--}}
    </script>
@endsection
