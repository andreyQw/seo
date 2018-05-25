@extends('layouts.dashboard_layout')

@section('name', 'User Manager')

@section('button_navbar')

    @hasanyrole('super_admin|admin')
    <div class="dropdown navbar-right navbar-nav nav">
        <button type="button" class="btn btn-default navbar-btn nav_btn_create_user dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
            <span class="glyphicon glyphicon-plus-sign"></span>Create New
        </button>
        <div class="dropdown-menu dropdown-menu-center create_user_cont">
            <div class="close"><img src="img/close.png" alt=""></div>
            <ul class="nav nav-tabs ex_scroll" id="create_menu_tabs" role="menu">
                <li class="active tab_create_user"><a href="#contact" data-toggle="tab">Contact</a></li>
                <li class="tab_create_user"><a href="#campaigns" data-toggle="tab">Account</a></li>
            </ul>
            <div class="tab-content" data-spy="scroll" data-target="ex_scroll">
                <div class="tab-pane" id="contact">
                    <form action="{{ route('createUser') }}" method="POST" enctype="multipart/form-data" id="new_user_data">
                        {{ csrf_field() }}

                        <div class="form-group">
                            <label class="file_to_load" for="photo">
                                <img src="img/user_anonim.png" id="load_photo_user" alt="">
                                <span id="descript_upload">Upload photo</span>
                                <input accept="image/jpeg,image/png" id="photo" value="Upload Photo" name="photo" type="file" class="form-control">
                            </label>
                        </div>
                        <div class="form-group">
                            <label for="first_name">First Name</label>
                            <input id="first_name" name="first_name" required type="text" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="last_name">Last Name</label>
                            <input id="last_name" name="last_name" required type="text" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="email">E-mail</label>
                            <input id="email" name="email" type="email" class="form-control">
                        </div>
                        <div class="checkbox">
                            <label for="with_user" id="check_user_mail"><input type="checkbox" name="with_user" id="with_user" check="0"> Email credentials to user</label>
                        </div>
                        <div class="form-group">
                            <label for="name">User Name</label>
                            <input id="user_name" name="name" type="text" class="form-control" value="">
                        </div>
                        <div class="form-group">
                            <label for="password">Password <a href="#" id="generate_pass">(Generate)</a></label>
                            <input id="password" name="password" required type="text" class="form-control creat_new_pass" value="">
                        </div>
                        <div class="form-group">
                            <label for="role">Type User</label>
                            <select name="role" id="role">

                                @role('super_admin')
                                <option value="super_admin">Super Admin</option>
                                <option value="admin">Admin</option>
                                <option value="pm">Project Manager</option>
                                <option value="production">Production Manager</option>
                                <option value="partner">Partner Manager</option>
                                <option value="writer">Content Writer</option>
                                <option value="editor">Content Editor</option>
                                <option value="client">Client</option>
                                @endrole

                                @role('admin')
                                <option value="pm">Project Manager</option>
                                <option value="production">Production Manager</option>
                                <option value="partner">Partner Manager</option>
                                <option value="writer">Content Writer</option>
                                <option value="editor">Content Editor</option>
                                <option value="client">Client</option>
                                @endrole

                            </select>
                        </div>
                        <button class="btn btn-default btn_next" type="submit">Next <img src="img/next_icon.png" id="next_icon"/></button>
                    </form>
                </div>

                <div class="tab-pane" id="campaigns">

                    <form action="" id="camaigns_form">
                        <div class="websites_add" id="projs_inaccessible">
                            <p class="access_name">Inaccessible</p>
                            <input type="search" placeholder="Search" name="search_ws" class="search_projs_in">
                            <div class="websites_lists">
                                @if(count($accounts))
                                    @foreach($accounts as $account)
                                        <div class="project_node"><span class="doit">+</span><span id="{{ $account->id }}" class="access">{{ $account->name }}</span></div>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                        <div class="websites_add" id="projs_accessible">
                            <p class="access_name">Accessible</p>
                            <input type="search" placeholder="Search" class="search_projs_ac">
                            <div class="websites_lists">

                            </div>
                        </div>

                        <button class="btn btn-default btn_save_new_user" type="submit"><span class="glyphicon glyphicon-plus-sign"></span>Save</button>
                    </form>

                </div>
            </div>

        </div>
    </div>
    @endhasanyrole

@endsection


@section('content')

