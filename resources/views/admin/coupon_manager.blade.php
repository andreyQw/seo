@extends('layouts.dashboard_layout')

@section('name', 'Coupons Manager')

@section('content')

    <link rel="stylesheet" href="{{ asset('css/coupon_style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/chosen.css') }}">

    @include('admin.coupon_manager_modal')

    <div class="row all_info_sales">            
            <div class="header_sales">
                <span class="header_name_box">Overview</span>
                <button class="btn btn-default create_coupon_btn" data-toggle="modal" data-target="#create_campaing"><span class="glyphicon glyphicon-plus-sign"></span>Create Campaign</button>
            </div>

            <div class="col-sm-12 top_block">
                <div class=" col-md-3 col-sm-6">
                  <div class="top-block-content">
                  <div class="wrapper-for-img-top-block">
                   <img src="{{ asset('img/total_revenue.png') }}" alt="">
                   </div>
                    <span class="name_data_discount">Total Revenue</span>
                    <h4 class="data_discount">${{ number_format($data['revenue'], 2) }}</h4>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                  <div class="top-block-content">
                  <div class="wrapper-for-img-top-block">
                   <img src="{{ asset('img/total_discount.png') }}" alt="">
                      </div>
                    <span class="name_data_discount">Total Discount</span>
                    <h4 class="data_discount">${{ number_format($data['discount'], 2) }}</h4>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                  <div class="top-block-content">
                  <div class="wrapper-for-img-top-block">
                   <img src="{{ asset('img/number_of_coupons_used.png') }}" alt="">
                      </div>
                    <span class="name_data_discount">Number Of Coupons Used</span>
                    <h4 class="data_discount">{{ $data['coupon'] }}</h4>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                  <div class="top-block-content">
                  <div class="wrapper-for-img-top-block">
                   <img src="{{ asset('img/number_of_placements_ordered.png') }}" alt="">
                      </div>
                    <span class="name_data_discount">Number Of Placements Ordered</span>
                    <h4 class="data_discount">{{ $data['placements'] }}</h4>
                    </div>
                </div>
            </div>
    </div>

    <div class="row all_campaigns">
        <div>

            <div class="header_campaigns"><span class="name_header_campaigns">All Campaigns</span></div>

            <div class="row search_coupon_cont">
                <form action="{{ route('coupon.search') }}" method="POST">
                    {{ csrf_field() }}
                    <div class="form-row">
                        <div class="col-md-4 form-group">
                            <input type="text" class="form-control" name="search" placeholder="Search By Campaign Name">
                        </div>
                        <div class="col-md-4 form-group">
                            <select name="status" id="" class="form-control">
                                <option value="-1" selected>All Status</option>
                                <option value="0">Off</option>
                                <option value="1">On</option>
                            </select>
                        </div>
                        <div class="col-md-4 form-group">
                            <div class="row">
                                <div class="col-md-6 col-xs-6">
                                    <button class="btn btn-default search_campaign" type="submit">Search</button>
                                </div>
                                <div class="col-md-6 col-xs-6">
                                    <button class="btn btn-default reset_search_campaign" type="reset">Clear</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <div class="col-md-12 table_coupons">
                <table class="table table-striped table-bordered table-responsive coupon-table">
                    <thead>
                        <tr>
                            <th>Campaign</th>
                            <th>Usage</th>
                            <th>Expiration</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(count($coupons))
                            @foreach($coupons as $coupon)

                                <tr>
                                    <td>{{ $coupon->name }} <span>{{ $coupon->amount }}{{ $coupon->discount->as }} off</span></td>
                                    <td>
                                        @if($coupon->usage_coupon == 0)
                                            No set
                                        @else
                                            <progress class="progress" value="{{ $coupon->orders->count() }}" max="{{ $coupon->usage_coupon }}" aria-describedby="progress"></progress>
                                            <div class="text-md-center" id="progress">{{ $coupon->orders->count() }} of {{ $coupon->usage_coupon }} campaining</div>
                                        @endif
                                    </td>
                                    <td>
                                        @if($coupon->expiry_date)
                                            {{ $coupon->expiry_date }}
                                        @else
                                            No set
                                        @endif
                                    </td>
                                    <td>
                                        <label class="switch">
                                            <input id="{{ $coupon->id }}"
                                                   class="switch_camp"
                                                   type="checkbox"
                                                   name="status"
                                                   @if ($coupon->status == 1)
                                                   checked
                                                    @endif>
                                            <span class="slider round"></span>
                                        </label>
                                    </td>
                                    <td id="{{ $coupon->id }}">
                                        <form action="{{ route('coupon.destroy', $coupon) }}" method="POST" class="delete_campaign">
                                            {{ csrf_field() }}
                                            {{ method_field('DELETE') }}
                                            <a href="#" onclick="this.parentNode.submit(); return false;">
                                                <span class="delete_coupon" style="color: #f15d34;">
                                                     <img src="{{ asset('img/action_trash_can.png') }}" alt="">
                                                </span>
                                                
                                            </a>
                                        </form>
                                        &nbsp&nbsp
                                        <span onclick="
                                                        show_modal_edit(event, {{ json_encode($coupon) }}, {{ json_encode($coupon->products) }}, {{ json_encode($coupon->discount) }});
                                        " class="edit_campaign" style="color: #00c973;"> <img src="{{ asset('img/action_pen.png') }}" alt=""></span>
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>

        </div>
    </div>

