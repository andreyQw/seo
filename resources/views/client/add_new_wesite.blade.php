<link rel="stylesheet" href="{{ asset('css/add_new_project_style.css') }}">

<div class="dropdown-menu dropdown-menu-center btn-wrapp"  id="add_website_drop">

    <div class="row table-my">
        <form method="POST" action="#" id="editOrderForm" enctype="multipart/form-data">
            <div class="col-sm-12">
                <div class="table-wrapper">
                    <table class="table table-bordered th-my full-table">
                        <thead class="th-my">
                            <tr>
                                <th class="th-my td-25">URL</th>
                                <th class="th-my td-30">Product</th>
                                <th class="th-my td-32">QTY</th>
                                <th class="th-my td-13">Total</th>
                            </tr>
                        </thead>
                        <tbody id="t_body" class="t_body qwer">
                            <tr id="tr_project" class="number-target row_table" style="display: none">
                                <td class="td-25">
                                    <div class="input-group">
                                        <input id="url" type="text" class="form-control input-lg" name="url[]" value="" placeholder="Enter Website URL" required>
                                        <span class="input-group-btn">
                                            <button class="btn btn-default btn-delete" id="btn_delete" type="button">
                                                <span class="glyphicon glyphicon-remove-circle glphcn-delete"></span>
                                            </button>
                                            {{--<a href="#" onclick="deleteProjRow(event)">--}}
                                                {{--<i class="mdi mdi-close-circle"></i>--}}
                                            {{--</a>--}}
                                         </span>
                                    </div>
                                </td>
                                <td class="td-30">
                                    <div class="bull">
                                        <img src="{{asset('img/orderFormLayout/bull.png')}}" alt="">
                                    </div>
                                    <span class="product">Trust Flow 10+ placements</span>
                                    <input id="prod_name" type="hidden" name="product_id[]" value="$product->id">
                                </td>
                                <td class="td-32">
                                    <div class="input-group field-qty change_q">
                                        <button id="qty-btn-left" type="button" class="qty-btn" value="-">-</button>
                                        <input id="quantity" type="number" class="qty" name="quantity[]" value="1" min="1" required readonly>
                                        <button id="qty-btn-right" type="button" class="qty-btn" value="+" class="">+</button>
                                    </div>
                                </td>
                                <td class="td-13">
                                    <span class="product">USD $</span> <span id="total_row" class="product">500</span>
                                    <input id="product_price" type="hidden" name="product_price[]" value="$product">
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="col-sm-5 col-xs-12">
                <button id="add_proj" class="btn btn-default add_more" type="button">Add More</button>
            </div>

            <div class="col-sm-12 col-xs-12">
                <p class="title_checkout">Payment Option</p>
                <div class="col-md-12 col-lg-12 cust_info_block">
                    <label style="color: #9d9d9d;">
                        <input type="radio" class="radio" id="radio_paypal"
                               name="payment_method"
                               value="payPal"
                               route_cust="}">
                        <span class="radio-custom"></span>
                        PayPal<br>
                    </label>

                    <img src="{{asset('img/payPal.png')}}" alt="" style="margin: 0 10px">
                    <span style="color: #9d9d9d; font-size: 30px;"> | </span>
                    <label style="color: #9d9d9d;">
                    <input type="radio" class="radio" id="radio_stripe"
                           name="payment_method"
                           value="stripe"
                           route_cust=""
                           checked >
                        <span class="radio-custom"></span>
                        Credit Card (Stripe) <br>
                    </label>
                    <img src="{{asset('img/stripe_new.png')}}" alt="">

                    <div class="stripe_errors">

                        <span class="help-block alert-danger">
                            <strong></strong>
                        </span>
                    </div>
                </div>
                <div class="card_inputs">
                    <div class="form-group col-md-5 col-lg-5 col-sm-5 col-xs-12">

                        <input id="card_num" required ata-stripe="number" maxlength="16"
                               type="text" class="form-control margin_10 input-lg"
                               name="card_number" placeholder="Card Number" required>

                        <span class="help-block alert-danger">
                            <strong></strong>
                        </span>

                        <input id="cvc" type="password" required maxlength="4" data-stripe="cvc"
                               class="form-control margin_10 input-lg" name="cvc"
                               placeholder="CVC Code" required>

                        <span class="help-block alert-danger">
                            <strong></strong>
                        </span>
                    </div>
                    <div class="form-group col-md-3 col-lg-3 col-sm-3 col-xs-12 month_year_input">
                        <div class="form-group">

                            <input id="expiry_month" required data-stripe="number" maxlength="2"
                                   type="text" class="form-control margin_10 input-lg"
                                   name="expiry_month" value="" placeholder="MM" required>

                            <span class="help-block alert-danger">
                                <strong></strong>
                            </span>

                            <input id="expiry_year" data-stripe="number" maxlength="4"
                                   type="text" class="form-control margin_10 input-lg"
                                   name="expiry_year" value="" placeholder="YYYY" required>

                            <span class="help-block alert-danger">
                                <strong></strong>
                            </span>

                        </div>
                    </div>
                </div>

                <input type="hidden" name="amount" data-amount="amount" value="">
                <input type="hidden" name="currency" id="currency" value="usd">
            </div>
            <div class="col-sm-5 col-xs-12">
                <button class="btn btn-default confirm_order" type="submit" form="bio_form">Confirm Order</button>
            </div>
        </form>
    </div>
</div>