<div class="placeholder">
    <div class="modal fade" id="myModal" tabindex="1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel">Client Info</h4>
                </div>
                <div class="modal-body" id="">

                        <ul class="nav nav-tabs info_user_tabs" role="menu">
                            <li class="user_info active"><a href="#info" data-toggle="tab">Info</a></li>
                            <li class="user_info"><a href="#websites" data-toggle="tab">Websites</a></li>
                        </ul>

                        <div class="tab-content">
                            <div class="tab-pane" id="info" style="width: 484px;">



                                <div class="alert alert-danger edit_error"></div>

                                <div style="display: block; min-height: 192px;">

                                    <div class="photo custom-photo-user" style="background-image: url();">

                                    </div>

                                    <div class="info">
                                        <p id="full_name_modal"></p>
                                        <p id="role_modal" class="for_edit"></p>
                                        <div class="phone row" style="margin: 0; max-width: 180px;">
                                            <span style="background-image: url({{asset('img/phone_number_icon.png')}}); background-repeat: no-repeat; background-position: center left; width: 20px; height: 20px; display: block; float: left"></span>
                                            <div style="float: left; margin-left: 10px; max-width: 148px;">
                                                <p style="font-size: 14px; font-family: 'Helvetica Neue Medium'; color: black; margin-bottom: 0;">Phone Number</p>
                                                <p id="phone_modal" class="for_edit"></p>
                                            </div>
                                        </div>
                                        <div class="email row" style="margin: 0; max-width: 180px;">
                                            <span style="background-image: url({{asset('img/email_address_icon.png')}}); background-repeat: no-repeat; background-position: center left; width: 20px; height: 20px; display: block; float: left"></span>
                                            <div style="float: left; margin-left: 10px; max-width: 148px;">
                                                <p style="font-size: 14px; font-family: 'Helvetica Neue Medium'; color: black; margin-bottom: 0;">Email Address</p>
                                                <p id="email_modal" class="for_edit"></p>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="delete_edit">
                                        <span id="delete" style="background-image: url({{asset('img/delete_user_icon.png')}});"></span>
                                        <span id="edit" class="glyphicon glyphicon-pencil"></span>
                                    </div>
                                </div>


                            </div>
                            <div class="tab-pane" id="websites">

                                <div class="websites_add" id="inaccessible">
                                    <p class="access_name">Inaccessible</p>
                                    <input type="search" placeholder="Search" class="search_websites_in">
                                    <div class="websites_list">

                                    </div>
                                </div>
                                <div class="websites_add" id="accessible">
                                    <p class="access_name">Accessible</p>
                                    <input type="search" placeholder="Search" class="search_websites_ac">
                                    <div class="websites_list">

                                    </div>
                                </div>

                            </div>
                        </div>

                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" id="change_user_information" tabindex="1" role="dialog" aria-labelledby="info_modal_label" aria-hidden="true" style="overflow-y: scroll;">
        <div class="modal-dialog info_modal_dialog">
            <div class="modal-content">
                <div class="modal-header info_modal_header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title info_modal_title" id="info_modal_label">Edit</h4>
                </div>
                <div class="modal-body info_modal_body" id="">

                    <form action="{{ route('edit') }}" method="POST" enctype="multipart/form-data" id="change_user_info">

                        {{ csrf_field() }}
                        <div class="form-row">
                            <div class="col-md-6 form-group">
                                <label class="file_to_load" for="photo">
                                  <div class="edit_photo_user" id="load_photo_user" style="background-image: url()"></div>
                                    <!-- <img src="" id="load_photo_user" class="edit_photo_user" alt=""> -->
                                    <span id="descript_upload">Upload photo</span>
                                    <input accept="image/jpeg,image/png" id="photo" value="Upload Photo" name="photo" type="file" class="edit_user form-control">
                                </label>
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="first_name">First Name</label>
                                <input type="text" class="form-control edit_user" name="first_name" required id="first_name">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-md-6 form-group">
                                <label for="last_name">Last Name</label>
                                <input type="text" class="form-control edit_user" name="last_name" required id="last_name">
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="email">E-mail</label>
                                <input type="text" class="form-control edit_user" name="email" required id="email">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-md-6 form-group">
                                <label for="name">User Name</label>
                                <input type="text" class="form-control edit_user" name="name" id="name">
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="phone">Phone</label>
                                <input type="text" class="form-control edit_user" name="phone" id="phone">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-md-6 form-group">
                                <label for="new_password">Change Password <a href="#" id="generate_password">(Generate)</a></label>
                                <input type="text" class="form-control edit_user" name="new_password" id="new_password">
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="role">Role Type</label>
                                <select name="role" id="role" class="form-control edit_user">
                                    @role('super_admin')
                                    <option value="super_admin">Super Admin</option>
                                    <option value="admin">Admin</option>
                                    <option value="pm">Project Manager</option>
                                    <option value="production">Production Manager</option>
                                    <option value="partner">Partner Manager</option>
                                    <option value="writer">Content Writer</option>
                                    <option value="editor">Content Editor</option>
                                    <option value="client">Client</option>
                                    @endrole

                                    @role('admin')
                                    <option value="pm">Project Manager</option>
                                    <option value="production">Production Manager</option>
                                    <option value="partner">Partner Manager</option>
                                    <option value="writer">Content Writer</option>
                                    <option value="editor">Content Editor</option>
                                    <option value="client">Client</option>
                                    @endrole
                                </select>
                            </div>
                        </div>

                        <input type="hidden" name="id" value="" class="edit_user">

                    </form>

                </div>

                <div class="modal-footer">
                    <button type="submit" form="change_user_info" class="btn btn-default">Save</button>
                </div>
            </div>
        </div>
    </div>


     @if ($errors->has('first_name'))
            <div class="alert alert-danger">{{ $errors->first('first_name') }}</div>
        @endif

        @if ($errors->has('last_name'))
            <div class="alert alert-danger">{{ $errors->first('last_name') }}</div>
        @endif

        @if ($errors->has('email'))
            <div class="alert alert-danger">{{ $errors->first('email') }}</div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        @if ($errors->has('password'))
            <div class="alert alert-danger">{{ $errors->first('password') }}</div>
        @endif

        @if ($errors->has('role'))
            <div class="alert alert-danger">{{ $errors->first('role') }}</div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif



    <div class="col-md-12 search_block">
        <div class="textsearch_user">Search Users</div>
        <div class="input-group-lg search_input_group" style="width: 88%;">
            <input class="form-control search_input" id="search" type="search" placeholder="Enter user name" >
            <span class="input-group-btn">
                <button class="btn btn-default search_button" type="button"><span class="glyphicon glyphicon-search"></span></button>
            </span>
        </div>
    </div>





    <div class="row" style="padding-left: 8px; padding-right: 8px;">
    @foreach($users as $user)

                <div class="container_user">
                        <div class="thumbnail user_manager_info_cont btn" id="{{ $user->id }}" data-toggle="modal" data-target="#myModal">
                           <div class="col-lg-12 custom-photo-user" style="background-image: url({{ asset('storage/photo_users/' . $user->photo) }});">
                            </div>
                            <div class="caption">
                                <p id="full_name_user"> {{ ucfirst($user->first_name) . ' ' . ucfirst($user->last_name) }} </p>
                                <p id="role_user"> {{ $user->getRoleNames()[0] }} </p>
                                <p id="online_ago_user">
                                        {{ $user->last_activity() }}
                                </p>
                            </div>
                        </div>

                </div>

    @endforeach
    </div>
