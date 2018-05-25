@extends('layouts.orderFormLayout')
@section('content')
    @if ($errors->has('url'))
        <span class="help-block alert-danger">
            <strong>{{ $errors->first('url') }}</strong>
        </span>
    @endif
<div class="container" style="padding-left: 0; padding-right: 0;">
    <div class="row">
        <form method="POST" action="{{ $action }}" enctype="multipart/form-data">
            {{ csrf_field() }}

            <div class="row o-padding-ordersection">
                <div class="col-md-8 col-lg-8 o-colblock-padding">
                    <h5 class="yor-cart">Your Cart</h5>

                    <div class="row">
                        <div class="form-group number-target">

                                     <label for="numOfWeb" class="center-block o-label-color">Number of Target Websites</label>
                            <input id="numOfWeb" class="form-control input-lg"
                                   name="numOfWeb"
                                   {{--type="text" maxlength="2"--}}
                                   type="number" min="1"
                                   value="1" onclick="this.select();" required>
                            @if ($errors->has('numOfWeb'))
                            <span class="help-block alert-danger">
                                <strong>{{ $errors->first('numOfWeb') }}</strong>
                            </span>
                            @endif
                        </div>
                    </div>

                    @if ($errors->has('url.0'))
                    <span class="help-block alert-danger">
                        <strong>{{ $errors->first('url.0') }}</strong>
                    </span>
                    @endif

                    <div class="row table-my">
                        <table class="table table-bordered th-my full-table">
                            <thead class="th-my">
                                <tr>
                                    <th class="th-my td-25">URL</th>
                                    <th class="th-my td-30">Product</th>
                                    <th class="th-my td-32">QTY</th>
                                    <th class="th-my td-13">Total</th>
                                </tr>
                            </thead>
                            <tbody class="t_body qwer">
                                <tr id="tr-placement" class="number-target row_table">
                                    <td class="td-25">
                                        <input id="url" type="text" class="form-control input-lg" name="url[]" value="" placeholder="Enter Website URL" required>
                                    </td>
                                    <td class="td-30">
                                        <div class="bull">
                                            <img src="{{asset('img/orderFormLayout/bull.png')}}" alt="">
                                        </div>
                                        <span class="product">{{$product->title}}</span>
                                        <input id="prod_name" type="hidden" name="product_id[]" value="{{$product->id}}"> {{--
                                        <input id="product" type="text" class="form-control" name="product" value="">--}}
                                    </td>
                                    <td class="td-32">
                                        <div class="input-group field-qty change_q">
                                            <button id="qty-btn-left" type="button" class="qty-btn" value="-">-</button>
                                            <input id="quantity" type="number" class="qty"
                                                   name="quantity[]" value="1" min="1" required readonly >
                                            <button id="qty-btn-right" type="button" class="qty-btn" value="+" class="">+</button>
                                        </div>
                                        {{--<div class="update">--}}
                                            {{--<button type="button" class="btn btn-warning btn-lg btn-update" value="Update Cart" onClick="totalCost()">Update Cart</button>--}}
                                        {{--</div>--}}
                                    </td>
                                    <td class="td-13">
                                        <span class="product">USD $</span> <span id="total_row" class="product">{{$product->price}}</span>
                                        <input id="product_price" type="hidden" name="product_price[]" value="{{$product->price}}">
                                    </td>
                                </tr>

                            </tbody>
                        </table>
                    </div>
                </div>

                {{----}}
                <div class="col-md-4 col-lg-4">
                    <h5 class="yor-cart summary">Summary</h5>
                    <div class="md-sum">
                        <div class="row row15">
                            <div class="<form-group col-lg-12 col-md-12 indentation">
                                <div class="col-lg-6 col-md-6 indentation">
                                    <input id="coupon" type="text" class="form-control input-lg" name="coupon" value="" placeholder="Enter Code">
                                </div>
                                <div class="col-lg-6 col-md-6 indentation">
                                    <button id="btn-my" type="button" class="btn btn-primary btn-lg">APPLY COUPON</button>
                                </div>
                                <p class="coupon_not_found" style=" text-align: center"></p>
                                <input id="coupon_id"
                                       type="hidden"
                                       name="coupon_id"
                                       data-coupon-id="{{ $coupon->id }}"
                                       data-discount-id="{{ $coupon->discount_id }}"
                                       data-amount="{{ $coupon->amount }}"
                                       value="{{ $coupon->id }}">
                                {{--qwe--}}
                            </div>

                            <div class="row">
                                <h2 class="prod-total text-left" style="float: left;">Product</h2>
                                <h2 class="prod-total text-right" style="float: right;">Total</h2>
                            </div>
                            <hr id="linefirst">
                            <div class="row row_for_insert">
                                <div class="col-lg-12 col-md-12 row_sum_prod">
                                    <p>
                                        <span class="product-sum-name">{{$product->title}}</span>
                                        <span class="span-calc">х</span>
                                        <span class="span-calc-qty">1</span>
                                        <span class="rght">USD $<span class="span-calc-total">{{$product->price}}</span></span>
                                    </p>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-12 col-md-12" style="padding: 0">
                                    <p>
                                        <input id="web_price" type="hidden" name="web_price" value="{{$project_price}}">
                                        <span class="product-sum-numb">Number of Websites</span>
                                        <span class="span-calc"> х</span>
                                        <span class="span-calc-qty-web">1</span>
                                        {{--<span class="rght">USD $<span class="span-calc-total-web">{{$project_price}}</span></span>--}}
                                        {{--<span class="rght">--}}
                                            {{--USD $<span class="span-calc-total-web"></span>--}}
                                        {{--</span>--}}
                                    </p>
                                </div>
                            </div>
                            <div class="row">
                               <hr style="margin-top: 13px; margin-bottom: 15px;">
                                <p class="prod-total">
                                    SUBTOTAL
                                    <span class="rght product-sum-numb">USD $<span id="subtotal">300</span></span>
                                    <hr style="margin-top: 13px; margin-bottom: 15px;">
                                </p>
                                <p id="coupon_row" class="prod-total">Coupon:
                                    <span id="span_coupon_name">{{ $coupon->name }}</span>
                                    <span class="rght product-sum-numb"><a href="#" class="linkRemoveCoupon">[remove]</a>-USD $
                                        <span id="discount_amount_minus"></span>
                                    </span>
                                    <hr style="margin-top: 13px; margin-bottom: 25px;">
                                </p>

                                <p class="prod-total">
                                    Total
                                    <span class="total-usd">USD $
                                    <span id="sum_total_final">350</span></span>
                                </p>
                                <hr style="margin-top: 13px; margin-bottom: 25px;">
                            </div>

                            <div class="row row15">
                                <div class="form-group">
                                    <div class="col-md-12 indentation">
                                        <input id="email" type="email" class="form-control input-lg" name="email" value="" placeholder="Enter Your Email" required>
                                        @if ($errors->has('email'))
                                        <span class="help-block alert-danger">
                                            <strong>{{ $errors->first('email') }}</strong>
                                        </span>
                                        @endif
                                    </div>

                                    <div class="col-md-12  indentation">
                                        <button type="submit" class="btn btn-warning btn-addRestar btn-addRestar1 btn-lg">Checkout</button>
                                        {{--
                                        <input type="submit" class="btn btn-warning" value="Checkout" onClick="">--}} {{--
                                        <a href="{{ route('productList') }}" class="btn btn-warning btn-tabl">Back</a>--}}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

    <script>

    </script>
@endsection
