@extends('layouts.checkOutFormLayout') @section('content')
<div class="container">
    <div class="row">
        @if($message = \Session::get('success'))
            <div>{{ $message }}</div>
            <?php \Session::forget('success');?>
        @endif
        @if ($message = \Session::get('error'))
            <div class="custom-alerts alert alert-danger">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                {{$message}}
            </div>
        @endif
        <form method="POST" action="{{ route('addPayStripe', $order) }}" enctype="multipart/form-data" id="payment-form">
            {{ csrf_field() }} {{--@if($errors->count() > 0)--}} {{--
            <p>The following errors have occurred:</p>--}} {{--
$order = \Session::get('order');
            <ul>--}} {{--@foreach($errors->all() as $message)--}} {{--
                <li>{{$message}}</li>--}} {{--@endforeach--}} {{--
            </ul>--}} {{--@endif--}}
            <div class="col-md-4 col-lg-4">
                <h5 class="yor-cart summary">Summary</h5>
                <div class="md-sum">

                    <div class="row row15">
                        {{--<div class="form-group col-lg-12 col-md-12 indentation enter_code">--}}
                            {{--<div class="col-lg-6 col-md-6 indentation">--}}
                                {{--<input id="coupon" type="text" class="form-control input-lg" name="coupon" value="" placeholder="Enter Code">--}}
                            {{--</div>--}}
                            {{--<div class="col-lg-6 col-md-6 indentation btn_enter">--}}
                                {{--<button id="btn-my" type="button" class="btn btn-primary btn-lg">APPLY COUPON</button>--}}
                            {{--</div>--}}

                        {{--</div>--}}


                        <div class="row">
                            <div class="col-lg-8 col-md-8 lft">
                                <h2 class="prod-total">Product</h2>
                            </div>
                            <div class="col-lg-4 col-md-4">
                                <h2 class="prod-total">Total</h2>
                            </div>
                        </div>
                        <hr id="linefirst">
                        <div class="row row_for_insert">
                            <div class="col-lg-12 col-md-12">

                                @foreach($order->projects as $project) @foreach ($project->products as $product)
                                <p>
                                    <span class="product-sum-name">{{$product->title}}</span>
                                    <span class="span-calc">х</span>
                                    <span class="span-calc-qty">{{$product->pivot->quantity}}</span>
                                    <span class="rght">USD $
                                        <span class="span-calc-total">{{$product->price * $product->pivot->quantity}}</span>
                                    </span>
                                </p>
                                @endforeach @endforeach

                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-12 col-md-12">
                                <p>
                                    {{--<input id="web_price" type="hidden" name="web_price" value="{{Config::get('project_price.project_price')}}">--}}
                                    <span class="product-sum-numb">Number of Websites</span>
                                    <span class="span-calc"> х</span>
                                    <span class="span-calc-qty-web">{{count($order->projects)}}</span>
                                    {{--<span class="rght">USD $<span class="span-calc-total-web">{{count($order->projects) * Config::get('project_price.project_price')}}</span></span>--}}
                                </p>
                            </div>
                        </div>


                        <div class="row">
                            <div class="col-lg-12 col-md-12">
                                <hr style="margin-top: 13px; margin-bottom: 15px;">
                                <p class="prod-total">
                                    SUBTOTAL
                                    <span class="rght">USD $<span id="subtotal">{{$order->without_discount}}</span></span>
                                    <hr style="margin-top: 13px; margin-bottom: 15px;">
                                </p>
                                <p id="coupon_row" class="prod-total">Coupon:
                                    @foreach($order->coupons as $coupon)
                                        <span id="span_coupon_name">{{ $coupon->name }}</span>
                                    @endforeach
                                    <span class="rght product-sum-numb">-USD $ {{ $order->without_discount - $order->amount}}
                                        <span id="discount_amount_minus"></span>
                                    </span>
                                    <hr style="margin-top: 13px; margin-bottom: 15px;">
                                </p>
                                </p>
                                <p class="prod-total">
                                    Total

                                    {{--<span id="sum_total_final">{{$order->without_discount}}</span>--}}
                                    <span class="total-usd">USD $
                                    <span id="sum_total_final">{{$order->amount}}</span></span>
                                </p>
                                <hr style="margin-top: 13px; margin-bottom: 5px;">
                            </div>
                        </div>



                        <div class="form-group">
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-warning submit btn-addRestar btn-addRestar1 btn-lg" id="pay" value="Submit Payment">
                                Place Order
                            </button>
                                <label class="terms_conditions_block">
                                <input class="checkbox" id="subscribeNews" type="checkbox" name="checkbox-test">
                                <span class="checkbox-custom"></span>
                                <span class="terms_conditions">I agree to this <a href="#">terms and conditions</a></span>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-8 col-lg-8 your_cart_block">
                    <h5 class="yor-cart">Your Cart</h5>

                    <div class="row">
                        <div class="number-target">
                            <p class="title_checkout">Customer Info</p>

                            <div class="col-md-12 col-lg-12 cust_info_block">
                                <div class="form-group col-md-6 col-lg-6">
                                    <input id="first_name" type="text" class="form-control margin_10 input-lg" name="first_name" value="" placeholder="First Name" required>
                                    @if ($errors->has('first_name'))
                                    <span class="help-block alert-danger">
                                            <strong>{{ $errors->first('first_name') }}</strong>
                                            </span> @endif

                                    <input id="last_name" type="text" class="form-control margin_10 input-lg" name="last_name" value="" placeholder="Last Name" required>
                                    @if ($errors->has('last_name'))
                                    <span class="help-block alert-danger">
                                            <strong>{{ $errors->first('last_name') }}</strong>
                                            </span> @endif

                                    <input id="phone" type="text" class="form-control margin_10 input-lg" name="phone" value="" placeholder="Phone" maxlength="16" required>
                                    @if ($errors->has('phone'))
                                    <span class="help-block alert-danger">
                                            <strong>{{ $errors->first('phone') }}</strong>
                                            </span> @endif
                                </div>
                                <div class="form-group col-md-6 col-lg-6">
                                    <input id="company" type="text" class="form-control margin_10 input-lg" name="company" value="" placeholder="Company" required>
                                    @if ($errors->has('company'))
                                    <span class="help-block alert-danger">
                                            <strong>{{ $errors->first('company') }}</strong>
                                            </span> @endif

                                    <input id="email" type="email" class="form-control margin_10 input-lg" name="email" value="{{$order->user->email}}" placeholder="Email" readonly style="cursor: default;"> @if ($errors->has('email'))
                                    <span class="help-block alert-danger">
                                            <strong>{{ $errors->first('email') }}</strong>
                                            </span> @endif

                                    <div class="form-group">
                                        <select class="form-control margin_10 input-lg" id="country" name="country">
                                                <option selected="selected">Australia (AU)</option>
                                                <option>Canada (CA)</option>
                                                <option>Denmark (DK)</option>
                                                <option>France (FR)</option>
                                                <option>Hong Kong (HK)</option>
                                                <option>Italy (IT)</option>
                                                <option>Japan (JP)</option>
                                                <option>New Zealand (NZ)</option>
                                                <option>Singapore (SG)</option>
                                                <option>Switzerland (CH)</option>
                                                <option>United Kingdom (GB)</option>
                                                <option>United States (US)</option>
                                            </select>
                                    </div>
                                </div>
                            </div>
                            <p class="title_checkout">Payment Option</p>
                            <div class="col-md-12 col-lg-12 cust_info_block">
                                <label style="color: #9d9d9d;">
                                <input type="radio" class="radio" id="radio_paypal"
                                       name="payment_method"
                                       value="payPal"
                                       route_cust="{{ route('addPaypal', [$order]) }}">
                                <span class="radio-custom"></span>
                                PayPal<br>
                                </label>

                                <img src="{{asset('img/payPal.png')}}" alt="" style="margin: 0 10px">
                                <span style="color: #9d9d9d; font-size: 30px;"> | </span>
                                <label style="color: #9d9d9d;">
                                <input type="radio" class="radio" id="radio_stripe"
                                       name="payment_method"
                                       value="stripe"
                                       route_cust="{{ route('addPayStripe', [$order]) }}"
                                       checked >
                                    <span class="radio-custom"></span>
                                    Credit Card (Stripe) <br>
                                </label>
                                <img src="{{asset('img/stripe_new.png')}}" alt="">

                                <div class="stripe_errors">
                                    @if ($errors->has('message'))
                                    <span class="help-block alert-danger">
                                        <strong>{{ $errors->first('message') }}</strong>
                                    </span>
                                    @endif

                                    @if($message = \Session::get('error'))
                                        <div>{{ $message }}</div>
                                        <?php Session::forget('error');?>
                                    @endif
                                </div>
                                <div class="pay_pal">
                                    @if ($message = \Session::get('error'))
                                        <div class="alert alert-success">
                                            {{ $message }}
                                        </div>
                                        <?php \Session::forget('error');?>
                                    @endif
                                </div>
                                <div class="card_inputs">
                                    <div class="form-group col-md-6 col-lg-6">
                                        {{--4242 4242 4242 4242--}}
                                        <input id="card_num" data-stripe="number" maxlength="16"
                                               type="text" class="form-control margin_10 input-lg"
                                               name="card_number" value="" placeholder="Card Number" required>
                                        @if ($errors->has('card_number'))
                                        <span class="help-block alert-danger">
                                            <strong>{{ $errors->first('card_number') }}</strong>
                                        </span>
                                        @endif

                                        <input id="cvc" type="password" maxlength="4" data-stripe="cvc"
                                               class="form-control margin_10 input-lg" name="cvc" value=""
                                               placeholder="CVC Code" required>
                                        @if ($errors->has('cvc'))
                                        <span class="help-block alert-danger">
                                            <strong>{{ $errors->first('cvc') }}</strong>
                                        </span>
                                        @endif

                                    </div>
                                    <div class="form-group col-md-6 col-lg-6 month_year_input">
                                        <div class="form-group">
                                            <input id="expiry_month" data-stripe="number" maxlength="2"
                                                   type="text" class="form-control margin_10 input-lg"
                                                   name="expiry_month" value="" placeholder="MM" required>
                                            @if ($errors->has('expiry_month'))
                                            <span class="help-block alert-danger">
                                                <strong>{{ $errors->first('expiry_month') }}</strong>
                                            </span>
                                            @endif

                                            <input id="expiry_year" data-stripe="number" maxlength="4"
                                                   type="text" class="form-control margin_10 input-lg"
                                                   name="expiry_year" value="" placeholder="YYYY" required>
                                            @if ($errors->has('expiry_year'))
                                            <span class="help-block alert-danger">
                                                <strong>{{ $errors->first('expiry_year') }}</strong>
                                            </span>
                                            @endif

                                        </div>
                                    </div>
                                </div>

                                <input type="hidden" name="amount" data-amount="amount" value="{{$order->amount}}">
                                <input type="hidden" name="currency" id="currency" value="usd">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>


