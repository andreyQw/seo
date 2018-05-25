@extends('layouts.dashboard_layout')

@section('name', 'Overview of All Orders')

@section('content')

    <div>
        <diw class="row">
            <div class="col-md-8">
                <h2>Overview</h2>
                <div class="row">
                    <div class="col-md-6">
                        <h3><i class="mdi mdi-coin"></i></h3>
                        <h4>Placements Ordered</h4>
                    </div>
                    <div class="col-md-6">
                        <h3><i class="mdi mdi-link-variant"></i></h3>
                        <h4>Live Placements</h4>
                    </div>

                </div>
                <div class="row">
                    <div class="col-md-3">
                        <h3><i class="mdi mdi-link-variant"></i></h3>
                        <h4>Quality Control</h4>
                    </div>
                    <div class="col-md-3">
                        <h3><i class="mdi mdi-clipboard-text"></i></h3>
                        <h4>Content Writing</h4>
                    </div>
                    <div class="col-md-3">
                        <h3><i class="mdi mdi-link-variant"></i></h3>
                        <h4>Content Sent</h4>
                    </div>
                    <div class="col-md-3">
                        <h3><i class="mdi mdi-link-variant"></i></h3>
                        <h4>Live Ready</h4>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="col-md-12">
                    <h3><i class="mdi mdi-link-variant"></i></h3>
                    <h4>Sales Revenue(Last 24 hours)</h4>
                </div>
                <div class="col-md-12">
                    <h3><i class="mdi mdi-cash-100"></i></h3>
                    <h4>Sales Revenue(Month to Date)</h4>
                </div>
                <div class="col-md-12">
                    <h3><i class="mdi mdi-link-variant"></i></h3>
                    <h4>Total Placements(Month to Date)</h4>
                </div>
            </div>
        </diw>
    </div>


@endsection