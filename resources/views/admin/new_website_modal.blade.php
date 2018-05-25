{{-- Modal --}}
<div class="modal fade nopadding" id="newWebsite" tabindex="-1" role="dialog" aria-labelledby="new_website_label" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="new_website_label">Add Websites</h4>
            </div>

            <ul class="nav nav-tabs modal-tabs" role="menu">
                <li class="new_website_tab active"><a href="#info" data-toggle="tab">Info</a></li>
                <li class="new_website_tab"><a href="#bio" data-toggle="tab">Bio</a></li>
                <li class="new_website_tab"><a href="#la" data-toggle="tab">Link & Anchors</a></li>
            </ul>

            <div class="modal-body">

                <div class="tab-content">

                    <div class="tab-pane" id="info">

                        <div class="alert alert-danger err_info" style="display: none;"></div>

                        <form action="{{ route('websites.store') }}" method="POST" id="new_website" enctype="multipart/form-data">

                            {{ csrf_field() }}

                            <div class="col-md-12 nopadding">
                                <div class="form-group col-md-6">
                                    <label for="url">Website URL</label>
                                    <input id="url" pattern="[A-Za-z0-9-_]+\.[A-Za-z0-9-_\.]+$" name="url" class="form-control" type="text">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="company">Company</label>
                                    <select name="company" id="company" class="form-control">
                                        <option value="" disabled selected hidden>Company</option>
                                        @foreach($accounts as $account)

                                            <option value="{{ $account->id }}">{{ $account->name }}</option>

                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-12 nopadding">
                                <div class="form-group col-md-6">
                                    <label for="niche">Niche</label>
                                    <select name="niche" id="niche" class="form-control">
                                        <option value="" disabled selected hidden>Niche</option>
                                        @foreach($niches as $niche)

                                            <option value="{{ $niche->id }}">{{ $niche->name }}</option>

                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="placements">Number of Placements credits</label>
                                    <input id="placements" name="placements" type="text" min="1" max="1000" value="1" class="form-control">
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4 form-group first-tab-btn">
                                    <button type="submit" class="btn btn-success form-control">Finish</button>
                                </div>
                            </div>

                        </form>

                    </div>

                    <div class="tab-pane" id="bio">

                        {{--<div class="alert alert-danger err_bio" style="display: none;"></div>--}}

                        <div class="row head-bio-tab">
                            <div class="col-md-4 col-xs-6"><p>Enter Bio</p></div>
                            <div class="col-md-8 col-xs-6 form-group">
                                <label for="image">
                                    <p id="name_img_bio">Upload Image</p>
                                    <input form="new_website" type="file" name="image" id="image" class="form-control">
                                </label>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12 form-group">
                                <textarea form="new_website" name="text" class="form-control" style="resize: none;"></textarea>
                            </div>
                        </div>

                    </div>

                    <div class="tab-pane" id="la">

                        {{--<div class="alert alert-danger err_la" style="display: none;"></div>--}}

                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label for="">No Placement</label>
                                <select id="no_placement" class="form-control">
                                    <option value="0" hidden></option>
                                    <option value="1" selected>1</option>
                                </select>
                            </div>
                        </div>

                        <div class="la_dinamic">
                            <div class="row la_cont" id="layout_anchors" style="display: none;">
                                <div class="form-group col-md-12">
                                    <label for="anchor">Anchor Text</label>
                                    <input form="new_website" id="anchor" name="anchor[]" type="text" class="form-control">
                                </div>
                                <div class="form-group col-md-12">
                                    <label for="link">Target URL</label>
                                    <input form="new_website" id="link" name="link[]" pattern="/[A-Za-z0-9-/_]*$" value="" type="text" class="form-control">
                                </div>
                            </div>
                            <div class="row la_cont" id="1">
                                <div class="form-group col-md-12">
                                    <label for="anchor">Anchor Text</label>
                                    <input form="new_website" id="anchor" name="anchor[]" type="text" class="form-control">
                                </div>
                                <div class="form-group col-md-12">
                                    <label for="link">Target URL</label>
                                    <input form="new_website" id="link" name="link[]" pattern="/[A-Za-z0-9-/_]*$" value="" type="text" class="form-control">
                                </div>
                            </div>
                        </div>

                   
                   
                    </div>

                </div>

            </div>
        </div>
    </div>
</div>