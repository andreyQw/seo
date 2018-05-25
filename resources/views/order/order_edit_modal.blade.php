
<div class="col-xs-12">
    <div class="modal fade"
         id="order_modal"
         tabindex="1" role="dialog" aria-labelledby="order_label" aria-hidden="true">
        <div class="modal-dialog order_modal_dialog">
            <div class="modal-content col-md-12" style="height: 100%; width: 100%;">
                <div class="modal-header order_modal_header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title order_modal_title" id="order_label">Order</h4>
                    <hr class="order_popup_line">
                </div>
                <div class="modal-body order_modal_body" id="order_modal">
                    <div id="please_wait" style="display: none" class="alert alert-success">
                        <p>please_wait...</p>
                    </div>
                    <div id="form_errors"></div>

                    {{--222222222222222--}}

                    <form method="POST" action="{{ route("editOrder") }}" id="editOrderForm" enctype="multipart/form-data">
                        <div class="col-md-8">
                            <div class="col-sm-12 col-xs-12 table-modal-header">
                                <h5 class="yor-cart col-sm-9 col-xs-6">Your Cart</h5>
                                <div class="col-sm-3 col-xs-6">
                                    <button id="add_proj" onClick="addProject()">Add project</button>
                                </div>
                            </div>

                            <input id="order_id" type="hidden" name="order_id" value="">

                            {{ csrf_field() }}
                            @if ($errors->has('url.0'))
                                <span class="help-block alert-danger">
                                    <strong>{{ $errors->first('url.0') }}</strong>
                                </span>
                            @endif

                            <div class="table-my col-xs-12">
                                <div class="wrapper-table-modal">
                                    <table class="table table-bordered th-my">
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
                                                {{--<i class="mdi close-circle icon_show"></i>--}}
                                                <input id="url" type="text" class="form-control input-lg" name="url[]" value="" placeholder="Enter Website URL" required>
                                                {{--<input id="" type="hidden" value="" name="id">--}}
                                            </td>
                                            <td class="td-30">
                                                <img src="{{asset('img/orderFormLayout/bull.png')}}" alt="">
                                                <select name="products_id[]" id="" onChange='prod_change(event);'>
                                                    @foreach($products as $product)
                                                        <option value="{{ $product->id }}"
                                                                id="{{ 'projProdId_'.$product->id }}"
                                                                prodPrice="{{ $product->price }}">{{ $product->title }}</option>
                                                    @endforeach
                                                </select>
                                                {{--<input id="prod_name" type="hidden" name="product_id[]" value="$product->id"> --}}
                                            </td>
                                            <td class="td-32">
                                                <div class="input-group field-qty change_q" onclick="changeQty(event);">
                                                    <button id="qty-btn-left" type="button" class="qty-btn" value="-">-</button>
                                                    <input id="quantity" type="number" class="qty"
                                                           name="quantity[]" value="1" min="1" required readonly >
                                                    <button id="qty-btn-right" type="button" class="qty-btn" value="+" class="">+</button>
                                                </div>
                                            </td>
                                            <td class="td-13">
                                                <span class="usd">USD $</span> <span id="total_row" class="product"></span>
                                                <input id="product_price" type="hidden" name="projects_id[]" value="">
                                                <a href="#" onclick="deleteProjRow(event)">
                                                    <i class="mdi mdi-close-circle"></i>
                                                </a>
                                            </td>
                                        </tr>

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="col-xs-12 button-modal-save">
                                <div class="col-xs-3">
                                    <button type="submit" form="editOrderForm" onclick="submitForm()">Save</button>
                                </div>
                            </div>
                        </div>
                    
                        <div class="col-md-4 nopadding">
                            <h5 class="yor-cart summary">Summary</h5>
                            <div class="col-md-12 nopadding wrapper-for-summary-mm">
                                <div class="md-sum">
                                    <div class="<form-group col-lg-12 col-md-12 indentation nopadding">
                                        <div class="col-lg-6 col-md-6 indentation nopadding-right">
                                            <input id="coupon" type="text" class="form-control input-lg enter-code-input-mm" name="coupon" value="" placeholder="Enter Code">
                                        </div>
                                        <div class="col-lg-6 col-md-6 nopadding-left indentation">
                                            <button id="btn-my" type="button" class="btn btn-primary btn-lg apply-coupon-btn">APPLY COUPON</button>
                                        </div>
                                        <p class="coupon_not_found" style=" text-align: center"></p>
                                        <input id="coupon_id"
                                               type="hidden"
                                               name="coupon_id"
                                               data-coupon-id=" $coupon->id "
                                               data-discount-id=" $coupon->discount_id "
                                               data-amount=" $coupon->amount "
                                               value=" $coupon->id ">
                                        {{--qwe--}}
                                    </div>

                                    <div class="col-md-12">
                                        <h2 class="prod-total text-left" style="float: left;">Product</h2>
                                        <h2 class="prod-total text-right" style="float: right;">Total</h2>
                                    </div>
                                    <hr id="linefirst">
                                    <div id="sum_proj_all" class="col-md-12 nopadding row_for_insert">
                                        <div id="sum_proj_row" class="col-lg-12 col-md-12 row_sum_prod" style="display: none">

                                            <span id="pr_title" class="product-sum-name">title</span>
                                            <span class="span-calc">х</span>
                                            <span id="pr_qty" class="span-calc-qty">1</span>
                                            <span class="rght">USD $
                                                <span id="pr_total" class="span-calc-total">price</span>
                                            </span>

                                        </div>
                                    </div>

                                    <div class="col-md-12 nopadding">
                                        <div class="col-lg-12 col-md-12">
                                            <p>
                                                <input id="web_price" type="hidden" name="web_price" value="$project_price">
                                                <span class="product-sum-numb">Number of Websites</span>
                                                <span class="span-calc"> х</span>
                                                <span class="span-calc-qty-web" id="numb_of_proj"></span>
                                                {{--<span class="rght">USD $<span class="span-calc-total-web">{{$project_price}}</span></span>--}}
                                                {{--<span class="rght">--}}
                                                {{--USD $<span class="span-calc-total-web"></span>--}}
                                                {{--</span>--}}
                                            </p>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <hr style="margin-top: 13px; margin-bottom: 15px;">
                                        <p class="prod-total">
                                            SUBTOTAL
                                            <span class="rght product-sum-numb">USD $
                                                <span id="subtotal">300</span>
                                            </span>
                                        </p>
                                        <hr style="margin-top: 13px; margin-bottom: 15px;">

                                        <p id="coupon_row" class="prod-total" style="display: none">
                                            Coupon:
                                            <span id="span_coupon_name"> $coupon </span>
                                            <span class="rght product-sum-numb">
                                                <a href="#" class="linkRemoveCoupon">[remove]</a>-USD $
                                                <span id="discount_amount_minus"></span>
                                            </span>
                                        </p>
                                        <hr style="margin-top: 13px; margin-bottom: 25px;">

                                        <p class="prod-total">
                                            Total
                                            <span class="total-usd rght">USD $
                                                <span id="sum_total_final">350</span>
                                            </span>
                                        </p>
                                        <hr style="margin-top: 13px; margin-bottom: 25px;">
                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <div class="col-md-12 indentation">
                                                <input id="email" type="email" class="form-control input-lg" name="email" value="" placeholder="Enter Your Email" required readonly>
                                                @if ($errors->has('email'))
                                                    <span class="help-block alert-danger">
                                                    <strong>{{ $errors->first('email') }}</strong>
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>