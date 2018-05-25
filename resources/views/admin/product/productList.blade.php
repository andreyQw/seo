@extends('layouts.dashboard_layout')

@section('name', 'Product Manager')

@section('content')

    <link rel="stylesheet" href="{{ asset('css/acss/product_list.css') }}">
    <link rel="stylesheet" href="{{ asset('css/product_manager_style.css') }}">

<div class="table_block col-md-12 col-sm-12 col-xs-12">
    <div class="col-md-12 col-sm-12 col-xs-12 product-header">
        {{--<span class="glyphicon glyphicon-ok"></span>--}}
        {{--<span class="glyphicon glyphicon-remove"></span>--}}
        <div class="col-xs-7 col-sm-8 col-lg-10 col-md-10">
            <h1 class="modal-title">Unit Products</h1>
        </div>

        <div class="col-xs-5 col-sm-4 col-lg-2 col-md-2">
            <a href="#" id="add_new_prod" class="edit_product icon_size btn btn-primary btn-tabl left_oriented btn_add" data-toggle="modal" data-target="#myModal">Add New</a>
  
        </div>
    </div>

        @if ($errors->any())
    <div class="errors col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
    </div>
        @endif

    <div class="col-md-12 col-sm-12 col-xs-12 wrapper_for_table">

    <table class="table table-striped table-bordered table-hover table-condensed my_table">
        <tr>
            <th>Product Name</th>
            <th>Price</th>
            <th>SKU</th>
            <th>Status</th>
            <th>Date</th>
            <th>Action</th>
        </tr>

        @foreach ($products as $product)
            <tr id="{{'prodId_'.$product->id}}">
                <td>
                    @if ($product->title)
                        {{ $product->title }}
                    @endif
                </td>
                <td><span>$</span>
                    @if ($product->price)
                        {{ $product->price }}
                    @endif
                </td>
                <td>
                    @if ($product->sku)
                        {{ $product->sku }}
                    @endif
                </td>
                <td>
                    <label class="switch">
                        <input id="{{ $product->id }}"
                               class="switch_input"
                               type="checkbox"
                               name="status"
                               value="{{$product->status}}"
                               @if ($product->status == 'show')
                                    checked
                               @endif
                        >
                        <span class="slider round"></span>
                    </label>
                </td>
                <td>
                    @if ($product->updated_at)
                        {{ Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $product->updated_at)->format('Y/m/d') }}
                    @else
                        {{ Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $product->created_at)->format('Y/m/d') }}
                    @endif
                </td>
                <td>
                    <a href="{{ route('product_delete', ['id' => $product->id]) }}" class="delete_product icon_size">
                    {{--<a href="#" class="delete_product icon_size">--}}
                        <span class="delete_coupon" style="color: #f15d34;">
                                                     <img src="{{ asset('img/action_trash_can.png') }}" alt="">
                                                </span>
                    </a>

                    <a href="#" class="edit_product icon_size" data-toggle="modal" data-target="#myModal">
                       <img src="{{ asset('img/action_pen.png') }}" alt=""
                       id="product_data"
                              data-id="{{$product->id}}"
                              data-title="{{ $product->title }}"
                              data-price="{{ $product->price }}"
                              data-sku="{{ $product->sku }}">
                    </a>
                </td>
            </tr>
        @endforeach
    </table>
    </div>
</div>

<div class="row">
    {{--<h2>Modal Example</h2>--}}
    <!-- Trigger the modal with a button -->
    {{--<button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal">Open Modal</button>--}}

    <!-- Modal -->
    <div class="modal fade" id="myModal" role="dialog">
        <div class="modal-dialog modal_style">

            <!-- Modal content-->
            <div class="modal-content col-xs-12">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Add New Products</h4>
                </div>
                <div class="modal-body">
                    <ul class="nav nav-tabs">
                        <li class="active"><a data-toggle="tab" href="#product">Unit</a></li>
                        {{--<li><a data-toggle="tab" href="#menu2">Subscription</a></li>--}}
                    </ul>

                    <div class="tab-content col-xs-12">
                        <div id="product" class="tab-pane fade in active">
                            <form method="POST" action="{{ route('addNewProduct') }}" id="product_form" enctype="multipart/form-data">
                                {{ csrf_field() }}
                                <div class="col-lg-12 col-sm-12 col-md-12 col-xs-12 modal-unit">

                                    <div class="col-lg-4 col-sm-6 col-md-6 col-xs-12 unit_select">
                                        <p>Product Name</p>
                                            <input type="text"
                                                   id="title"
                                                   class=""
                                                   value=""
                                                   required
                                                   name="title">
                                    </div>
                                    <div class="col-lg-4 col-sm-6 col-md-6 col-xs-12 unit_select">
                                        <p>Product Price</p>
                                            <input type="text"
                                                   id="price"
                                                   class=""
                                                   value=""
                                                   required
                                                   name="price">
                                    </div>
                                    <div class="col-lg-4 col-sm-6 col-md-6 col-xs-12 unit_select">
                                        <p>SKU</p>
                                            <input type="text"
                                                   id="sku"
                                                   class=""
                                                   value=""
                                                   required
                                                   name="sku">
                                    </div>
                                    <div class="col-lg-4 col-sm-6 col-md-6 col-xs-12 unit-button">
                                <button form="product_form" type="submit" class="btn btn-success btn_add" {{--data-dismiss="modal"--}}>Save Changes</button>
                                </div>
                                </div>
                                
                            </form>
                        </div>
                        <div id="menu2" class="tab-pane fade col-xs-12">
                            <h3>Subscription</h3>
                            <p>Some content in menu 1.</p>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>


@endsection

@section('script')

    <script src="{{ asset('js/ajs/product_status.js') }}"></script>
    <script src="{{ asset('js/ajs/popup_product.js') }}"></script>

    <script>
        $('.btn_add').on('submit', function (e) {
            console.log(e);
        })
    </script>

@endsection