<script>
    $("form").submit(function() {
        $(":submit", this).attr("disabled", "disabled");
    });

    $("#radio_paypal").on('click', function () {

        var route = $("#radio_paypal").attr('route_cust');
        console.log(route);
        $("#payment-form").attr('action', route);

        $("#card_num").attr('required', false);
        $("#cvc").attr('required', false);
        $("#expiry_month").attr('required', false);
        $("#expiry_year").attr('required', false);

        $('.card_inputs').hide();

        console.log(this);
        console.log($("#payment-form"));

    });


    $("#radio_stripe").on('click', function () {
        var route = $("#radio_stripe").attr('route_cust');
        console.log(route);
        $("#payment-form").attr('action', route);

        $("#card_num").attr('required', true);
        $("#cvc").attr('required', true);
        $("#expiry_month").attr('required', true);
        $("#expiry_year").attr('required', true);

        $('.card_inputs').show();

        console.log(this);
        console.log($("#payment-form"));
    });

    //    $('#country').on('change', function(){
    //        var country = $(this).val();
    //        console.log(country);
    //        if (country == 'USA')
    //        {
    //            $('#currency').val('usd1');
    //        }
    //        else {
    //            $('#currency').val('usd11');
    //        }
    //        console.log($('#currency').val());
    //    });

</script>
@endsection