</div>

@endsection

@section('script')

    <script type="text/javascript" src="/js/jmouse.js"></script>
    <script type="text/javascript" src="/js/mousescroll.js"></script>
    <script type="text/javascript" src="/js/jquery.scrollpane.min.js"></script>

    <script>

        function search_acc(list, val) {

            console.log(list.children());

            jQuery.each(list.children(), function () {
                var res = $(this.lastChild).text().toLowerCase().indexOf(val.toLowerCase());
                if(res == -1){
                    $(this).hide();
                }else{
                    $(this).show();
                };
            });

        };

        $('.search_projs_in').on('input', function (e) {

             var list = $('#projs_inaccessible .websites_lists');
             search_acc(list, e.currentTarget.value);

        });

        $('.search_projs_ac').on('input', function (e) {

            var list = $('#projs_accessible .websites_lists');
            search_acc(list, e.currentTarget.value);

        });

        $('.search_websites_in').on('input', function (e) {

            var list = $('#inaccessible .websites_list');
            search_acc(list, e.currentTarget.value);

        });

        $('.search_websites_ac').on('input', function (e) {

            var list = $('#accessible .websites_list');
            search_acc(list, e.currentTarget.value);

        });



        // PASSWORD GENERATOR
        $(document).ready(function() {
            function str_rand() {
                var result       = '';
                var words        = '0h4FGHxyzABk567deNOPQi89abcjrstuvwCDElmn123fgopqIJKLMRSTUWQXVZ';
                var max_position = words.length - 1;
                for( i = 0; i < 16; ++i ) {
                    position = Math.floor ( Math.random() * max_position );
                    result = result + words.substring(position, position + 1);
                }
                return result;
            }
            $('#generate_pass').click(function() {
                $('#password').attr('value', str_rand());
            });
            $('#generate_password').click(function() {
                $('#new_password').attr('value', str_rand());
            });
        });

        // DROPDOWN
        $(document).on('click.bs.dropdown.data-api', '#create_menu_tabs', function (e) {
            e.stopPropagation();
        });

        $('body').scrollspy({ target: '.navbar-example' });


        $('#create_menu_tabs a[href="#campaigns"]').tab('show');
        $('#create_menu_tabs a[href="#contact"]').tab('show');


        // PREVIEW LOAD FILE
        function readURL(input) {
            if (input.files && input.files[0]) {
                console.log(input.files[0]);
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#load_photo_user').attr('src', e.target.result);
                }

                reader.readAsDataURL(input.files[0]);
            }
        };

        $("#photo").change(function(){
            readURL(this);
        });


        // TAB ADD WEBSITES WITH NEW USER
        $('.btn_next').on('click', function (e) {

            e.preventDefault();

            $('.tab_create_user a[href="#campaigns"]').tab('show');

        });

        $('.btn_save_new_user').on('click', function (e) {

            e.preventDefault();

            $('#new_user_data').submit();

        })


        // MODAL FIND FULL INFORMATION WITH USER
        $('.user_manager_info_cont').on('click', function (e) {
            var id = $(e.currentTarget).attr('id');
            $.ajax({
                method: 'POST',
                url: '/user/card',
                data: {
                    'id': id,
                    '_token': $('meta[name="csrf-token"]').attr('content'),
                },
                success: function (data) {
                    /*$('#photo_user_modal').attr('src', 'storage/photo_users/' + data.user.photo);*/
                    $('.photo').css('backgroundImage', 'url(/storage/photo_users/' + data.user.photo + ')');

                    $('#full_name_modal').html(data.user.first_name + ' ' + data.user.last_name);
                    $('#role_modal').html(data.role);
                    $('#phone_modal').html(data.user.phone);
                    $('#email_modal').html(data.user.email);
                    $('.modal-body').attr('id', id);
                    $('#edit').attr('class', '');
                    $('#edit').attr('class', 'glyphicon glyphicon-pencil');
                    $('.edit_error').text('').hide();

                    $('#inaccessible .websites_list').html('');

                    data.inaccess.forEach(function (item, i, arr) {

                        $('#inaccessible .websites_list').prepend('<div class="site_node"><span class="doit">+</span><span id="'+ item['id'] +'" class="access">' + item['name'] + '</span></div>');

                    });

                    $('#accessible .websites_list').html('');

                    data.access.forEach(function (item, i, arr) {

                        $('#accessible .websites_list').prepend('<div class="site_node"><span class="doit">-</span><span id="'+ item['id'] +'" class="access">' + item['name'] + '</span></div>');

                    });

                    if((data.role == 'super_admin' && data.per == 1) || (data.role == 'admin' && data.per == 1) || (data.role == 'super_admin' && data.per == 0)){
                        $('.delete_edit').hide();
                        $('.user_info a[href="#websites"]').hide();
                        $('.websites_list').off('click', edit_sites_modal);
                    }else{
                        $('.delete_edit').show();
                        $('.user_info a[href="#websites"]').show();
                        $('.websites_list').on('click', edit_sites_modal);
                    }

                    if(data.role == 'super_admin' || data.role == 'admin'){
                        $('.user_info a[href="#websites"]').hide();
                        $('.websites_list').off('click', edit_sites_modal);
                    }

                    $('.user_info a[href="#info"]').tab('show');

                },
                error: function (err) {
                    console.log(err);
                }
            })
        });
        $('.user_info a[href="#websites"]').tab('show');
        $('.user_info a[href="#info"]').tab('show');


        // DELETE USER
        $('#delete').on('click', function (e) {

            var user_name = $('#full_name_modal').text();
            var delete_user = confirm('Delete user ' + user_name + '?');

            if(!delete_user){
                return;
            }

            var id = $('.modal-body').attr('id');
            $.ajax({
                method: 'POST',
                url: '/user/delete',
                data: {
                    'id': id,
                    '_token': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (data) {
                    location.reload();
                },
                error: function (err) {
                    console.log(err);
                }
            });

        });

        $('#edit').on('click', function (e) {

            $('#myModal').modal('hide');

            var id = $('.modal-body').attr('id');

            $.ajax({
                method: 'POST',
                url: '/user/info',
                data: {
                    '_token': $('meta[name="csrf-token"]').attr('content'),
                    'id': id
                },
                success: function (data) {
                    jQuery.each($('.edit_user'), function () {
                        if(this.tagName == 'SELECT'){
                            for (var i = 0; i < this.options.length; i++){
                                if(this.options[i].value == data.role){
                                    this.options[i].selected = true;
                                    continue;
                                }
                                this.options[i].selected = false;
                            }
                            return;
                        }

                        if(this.name == 'photo'){
                            this.value = '';
                            // $($(this).parent()).children()[0].setAttribute('src', '/storage/photo_users/' + data.user[this.name]);
                            $($($(this).parent()).children()[0]).css('background-image', "url('/storage/photo_users/"+ data.user[this.name] + "')")

                            return;
                        }

                        if(this.name == 'new_password'){
                            return;
                        }

                        this.value = data.user[this.name];
                    });

                    $('#change_user_information').modal('show');
                }
            })

        });

        // EDIT INFO USER
        /*$('#edit').on('click', function (e) {

            var edits = $('.for_edit');

            if($(e.currentTarget).attr('class') == 'glyphicon glyphicon-pencil'){

                jQuery.each(edits, function () {

                    var id_item = $(this).attr('id');

                    if($(this).text() != ''){
                        console.log('yes');
                    }

                    if(id_item == 'role_modal'){

                        var role = $(this).text();

                        $(this).empty();

                        var select_role = $('#role').clone();

                        $(this).prepend(select_role);
                        $(select_role).attr('name', id_item);
                        $(select_role).attr('id', '');
                        $(select_role).attr('class', 'edit_role_select');
                        $('select[name=' + id_item + '] option[value="' + role + '"]').prop('selected', true);
                        return;
                    }

                    var text = $(this).text();
                    $(this).empty();

                    $(this).html('<input type="text" value="' + text + '" name="' + id_item + '" class="edit_user_input" required>');

                });

                $(e.currentTarget).attr('class', '');
                $(e.currentTarget).attr('class', 'glyphicon glyphicon-ok');

            }else if($(e.currentTarget).attr('class') == 'glyphicon glyphicon-ok'){

                var edit_info = new Object();

                jQuery.each(edits, function () {

                    var id_item = $(this).attr('id');

                    edit_info[id_item] = (id_item == 'role_modal') ? $('select[name=' + id_item + '] :selected').val()
                                                                   : $('input[name=' + id_item + ']').val();

                });

                edit_info['id'] = $('.modal-body').attr('id');
                edit_info['_token'] = $('meta[name="csrf-token"]').attr('content');

                $.ajax({
                    method: 'POST',
                    url: '/user/edit',
                    data: edit_info,
                    success: function (data) {
                        console.log(data);
                        if(data.error){
                            $('.edit_error').text(data.error).show();
                        }else{
                            $('.edit_error').text(data.error).hide();

                            jQuery.each(edits, function () {

                                var id_item = $(this).attr('id');

                                if(id_item == 'role_modal'){
                                    $('select[name=' + id_item + '] :selected').detach();
                                    $(this).text(edit_info[id_item]);
                                    return;
                                }

                                $('input[name=' + id_item + ']').detach();
                                $(this).text(edit_info[id_item]);

                            });

                            $(e.currentTarget).attr('class', '');
                            $(e.currentTarget).attr('class', 'glyphicon glyphicon-pencil');
                        }
                    },
                    error: function (err) {
                        console.log(err);
                    }
                });

                console.log(edit_info);

            }

        });*/


        // SEARCH USER
        $('.search_block input[type=search]').on('input', function (e) {

            if(e.target.value === ''){
                $('.container_user').show();
            }else{
                var el_arr = $('.container_user');
                var search_str = e.target.value;

                var search_arr = [];
                var posPre = 0;
                var posPost = 0;
                while(true){
                    var foundPos = search_str.indexOf(' ', posPost);
                    if (foundPos == -1){
                        if(search_str.substring(posPre) == "") break;
                        search_arr.push(new RegExp(search_str.substring(posPre), 'i'));
                        break;
                    }

                    posPost = foundPos + 1;
                    if(search_str.substring(posPre, foundPos) == ""){
                        posPre = posPost;
                        continue;
                    }
                    search_arr.push(new RegExp(search_str.substring(posPre, foundPos), 'i'));
                    posPre = posPost;
                }

                jQuery.each(el_arr, function () {

                    var one = $(this).children('.user_manager_info_cont');
                    var two = $(one).children('.caption');
                    var name_text = $(two).children('#full_name_user').text();

                    if(search_arr.length == 0) return;

                    for (var i = 0; i < search_arr.length; i++) {

                        if(name_text.match(search_arr[i]) == null){
                            $(this).hide();
                            break;
                        }else{
                            $(this).show();
                        }

                    };

                })
            }

        });


        // EDIT SITES WITH USER
        var edit_sites_modal = function (e) {

            e.preventDefault();

            $('.websites_list').off('click', edit_sites_modal);

            console.log(1);

            var curTarget = $(e.currentTarget);
            var do_is = curTarget.attr('class');

            if(do_is == $(e.target).attr('class') || $(e.target).attr('class') == 'site_node'){
                return;
            };

            var inaccessible = 'inaccessible';
            var accessible = 'accessible';
            var parentEl = $(e.target)[0].parentElement;

            switch (curTarget.parent().attr('id')){

                case inaccessible:
                    addOrDeleteSiteWithUser(parentEl, '#accessible', '-', do_is);
                    break;

                case accessible:
                    addOrDeleteSiteWithUser(parentEl, '#inaccessible', '+', do_is);
                    break;

                default:
                    return;

            };

        };

        function addOrDeleteSiteWithUser (parentEl, nextTarget, doit, do_is) {

            var doitSpan = $(parentEl)[0].firstChild;
            var data = new Object();
            data['acc_id'] = $($(parentEl)[0].lastChild).attr('id');
            data['user_id'] = $('.modal-body').attr('id');
            data['_token'] = $('meta[name="csrf-token"]').attr('content');

            console.log(data);

            if(doit == '-'){
                $.ajax({
                    method: 'POST',
                    url: '/user/sites/add',
                    data: data,
                    async: false,
                    success: function (data) {
                        console.log(data);
                        $(doitSpan).empty().text(doit);

                        $(parentEl).detach().prependTo(nextTarget + ' .' + do_is);
                    },
                    error: function (err) {
                        console.log(err);
                    }
                });
            }else if(doit == '+'){
                $.ajax({
                    method: 'POST',
                    url: '/user/sites/delete',
                    data: data,
                    success: function (data) {
                        console.log(data);
                        $(doitSpan).empty().text(doit);

                        $(parentEl).detach().prependTo(nextTarget + ' .' + do_is);
                    },
                    error: function (err) {
                        console.log(err);
                    }
                });
            };

            $('.websites_list').on('click', edit_sites_modal);

        }




        // ADD SITES WITH NEW USER
        function addOrDeleteSiteWithNewUser (parentEl, nextTarget, doit, do_is) {

            var doitSpan = $(parentEl)[0].firstChild;
            var id_acc = $($(parentEl)[0].lastChild).attr('id');

            $(doitSpan).empty().text(doit);

            $(parentEl).detach().prependTo(nextTarget + ' .' + do_is);

            if(doit == '-'){
                $('#new_user_data').append('<input type="hidden" name="accounts_access[]" id="' + id_acc + '" value="' + id_acc + '">');
            }else if(doit == '+'){
                $('input[type=hidden]#' + id_acc).detach();
            }

        }

        $('.websites_lists').on('click', function (e) {

            e.preventDefault();

            var curTarget = $(e.currentTarget);
            var do_is = curTarget.attr('class');

            if(do_is == $(e.target).attr('class') || $(e.target).attr('class') == 'project_node'){
                return;
            };

            var inaccessible = 'projs_inaccessible';
            var accessible = 'projs_accessible';
            var parentEl = $(e.target)[0].parentElement;

            switch (curTarget.parent().attr('id')){

                case inaccessible:
                    addOrDeleteSiteWithNewUser(parentEl, '#projs_accessible', '-', do_is);
                    break;

                case accessible:
                    addOrDeleteSiteWithNewUser(parentEl, '#projs_inaccessible', '+', do_is);
                    break;

                default:
                    return;

            };

        });

        function readURLEdit(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('.edit_photo_user').css('background-image', "url('"+ e.target.result + "')");
                }

                reader.readAsDataURL(input.files[0]);
            }
        };

        $(".edit_user").change(function(){
            readURLEdit(this);
        });

        /*$('.websites_list').jScrollPane({
            showArrows: true,
            contentWidth: 226
        });*/


    </script>

@endsection