@endsection

@section('script')

    <script src="{{ asset('js/chosen.jquery.js') }}"></script>
    <script src="{{ asset('js/chosen.proto.js') }}"></script>
    <script src="{{ asset('js/chosen.jquery.min.js') }}"></script>
    <script src="{{ asset('js/chosen.proto.min.js') }}"></script>

    <script>

        function clear_data() {

            var fields = $('.create_camp_fields');
            jQuery.each(fields, function () {

                if(this.tagName == 'SELECT'){
                    for (var i = 0; i < this.options.length; i++){
                        this.options[i].selected = false;
                    }
                    $('#exclude_products').trigger('chosen:updated');
                    $('#product').trigger('chosen:updated');
                    $('#exclude_categories').trigger('chosen:updated');
                    $('#categories').trigger('chosen:updated');
                    return;
                }

                if(this.getAttribute('type') == 'checkbox'){
                    this.checked = false;
                    return;
                }

                this.value = '';

            });

            $('#create_campaign').attr('action', '/coupon/coupon/');
            $('input[name=_method]').detach();

        };

        $('.create_coupon_btn').on('click', function (e) {
            clear_data();
        });

        function show_modal_edit (e, c, p, d) {

            clear_data();
            
            var fields = $('.create_camp_fields');
            jQuery.each(fields, function () {

                if(this.tagName == 'SELECT'){
                    /*console.log(this);*/
                    if(this.getAttribute('name') == 'product[]'){

                        if(p.length > 0){
                            for (var i = 0; i < p.length; i++){
                                $('#product option[value=' + p[i].id + ']').prop('selected', true);
                            }
                            $('#product').trigger('chosen:updated');
                        }
                        return;

                    }

                    if(this.getAttribute('name') == 'discount_id'){
                        $('#discount option[value=' + d.id + ']').prop('selected', true).trigger('change');
                        return;
                    }
                }

                if(this.getAttribute('type') == 'checkbox'){
                    if(this.getAttribute('name') == 'sale_items'){
                        if (!c[this.getAttribute('name')]) {
                            this.checked = true;
                            return;
                        }else{
                            return;
                        } 
                    }

                    if(c[this.getAttribute('name')]){
                        this.checked = true;
                    }
                    return;
                }

                if(c[this.getAttribute('name')]){
                    this.value = c[this.getAttribute('name')];
                }

                console.log(this.tagName);

            });

            $('#create_campaign').attr('action', '/coupon/coupon/' + c.id);
            $('#create_campaign').append('<input type="hidden" name="_method" value="PUT">');

            $('#create_campaing').modal('show');

        };

        $('.switch_camp').on('change', function (e) {
            console.log(e.currentTarget.checked);
            $.ajax({
                url: '/coupon/status-change/' + e.currentTarget.getAttribute('id'),
                method: 'POST',
                data: {
                    '_token': $('meta[name="csrf-token"]').attr('content'),
                    'status': e.currentTarget.checked
                },
                success: function (data) {
                    console.log(data);
                },
                error: function (err) {
                    console.log(err);
                }
            });
        });

        $('#discount').on('change', function (e) {
            console.log(e);
            $('#amount').attr('placeholder', e.currentTarget.options[e.currentTarget.selectedIndex].attributes.as.value);
            if(e.currentTarget.options[e.currentTarget.selectedIndex].attributes.as.value == '%'){
                $('#amount').attr('max', 100);
            }else{
                $('#amount').attr('max', '');
            }
        });

        /* --- SELECT PRODUCTS & CATS --- */

        $('#product').chosen({
            no_results_text: "Oops, nothing found product!",
            width: '100%'
        });
        $('#exclude_products').chosen({
            no_results_text: "Oops, nothing found product",
            width: '100%'
        });
        $('#categories').chosen({
            no_results_text: "Oops, nothing found category",
            width: '100%'
        });
        $('#exclude_categories').chosen({
            no_results_text: "Oops, nothing found category",
            width: '100%'
        });

        $('#product').chosen().change(function (e, param) {
            if(param.selected){
                var val = $('#product').children().eq(Number(param.selected) - 1).val();
                $('#exclude_products option[value=' + val + ']').prop('selected', false);
                $('#exclude_products').trigger('chosen:updated');
            }
        });
        $('#exclude_products').chosen().change(function (e, param) {
            if(param.selected){
                var val = $('#exclude_products').children().eq(Number(param.selected) - 1).val();
                $('#product option[value=' + val + ']').prop('selected', false);
                $('#product').trigger('chosen:updated');
            }
        });

        $('#categories').chosen().change(function (e, param) {
            if(param.selected){
                var val = $('#categories').children().eq(Number(param.selected) - 1).val();
                $('#exclude_categories option[value=' + val + ']').prop('selected', false);
                $('#exclude_categories').trigger('chosen:updated');
            }
        });
        $('#exclude_categories').chosen().change(function (e, param) {
            if(param.selected){
                var val = $('#exclude_categories').children().eq(Number(param.selected) - 1).val();
                $('#categories option[value=' + val + ']').prop('selected', false);
                $('#categories').trigger('chosen:updated');
            }
        });

        /* --- END SELECT PRODUCTS & CATS --- */

        /*$('#usage_user').on('change', function (e) {
            if(Number(e.currentTarget.value) <= 0){
                e.currentTarget.value = '';
            }
        });
        $('#usage_coupon').on('change', function (e) {
            if(Number(e.currentTarget.value) <= 0){
                e.currentTarget.value = '';
            }
        });
        $('#max_spend').on('change', function (e) {
            if(Number(e.currentTarget.value) <= 0){
                e.currentTarget.value = '';
            }
        });
        $('#min_spend').on('change', function (e) {
            if(Number(e.currentTarget.value) <= 0){
                e.currentTarget.value = '';
            }
        });*/

        $('input[name=max_spend]').on('input', function (e) {
            if(Number($(e.currentTarget).val()) <= 0 || isNaN(Number($(e.currentTarget).val()))) {
                $(e.currentTarget).val($(e.currentTarget).val().substring(0, $(e.currentTarget).val().length - 1));
            }
        });
        $('input[name=min_spend]').on('input', function (e) {
            if(Number($(e.currentTarget).val()) <= 0 || isNaN(Number($(e.currentTarget).val()))) {
                $(e.currentTarget).val($(e.currentTarget).val().substring(0, $(e.currentTarget).val().length - 1));
            }
        });
        $('input[name=usage_coupon]').on('input', function (e) {
            if(Number($(e.currentTarget).val()) <= 0 || isNaN(Number($(e.currentTarget).val()))) {
                $(e.currentTarget).val($(e.currentTarget).val().substring(0, $(e.currentTarget).val().length - 1));
            }
        });
        $('input[name=usage_user]').on('input', function (e) {
            if(Number($(e.currentTarget).val()) <= 0 || isNaN(Number($(e.currentTarget).val()))) {
                $(e.currentTarget).val($(e.currentTarget).val().substring(0, $(e.currentTarget).val().length - 1));
            }
        });

        $('.campaign_tab a[href="#limit"]').tab('show');
        $('.campaign_tab a[href="#restrict"]').tab('show');
        $('.campaign_tab a[href="#general"]').tab('show');

    </script>

@endsection