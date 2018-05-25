@extends('layouts.dashboard_layout')

@section('name', 'Partner Manager')

@section('button_navbar')

    <div class="dropdown navbar-right navbar-nav nav">

        <button type="button" class="btn btn-default navbar-btn dropdown-toggle header-btn-add-new-partner" data-toggle="dropdown" aria-expanded="true">
            Add new partner<span class="caret"></span>
        </button>

        <div class="dropdown-menu dropdown-menu-center">

            <form action="{{ route('add_partner') }}" role="form" method="POST" enctype="multipart/form-data">

                {{ csrf_field() }}

                <div class="form-row col-md-12 nopadding first-line-mm">
                    <div class="form-group col-md-3 col-sm-3 col-xs-6 nopadding-right">
                        <label for="domain">Domain</label>
                        <input required id="domain" name="domain" class="form-control" type="text" placeholder="www.domain.com" pattern="www\.[A-Za-z0-9-_]+\.[A-Za-z0-9-_\.]+$">
                    </div>
                    <div class="form-group col-md-3 col-sm-3 col-xs-6 nopadding-right">
                        <label for="niche">Niche</label>
                        <select class="form-control" name="niche" id="niche">
                            @foreach($niches as $niche)
                                <option value="{{ $niche->id }}">{{ $niche->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-md-3 col-sm-3 col-xs-6 nopadding-right">
                        <label for="cost">Cost</label>
                        <input required id="cost" step="0.01" name="cost" class="form-control metric" type="number" placeholder="$">
                    </div>
                    <div class="form-group col-md-3 col-sm-3 col-xs-6">
                        <label for="month_placements">No of placement/mo</label>
                        <input class="form-control" type="number" name="no_mo" id="month_placements" min="0" placeholder="No set Limit">
                    </div>
                </div>
                <div class="form-group col-md-12 col-sm-12 col-xs-12 special-notes-mm">
                    <label for="description">Special Notes</label>
                    <textarea class="form-control" name="description" id="description" cols="10" rows="5"></textarea>
                </div>
                <div class="form-row col-md-12 col-sm-12 col-xs-12 nopadding seo-metrics-mm">
                    <p>SEO Metrics</p>
                    <div class="form-group col-md-1 col-sm-3 col-xs-6 nopadding-right">
                        <input required id="metrics" name="dr" placeholder="DR" class="form-control metric" min="0" type="number">
                    </div>
                    <div class="form-group col-md-1 col-sm-3 col-xs-6 nopadding-right">
                        <input required id="metrics" name="tf" placeholder="TF" class="form-control metric" min="0" type="number">
                    </div>
                    <div class="form-group col-md-1 col-sm-3 col-xs-6 nopadding-right">
                        <input required id="metrics" name="cf" placeholder="CF" class="form-control metric" min="0" type="number">
                    </div>
                    <div class="form-group col-md-1 col-sm-3 col-xs-6 nopadding-right da-mm">
                        <input required id="metrics" name="da" placeholder="DA" class="form-control metric" min="0" type="number">
                    </div>
                    <div class="form-group col-md-3 col-sm-3 col-xs-6 nopadding-right">
                        <input required id="metrics" name="traffic" placeholder="Traffic" class="form-control metric" min="0" type="number">
                    </div>
                    <div class="form-group col-md-3 col-sm-3 col-xs-6 nopadding-right">
                        <input required id="metrics" name="ref_domains" class="form-control metric" placeholder="ref.domains" min="0" type="number">
                    </div>
                    <div class="form-group col-md-2 col-sm-6 col-xs-6">
                        <select name="bsi" class="form-control bsi" required>
                            <option value="" disabled selected hidden>BNI</option>
                            @foreach($bsi as $b)
                                <option value="{{ $b->id }}" style="color: {{ $b->name }}; width: 100%; height: 5px;">{{ $b->alias }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-row name-row-mm col-md-12 col-sm-12 col-xs-12">
                    <div class="form-group col-md-4 col-sm-6 col-xs-6 nopadding">
                        <label for="first_name">First Name</label>
                        <input required id="first_name" name="first_name" class="form-control" type="text">
                    </div>
                    <div class="form-group col-md-4 col-sm-6 col-xs-6 nopadding-right">
                        <label for="last_name">Last Name</label>
                        <input required id="last_name" name="last_name" class="form-control" type="text">
                    </div>
                    <div class="form-group col-md-4 col-sm-6 col-xs-6 nopadding-right">
                        <label for="company_name">Company Name</label>
                        <input required id="company_name" name="company_name" class="form-control" type="text">
                    </div>

                    <div class="form-group col-md-4 col-sm-6 col-xs-6 nopadding">
                        <label for="email">Email</label>
                        <input required id="email" name="email" class="form-control" type="email">
                    </div>
                    <div class="form-group col-md-4 col-sm-6 col-xs-6 nopadding-right">
                        <label for="paypal_id">PayPal ID</label>
                        <input required id="paypal_id" name="paypal_id" class="form-control" type="email">
                    </div>
                    <div class="form-group col-md-4 col-sm-6 col-xs-6">
                        <label for="photo_partner">Upload photo</label>
                        <input type="file" id="photo_partner" accept="image/jpeg,image/png" name="photo" style="opacity: 1; position: relative; width: 100%;">
                    </div>
                   </div>

                <div class="form-row col-md-12 col-sm-12 col-xs-12">
                    <div class="col-md-4 col-sm-6 nopadding">
                        <button class="btn btn-default add-partner-btn-mm" type="submit">Add Partner</button>
                    </div>
                </div>

            </form>
        </div>

    </div>

@endsection

@section('content')

    <link rel="stylesheet" href="{{ asset('css/partners.css') }}">
    <link rel="stylesheet" href="{{ asset('css/chosen.css') }}">

    <div class="col-md-12 nopadding">

        <form class="form-horizontal" action="{{ route('partner_search') }}" method="POST">
            {{ csrf_field() }}

            <div class="form-row search_partner_input">
               <div class="col-md-12 col-sm-12 col-xs-12 nopadding">
                <div class="form-group col-md-2 col-sm-2 col-xs-12">
                    <label for="search_partner" class="search-text-mm">Search Here</label>
                </div>
                <div class="form-group col-md-4 col-sm-4 col-xs-6">
                    <input type="text" id="search_partner" class="form-control" name="search">
                </div>

                <div class="col-md-2 col-sm-2 col-xs-6 form-group">
                    <select class="form-control bsi" name="bsi" id="bsi-mm">
                        <option value="0" selected hidden>BNI</option>
                        <option value="0">All</option>
                        @foreach($bsi as $b)
                            <option value="{{ $b->id }}" style="color: {{ $b->name }}; width: 100%; height: 5px;">{{ $b->alias }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group col-md-2 col-sm-2 col-xs-6">
                    <select value="0" class="form-control" name="niche" id="niche">
                        <option value="0" selected hidden>Niche</option>
                        <option value="0">All</option>
                            @foreach($niches as $niche)
                                <option value="{{ $niche->id }}">{{ $niche->name }}</option>
                            @endforeach
                     </select>
                </div>

                <div class="col-md-2 col-sm-2 col-xs-6 form-group">
                    <select class="form-control" name="price" id="price">
                        <option value="0" selected hidden>Price Range</option>
                        <option value="0">All</option>
                        <option value="0-30">0-30</option>
                        <option value="31-59">31-59</option>
                        <option value="60-99">60-99</option>
                        <option value="100-149">100-149</option>
                        <option value="150-199">150-199</option>
                        <option value="200">200+</option>
                    </select>
                </div>



                </div>

            <div class="col-md-offset-2 col-md-12  col-sm-12 col-xs-12 nopadding ">
                <div class="form-group col-md-1 col-sm-3 col-xs-6">
                    <input type="number" min="0" name="dr" class="form-control" placeholder="dr" id="dr-mm">
                </div>
                <div class="form-group col-md-1 col-sm-3 col-xs-6">
                    <input type="number" min="0" name="tf" class="form-control" placeholder="tf" id="tf-mm">
                </div>
                <div class="form-group col-md-1 col-sm-3 col-xs-6">
                    <input type="number" min="0" name="cf" class="form-control" placeholder="cf" id="cf-mm">
                </div>
                <div class="form-group col-md-1 col-sm-3 col-xs-6">
                    <input type="number" min="0" name="da" class="form-control" placeholder="da" id="da-mm">
                </div>
                <div class="form-group col-md-2 col-sm-4 col-xs-6">
                    <input type="number" min="0" name="traffic" class="form-control" placeholder="traffic" id="traffic-mm">
                </div>
                <div class="form-group col-md-2 col-sm-4 col-xs-6">
                    <input type="number" min="0" name="ref_domains" class="form-control" placeholder="ref_domains" id="ref-domains-mm">
                </div>
                 <div class="col-md-2 col-sm-4 col-xs-12 form-group">
                    <button class="btn btn-default search-btn-mm">Search <i class="glyphicon glyphicon-search"></i></button>
                </div>
                </div>
            </div>

        </form>

    </div>
    <div class="wrapper-for-table-mm">
    <table class="table table-bordered table-mm" style="background-color: #fff;">
        <thead style="background-color: #f15e33; color: #fff;">
        <tr>
            <th>Domain</th>
            <th>Niche</th>
            <th>Cost</th>
            <th>No of Placement/Mo</th>
            <th>DR</th>
            <th>TF</th>
            <th>CF</th>
            <th>DA</th>
            <th>Traffic</th>
            <th>Ref. Domains</th>
            <th>Special Notes</th>
            <th>Action</th>
        </tr>
        </thead>
        <tbody>
        @foreach($partners as $partner)

            {{-- MODAL WINDOW --}}
            <div id="edit_partner_modal{{$partner->id}}" class="modal fade">
                <div class="modal-dialog">
                    <div class="modal-content">
                        {{-- Заголовок модального окна --}}
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                            <h4 class="modal-title">Edit Partner</h4>
                        </div>
                        {{-- Основное содержимое модального окна --}}

                        <p id="partner_domain">{{ $partner->domain }}</p>

                        <form action="{{ route('edit_info_partner') }}" role="form" method="POST" id="edit_partner{{$partner->id}}">

                            {{ csrf_field() }}

                            <div class="form-row">
                                <div class="col-md-4 col-xs-6 form-group">
                                    <label for="niche">Niche</label>
                                    <select class="niches form-control" name="niche" id="niches">
                                        @foreach($niches as $niche)
                                            <option value="{{ $niche->id }}" @if($partner->niche()->find($niche->id)) selected @endif>{{ $niche->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-4 col-xs-6 form-group">
                                    <label for="cost">Cost</label>
                                    <input required type="number" min="0" step="0.01" id="cost" name="cost" class="form-control" placeholder="" value="{{ number_format($partner->cost, 2) }}">
                                </div>
                                <div class="col-md-4 col-xs-6 form-group no-placement-mobile-mm">
                                    <label for="no_mo">No placement/Mo</label>
                                    <input type="number" min="0" id="no_mo" name="month_placements" class="form-control no_mo" placeholder="No set Limit" value="{{ $partner->month_placements }}">
                                </div>
                            </div>
                            <div class="form-row content-edit-mm">
                                <div class="col-md-3 col-xs-6 form-group">
                                    <label for="dr">DR</label>
                                    <input required type="number" min="0" id="dr" name="dr" class="form-control" value="{{ $partner->dr }}">
                                </div>
                                <div class="col-md-3 col-xs-6 form-group">
                                    <label for="tf">TF</label>
                                    <input required type="number" min="0" id="tf" name="tf" class="form-control" value="{{ $partner->tf }}">
                                </div>
                                <div class="col-md-3 col-xs-6 form-group">
                                    <label for="cf">CF</label>
                                    <input required type="number" min="0" id="cf" name="cf" class="form-control"  value="{{ $partner->cf }}">
                                </div>
                                <div class="col-md-3 col-xs-6 form-group">
                                    <label for="da">DA</label>
                                    <input required type="number" min="0" id="da" name="da" class="form-control" value="{{ $partner->da }}">
                                </div>
                            </div>
                            <div class="form-row content-edit-mm">
                                <div class="col-md-3 col-xs-6">
                                    <label for="bsi">BNI</label>
                                    <select name="bsi" class="form-control bsi" style="color: {{ $partner->bsi->name }}" required>
                                        @foreach($bsi as $b)
                                            <option @if($b->id == $partner->bsi->id) selected @endif value="{{ $b->id }}" style="color: {{ $b->name }}; width: 100%; height: 5px;">{{ $b->alias }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-3 col-xs-6 form-group">
                                    <label for="traffic">Traffic</label>
                                    <input required type="number" min="0" id="traffic" name="traffic" class="form-control" value="{{ $partner->traffic }}">
                                </div>
                                <div class="col-md-3 col-xs-6 form-group">
                                    <label for="ref_domains">Ref. domains</label>
                                    <input required type="number" min="0" id="ref_domains" name="ref_domains" class="form-control" value="{{ $partner->ref_domains }}">
                                </div>
                                <div class="col-md-12 col-xs-12 form-group">
                                    <label for="description">Special Notes</label>
                                    <textarea class="form-control" name="description" id="description" cols="10" rows="5" value="{{ $partner->description }}">{{ $partner->description }}</textarea>
                                </div>
                            </div>

                            <input type="hidden" value="{{ $partner->id }}" name="id">

                        </form>

                        {{-- Футер модального окна --}}
                        <div class="modal-footer">
                           <div class="col-md-4 col-xs-12 nopadding">
                            <button type="submit" class="btn btn-primary save_editional_partner" form="edit_partner{{$partner->id}}">Save Partner</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {{-- END MODAL WINDOW --}}

            {{-- MODAL WINDOW --}}
            <div id="show_notes_partner{{$partner->id}}" class="modal fade">
                <div class="modal-dialog special-notes-mm">
                    <div class="modal-content">
                        {{-- Заголовок модального окна --}}
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                            <h4 class="modal-title">{{ $partner->domain }}</h4>
                        </div>
                        {{-- Основное содержимое модального окна --}}
                        <h3>Special Notes</h3>
                        <p>{{ $partner->description }}</p>
                    </div>
                </div>
            </div>
            {{-- END MODAL WINDOW --}}

            <tr>
                <td style="border-bottom: 3px solid {{ $partner->bsi->name }};">{{ $partner->domain }}</td>
                <td>
                    {{ $partner->niche->name }}
                </td>
                <td>${{ number_format($partner->cost, 2) }}</td>
                <td>
                    @if($partner->month_placements <= 0)
                        No set Limit
                    @else
                        {{ $partner->month_placements }}
                    @endif
                </td>
                <td>{{ $partner->dr }}</td>
                <td>{{ $partner->tf }}</td>
                <td>{{ $partner->cf }}</td>
                <td>{{ $partner->da }}</td>
                <td>{{ $partner->traffic }}</td>
                <td>{{ $partner->ref_domains }}</td>
                <td data-toggle="modal" data-target="#show_notes_partner{{$partner->id}}"><span>{{ $partner->description }}</span>
                <i class="mdi mdi-plus-circle-outline"></i></td>
                <td id="{{$partner->id}}"><span class="mdi mdi-delete delete_partner"></span><span class="mdi mdi-pencil"  data-target="#edit_partner_modal{{$partner->id}}"></span></td>
            </tr>

        @endforeach
        </tbody>
    </table>

    </div>

@endsection

@section('script')

    <script src="{{ asset('js/chosen.jquery.js') }}"></script>
    <script src="{{ asset('js/chosen.proto.js') }}"></script>
    <script src="{{ asset('js/chosen.jquery.min.js') }}"></script>
    <script src="{{ asset('js/chosen.proto.min.js') }}"></script>

    <script>

        $('.delete_partner').on('click', function (e) {

            var delete_q = confirm('Delete partner?');

            if(!delete_q){
                return;
            }

            var id = e.target.parentNode.getAttribute('id');

            $.ajax({
                method: 'POST',
                url: '/partner/delete',
                data: {
                    '_token': $('meta[name="csrf-token"]').attr('content'),
                    'id': id
                },
                success: function (data) {
                    if(data.error){
                        console.log(data.error);
                        return;
                    }

                    $('#' + id).parent().detach();
                },
                error: function (err) {
                    console.log(err);
                }
            })

        });

        $('.mdi-pencil').click(function (){ 
            var id = $(this).attr('data-target');
            $(id).modal('show');
        });

        $('#month_placements').on('change', function (e) {
            if(e.currentTarget.value == 0){
                e.currentTarget.value = '';
            }
        });

        $('.no_mo').on('change', function (e) {
            if(e.currentTarget.value == 0){
                e.currentTarget.value = '';
            }
        });

        $('.bsi').on('change', function (e) {
            e.currentTarget.style.color = e.target.options[e.target.selectedIndex].style.color;
        });

    </script>

@endsection
