@extends('layouts.dashboard_layout') @section('name', 'Sales Reporting') @section('content')

<link rel="stylesheet" href="{{ asset('css/sales_reporting_style.css') }}">
<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 sales_wrapper">
    <div class="col-lg-5 col-md-12 col-sm-12 col-xs-12 table-no-one-wrapper">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 table-no-one">
            <div class="header_table">

                <p>Top Clients By Spend <span>(All Time)</span></p>

            </div>
        <div class="table-cover">
            <table class="table table-bordered table-responsive table-striped">
                <thead>
                    <tr>

                        <th>Clients</th>
                        <th>Order Items</th>
                        <th>Spend</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($top_all as $order)

                    <tr>
                        <td>{{ $order->account->name }}</td>
                        <td>{{ $order->projects->first()->products->first()->title }}</td>
                        <td><span>$</span>{{ $order->amount }}</td>
                    </tr>

                    @endforeach
                </tbody>
            </table>
            </div>
        </div>
    </div>

    <div class="col-lg-7 col-md-12 col-sm-12 col-xs-12 key_performance">
        <div class="title_box" style="width: 100%;">
            <div class="header_table">
                <p>Key Performance</p>
                <hr>
            </div>
        </div>

        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="col-lg-4 col-md-4">
                <div class="wrapper-key-perfomance-cell">
                    <div class="img-cover"><img src="{{ asset('img/sales_reporting_sale.png') }}" alt=""></div>
                    <p>Sale</p>
                    <p>
                        @if(!empty($anal['sale']['trend']))
                            @if($anal['sale']['trend'] == '+')
                            <i class="mdi mdi-arrow-up-bold-circle" style="color: #00c974;"></i> @elseif($anal['sale']['trend'] == '-')
                            <i class="mdi mdi-arrow-down-bold-circle" style="color: #f25d35;"></i> @endif
                        @endif
                        {{ $anal['sale']['proc'] }}
                    </p>
                </div>
            </div>
            <div class="col-lg-4 col-md-4">
                <div class="wrapper-key-perfomance-cell">
                    <div class="img-cover"><img src="{{ asset('img/sales_reporting_total_amount.png') }}" alt=""></div>
                    <p>Total Amount in Sales</p>
                    <p>
                        @if(!empty($anal['sale']['trend']))
                            @if($anal['sale']['trend'] == '+')
                                <i class="mdi mdi-arrow-up-bold-circle" style="color: #00c974;"></i> @elseif($anal['sale']['trend'] == '-')
                                <i class="mdi mdi-arrow-down-bold-circle" style="color: #f25d35;"></i> @endif
                        @endif
                        ${{ $anal['amount'] }}
                    </p>
                </div>
            </div>
            <div class="col-lg-4 col-md-4">
                <div class="wrapper-key-perfomance-cell">
                    <div class="img-cover">
                        <img src="{{ asset('img/sales_reporting_total_orders.png') }}" alt=""></div>
                    <p>Total Orders for the Month</p>
                    <p>
                        @if(!empty($anal['orders']['trend']))
                            @if($anal['orders']['trend'] == '+')
                            <i class="mdi mdi-arrow-up-bold-circle" style="color: #00c974;"></i> @elseif($anal['orders']['trend'] == '-')
                            <i class="mdi mdi-arrow-down-bold-circle" style="color: #f25d35;"></i> @endif
                        @endif
                        {{ $anal['orders']['count'] }}
                    </p>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 table-cover-two-tree">
        <div class="col-lg-5 col-md-12 col-sm-12 col-xs-12">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 table-no-two">

                <div class="header_table">

                    <p>Top Clients By Spend <span> (This Month)</span></p>

                </div>
<div class="table-cover">
                <table class="table table-bordered table-responsive table-striped">
                    <thead>
                        <tr>
                            <th>Clients</th>
                            <th>Order Items</th>
                            <th>Spend</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($top_month as $order)

                        <tr>
                            <td>{{ $order->account->name }}</td>
                            <td>{{ $order->projects->first()->products->first()->title }}</td>
                            <td><span>$</span>{{ $order->amount }}</td>
                        </tr>

                        @endforeach
                    </tbody>
                </table>
</div>
            </div>

            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 table-no-tree">

                <div class="header_table">

                    <p>Last 5 Orders</p>

                </div>
<div class="table-cover">
                <table class="table table-bordered table-responsive table-striped">
                    <thead>
                        <tr>
                            <th>Clients</th>
                            <th>Items</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($last_order as $order)

                        <tr>
                            <td>{{ $order->account->name }}</td>
                            <td>{{ $order->projects->first()->products->first()->title }}</td>
                            <td><span>$</span>{{ $order->amount }}</td>
                        </tr>

                        @endforeach
                    </tbody>
                </table>
                </div>
            </div>
        </div>

        <div class="col-lg-7 col-md-12 col-sm-12 col-xs-12 sales-trend">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="height: 300px;">

                <div class="title_box">
                    <div class="header-sales-trend">

                        <p>Sales Trend</p>
                        
                        <div id="reportrange" class="pull-right">
                        <span></span> <b class="caret"></b>
                    </div>
                    </div>
                    {{--
                    <select name="trade_day" id="">
                            <option value="t">Today</option>
                            <option value="y">Yesterday</option>
                            <option selected value="7">Last 7 days</option>
                            <option value="tm">This Month</option>
                            <option value="lm">Last Month</option>
                            <option value="30">Last 30 days</option>
                        </select>--}}
                    
                </div>
                <div class="cover-canvas">
                <canvas id="myChart" height="180" width="800" {{--style="width: 100%; height: 200px;" --}}></canvas>
                </div>

            </div>

            <!--/*-*/-->
        </div>
    </div>
