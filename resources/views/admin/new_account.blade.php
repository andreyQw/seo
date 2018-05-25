{{-- Modal --}}
<div class="modal fade" id="newAccount" tabindex="-1" role="dialog" aria-labelledby="new_account_label" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="new_account_label">Add New Account</h4>
            </div>

            <div class="modal-body">

                <form action="{{ route('account.manager.add') }}" method="POST" enctype="multipart/form-data">

                    {{ csrf_field() }}

                    <div class="row">
                        <div class="col-md-2 col-xs-12 form-group photo-company">

                            <label class="photo_load" for="photo">
                              <div class="account-photo-new" id="load_photo_acc" style="background-image: url('{{asset('img/user_anonim.png')}}')">

                              </div>
                                <!-- <img src="{{asset('img/user_anonim.png')}}" id="load_photo_acc" alt=""> -->
                                <input accept="image/jpeg,image/png" id="photo" value=""
                                       name="photo" type="file" class="form-control">
                            </label>

                        </div>

                          <div class="col-md-10 col-xs-12 nopadding-left">
                            <div class="row">
                                <div class="form-group col-md-6 col-xs-12 cell">
                                   <div class="col-md-6">
                                    <label for="name">Company Name</label>
                                    </div>
                                    <div class="col-md-6">
                                    <input required type="text" name="name" id="name" class="form-control">
                                    </div>
                                </div>
                                <div class="form-group col-md-6 col-xs-12 cell">
                                     <div class="col-md-6">
                                    <label for="stage">Client Stage</label>
                                    </div>
                                    <div class="col-md-6">
                                    <select name="stage" id="stage" class="form-control">
                                        <option value="Hot Lead">Hot Lead</option>
                                        <option value="Warn Lead">Warn Lead</option>
                                        <option value="Cold Lead">Cold Lead</option>
                                        <option value="Active Client">Active Client</option>
                                        <option value="Inactive Client">Inactive Client</option>
                                        <option value="Account on Hold">Account on Hold</option>
                                        <option value="Unhappy Client">Unhappy Client</option>
                                    </select>
                                    </div>

                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group col-md-6 col-xs-12 cell">

                                  <div class="col-md-6">
                                    <label for="client_type">Client Type</label>
                                    </div>
                                    <div class="col-md-6">
                                    <select name="client_type" id="client_type" class="form-control">
                                        <option value="0">Agency</option>
                                        <option value="1">Business Owner</option>
                                        <option value="2">Passive Income</option>
                                    </select>
                                    </div>



                                </div>
                                <div class="form-group col-md-6 col-xs-12 cell">

                                  <div class="col-md-6">
                                    <label for="no_staff">Number of Staff</label>
                                    </div>
                                    <div class="col-md-6">
                                    <select name="no_staff" id="no_staff" class="form-control">
                                        <option value="10">1-10</option>
                                        <option value="25">11-25</option>
                                        <option value="50">26-50</option>
                                        <option value="0">50+</option>
                                    </select>
                                    </div>


                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-6 col-xs-12 cell">
                                   <div class="col-md-6">
                                    <label for="email">E-mail</label>
                                    </div>
                                    <div class="col-md-6">
                                    <input type="email" required class="form-control" name="email" id="email">
                                    </div>
                                </div>
                                <div class="form-group col-md-6 col-xs-12 cell">
                                   <div class="col-md-6">
                                    <label for="no_websites">Number of Websites</label>
                                    </div>
                                    <div class="col-md-6">
                                    <select name="no_websites" id="no_websites" class="form-control">
                                        <option value="5">1-5</option>
                                        <option value="15">6-10</option>
                                        <option value="20">11-20</option>
                                        <option value="50">21-50</option>
                                        <option value="0">50+</option>
                                    </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-6 col-xs-12 cell">
                                  <div class="col-md-6">
                                    <label for="phone">Phone</label>
                                    </div>
                                    <div class="col-md-6">
                                    <input required placeholder="Example: 0800123456789" pattern="[0-9]{6,18}" type="phone" class="form-control" name="phone" id="phone">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3 col-xs-6 nopadding">
                                    <button type="submit" class="btn btn-success btn-add-account">Add Account</button>
                                </div>
                            </div>
                        </div>
                    </div>

                </form>

            </div>
        </div>
    </div>
</div>
