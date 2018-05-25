{{-- MODAL WINDOW --}}
<div id="create_campaing" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            {{-- Заголовок модального окна --}}
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title">Create Campaign</h4>
            </div>
            {{-- Основное содержимое модального окна --}}

            <ul class="nav nav-tabs modal-tabs" role="menu">
                <li class="campaign_tab active"><a href="#general" data-toggle="tab">General</a></li>
                <li class="campaign_tab"><a href="#restrict" data-toggle="tab">Usage Restriction</a></li>
                <li class="campaign_tab"><a href="#limit" data-toggle="tab">Usage Limits</a></li>
            </ul>

            <div class="tab-content">

                <div class="tab-pane" id="general">

                    <form name="create_campaign" action="{{ route('coupon.store') }}" method="POST" id="create_campaign">

                        {{ csrf_field() }}

                        <div class="row row_first">
                            <div class="col-md-3 form-group">
                                <label for="name">Coupon Code</label>
                                <input required type="text" name="name" id="name" placeholder="Enter Code" class="create_camp_fields form-control">
                            </div>
                            <div class="col-md-9 form-group">
                                <label for="description">Description</label>
                                <input type="text" name="description" id="description" placeholder="Optional" class="create_camp_fields form-control">
                            </div>
                        </div>
                        <div class="row row_first">
                            <div class="col-md-6 form-group">
                                <label for="discount">Discount Type</label>
                                <select name="discount_id" id="discount" class="create_camp_fields form-control">
                                    @foreach($discount as $disc)
                                        <option value="{{ $disc->id }}" as="{{ $disc->as }}">{{$disc->name}}</option>
                                    @endforeach
                                </select>
                                {{--<input type="text" name="example" list="lst">
                                <datalist id="lst">
                                    <option value="One">
                                    <option value="Two">
                                </datalist>--}}
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="amount">Coupon Amount</label>
                                <input required type="number" name="amount" id="amount" min="1" @if($discount[0]->as == '%') max="100" @endif class="create_camp_fields form-control" placeholder="{{ $discount[0]->as }}">
                            </div>
                        </div>
                        <div class="row row_first">
                            <div class="col-md-6 form-group">
                                <label for="expiry_date">Coupon Expiry Date</label>
                                <input type="date" class="create_camp_fields form-control" name="expiry_date" id="expiry_date">
                            </div>
                            <div class="col-md-6 form-group">
                                <button class="btn btn-default launch_campaign">Launch Campaign</button>
                            </div>
                        </div>
                        <div class="row row_first">
                            <div class="col-md-12 form-group">
                                <label for="free_shipping">
                                    <input id="free_shipping" name="free_shipping" class="create_camp_fields chik" type="checkbox">
                                    <span class="checkbox-custom"></span>
                                    <label class="label">Check this box if the coupon should not apply to item on sale. Per-item coupons will only work if the item is not on sale. Per-cart coupon will only work if there are no sale items in the cart</label>
                                </label>
                            </div>
                        </div>

                    </form>

                </div>

                <div class="tab-pane" id="restrict">

                    <div class="row second_tab_row">
                        <div class="form-row row_second">
                            <div class="col-md-6 form-group">
                                <label for="max_spend">Maximum spend</label>
                                <input form="create_campaign" type="text" min="0" name="max_spend" id="max_spend" placeholder="No spend" class="create_camp_fields form-control">
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="min_spend">Minimum spend</label>
                                <input form="create_campaign" type="text" min="0" name="min_spend" id="min_spend" placeholder="No spend" class="create_camp_fields form-control">
                            </div>
                        </div>
                        <div class="form-row row_second">
                            <label for="use_only" class="control-label col-md-2">Individual use only</label>
                            <div class="col-md-10 form-group">
                               <label for="use_only">
                                <input form="create_campaign" type="checkbox" name="use_only" id="use_only" class="create_camp_fields chek">
                                <span class="checkbox-custom2"></span>
                                <label class="label">Check this box if the coupon cannot be used in conjunction with other coupons.</label>
                                </label>
                            </div>
                        </div>
                       
                        <div class="form-row row_second">
                            <div class="col-md-6 form-group">
                                <label for="product">Products</label>
                                <select form="create_campaign" multiple name="product[]" id="product" size="2" data-placeholder="Any products" class="create_camp_fields chosen-select form-control">
                                    @foreach($cats as $cat)
                                        @foreach($cat->products as $product)
                                            <option value="{{ $product->id }}">{{ $product->title }}</option>
                                        @endforeach
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="exclude_products">Exclude products</label>
                                <select form="create_campaign" multiple name="exclude_products[]" id="exclude_products" size="2" data-placeholder="No products" class="create_camp_fields chosen-select form-control">
                                    @foreach($cats as $cat)
                                        @foreach($cat->products as $product)
                                            <option value="{{ $product->id }}">{{ $product->title }}</option>
                                        @endforeach
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-row row_second">
                            <div class="col-md-6 form-group">
                                <label for="categories">Product categories</label>
                                <select form="create_campaign" multiple name="categories[]" id="categories" size="2" data-placeholder="Any categories" class="create_camp_fields chosen-select form-control">
                                    @foreach($cats as $cat)
                                        <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="exclude_categories">Exclude categories</label>
                                <select form="create_campaign" multiple name="exclude_categories[]" id="exclude_categories" size="2" data-placeholder="No categories" class="create_camp_fields chosen-select form-control">
                                    @foreach($cats as $cat)
                                        <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-row row_second">
                            <div class="col-md-12 form-group">
                                <label for="email_restrict">Email restrictions</label>
                                <input form="create_campaign" type="text" name="email_restrict" id="email_restrict" placeholder="No restrictions" class="create_camp_fields form-control">
                            </div>
                        </div>
                    </div>

                </div>

                <div class="tab-pane" id="limit">

                    <div class="row third_row">
                        <div class="form-row">
                            <div class="form-group col-md-6 form-first">
                                <label for="usage_coupon">Usage Limit Per Coupon</label>
                                <input type="text" min="0" name="usage_coupon" id="usage_coupon" placeholder="Unlimited Usage" form="create_campaign" class="create_camp_fields form-control">
                            </div>
                            <div class="form-group col-md-6 form-last">
                                <label for="usage_user">Usage Limit Per User</label>
                                <input type="text" min="0" name="usage_user" id="usage_user" placeholder="Unlimited Usage" form="create_campaign" class="create_camp_fields form-control">
                            </div>
                        </div>
                    </div>

                </div>

            </div>

        </div>
    </div>
</div>
{{-- END MODAL WINDOW --}}