</div>

@endsection @section('script')

<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.4.0/Chart.min.js"></script>
<script type="text/javascript" src="//cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.js"></script>
<link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.css" />

<script type="text/javascript">
    $(function() {

        var el = document.getElementById("myChart"),
            ctx = el.getContext('2d');

        var grad = ctx.createLinearGradient(50, el.height, 50, 0);
        grad.addColorStop(1, 'rgba(0,201,116,1)');
        grad.addColorStop(0, 'rgba(255,255,255,0.3)');

        var data_chart = {
            type: 'line',
            data: {
                labels: [
                    @foreach($data_chart['labels'] as $label)
                    "{{ $label }}",
                    @endforeach
                ],
                datasets: [{
                    label: "",
                    backgroundColor: grad,
                    borderColor: 'rgba(0,201,116,1)',
                    width: 200,
                    height: 200,
                    data: [
                        @foreach($data_chart['data'] as $label)
                        "{{ $label }}",
                        @endforeach
                    ],
                    pointBackgroundColor: "rgba(0,201,116,1)",
                    pointHoverBackgroundColor: "rgb(242,93,53)",
                    pointBorderWidth: 0,
                    pointHoverBorderWidth: 0,
                    pointRadius: 5,
                    pointHoverRadius: 5,
                    pointHoverBorderColor: "rgb(242,93,53)",
                }]
            },
            options: {
                legend: {
                    display: false
                },
                title: {
                    display: false,
                },
                tooltips: {
                    backgroundColor: 'rgba(242,93,53,1)',
                    legend: false,
                    displayColors: false,
                    footerFontSize: 1,
                    footerMarginTop: 2,
                    titleFontSize: 1,
                    titleMarginBottom: 2,
                    callbacks: {
                        label: function (t, d) {
                            return String(t.yLabel);
                        },
                        title: function () {
                            return '     ';
                        },
                        footer: function () {
                            return '     ';
                        }
                    }
                },
                responsive: false,
                maintainAspectRatio: false,
                scales: {
                    yAxes: [{
                        ticks: {
                            min: 0,
                            max: 1500,
                            stepSize: 500,
                        }
                    }]
                }
            }
        };

        var chart = new Chart(ctx, data_chart);

        var start = moment().subtract(6, 'days');
        var end = moment();

        function cb(start, end) {
            $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
            console.log(start);
        }

        $('#reportrange').daterangepicker({
            startDate: start,
            endDate: end,
            maxDate: moment(),
            ranges: {
                'Today': [moment(), moment()],
                'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                'This Month': [moment().startOf('month'), moment().endOf('month')],
                'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
            }
        }, cb);

        cb(start, end);

        $('#reportrange').on('apply.daterangepicker', function(ev, picker) {
            console.log(picker.startDate.format('YYYY-MM-DD'));
            console.log(picker.endDate.format('YYYY-MM-DD'));

            $.ajax({
                method: 'POST',
                url: '/sales/chart',
                data: {
                    '_token': $('meta[name="csrf-token"]').attr('content'),
                    'date': {
                        'start': picker.startDate.format('YYYY-MM-DD'),
                        'end': picker.endDate.format('YYYY-MM-DD')
                    }
                },
                success: function(data) {

                    if (data.error) {
                        console.log(data.error);
                    } else {

                        chart.data.labels = data.labels;

                        chart.data.datasets[0].data.splice(0, chart.data.datasets[0].data.length);

                        chart.data.datasets.forEach(function(dataset) {
                            for (var i = 0; i < data.data.length; i++) {
                                dataset.data.push(data.data[i]);
                            }
                        });

                        chart.update();

                        console.log(data_chart);

                    }

                },
                error: function(err) {
                    console.log(err);
                }
            });
        });

        /*$('select[name=trade_day]').on('change', function (e) {

            var date_trade = $('select[name=trade_day] :selected').val();

            $.ajax({
                method: 'POST',
                url: '/sales/chart',
                data: {
                    '_token': $('meta[name="csrf-token"]').attr('content'),
                    'date': date_trade
                },
                success: function (data) {

                    if(data.error){
                        console.log(data.error);
                    }else{

                        chart.data.labels = data.labels;

                        chart.data.datasets[0].data.splice(0, chart.data.datasets[0].data.length);

                        chart.data.datasets.forEach(function (dataset) {
                            for (var i = 0; i < data.data.length; i++){
                                dataset.data.push(data.data[i]);
                            }
                        });

                        chart.update();

                        console.log(data_chart);

                    }

                },
                error: function (err) {
                    console.log(err);
                }
            });

        });*/

    });

</script>

@endsection
