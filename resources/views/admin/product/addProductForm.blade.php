
@extends('layouts.dashboard_layout')

@section('content')

    <div class="col-md-10">
        <form method="POST" action="{{ $action }}" enctype="multipart/form-data">
            {{ csrf_field() }}
            <div class="row">
                <div class="form-group">
                    <label for="title" class="col-md-2 control-label">Product Title</label>
                    <div class="col-md-8">
                        <input id="title"
                               type="text"
                               class="form-control"
                               name="title"
                               value="{{ isset($product) ? $product->title : old('title') }}"
                               required>
                    </div>
                </div>
            </div>
            <div class="row">
                @if ($errors->has('title'))
                    <span class="help-block alert-danger">
                        <strong>{{ $errors->first('title') }}</strong>
                    </span>
                @endif
            </div>
            <div class="row">
                <div class="form-group">
                    <label for="price" class="col-md-2 control-label">Price</label>
                    <div class="col-md-8">
                        <input id="price"
                               type="text"
                               class="form-control"
                               name="price"
                               value="{{ isset($product) ? $product->price : old('price') }}"
                               required>
                    </div>
                </div>
            </div>
            <div class="row">
                @if ($errors->has('price'))
                    <span class="help-block alert-danger">
                        <strong>{{ $errors->first('price') }}</strong>
                    </span>
                @endif
            </div>
            <div class="row">
                <div class="form-group">
                    <label for="sku" class="col-md-2 control-label">SKU</label>
                    <div class="col-md-8">
                        <input id="sku"
                               type="text"
                               class="form-control"
                               name="sku"
                               value="{{ isset($product) ? $product->sku : old('sku') }}"
                               required>
                    </div>
                </div>
            </div>
            <div class="row">
                @if ($errors->has('sku'))
                    <span class="help-block alert-danger">
                        <strong>{{ $errors->first('sku') }}</strong>
                    </span>
                @endif
            </div>

            <div class="form-group">
                <div class="col-md-8">
                    <button type="submit" class="btn btn-primary btn-addRestar">
                        save
                    </button>
                    <a href="{{ route('productList') }}" class="btn btn-primary btn-tabl">Back</a>
                </div>
            </div>
        </form>
    </div>
@endsection