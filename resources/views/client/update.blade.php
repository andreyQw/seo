<div class="wrapper-placement-update-mm">
   <div class="modal-header-mm">
    <button type="button" class="close" data-dismiss="modal">&times;</button>
       @if($anchor)
           <h3 class="modal-title">{{$anchor->url}}</h3>
       @else
           <h3 class="modal-title">{{$feeds[0]->project->url}}</h3>
       @endif    {{--<h3 class="modal-title">{{$feeds[0]->project->url}}</h3>--}}
</div>
{{--{!! Form::open(['route' => 'websites.add_partner', 'class' => 'form-horizontal', 'method'=>'POST' ]) !!}--}}
<div class="col-md-12 modal_view">
    <div class="modal-body">
        <div class="row">
            <div class="col-md-12 nopadding">
                <ul class="nav nav-tabs">
                    <li class="active"><a data-toggle="tab" href="#panel1">Updates</a></li>
                   <!-- {--<li><a data-toggle="tab" href="#panel2">NO BS Updates</a></li>--}-->
                </ul>
                <div class="tab-content content-mm">
                    {{--@role('super_admin|admin|pm|client')--}}
                    <div id="panel1" class="tab-pane fade in active">
                        <div class="col-md-12 nopadding">
                            <div class="col-sm-12 col-xs-12 first-block-mm nopadding">
                                @if(Auth::user()->photo != 'user_anonim.png')
                                <div class="user_photo col-md-1 col-sm-6 col-xs-6" style="background-image: url({{ asset('storage/photo_users/' . Auth::user()->photo) }});"></div>
                                @else
                                    @if(Auth::user()->bgc)
                                        <div class="user_photo user_photo-none col-md-1 col-sm-6 col-xs-6" style="background: linear-gradient(to bottom right, {{ unserialize(Auth::user()->bgc)[0] }}, {{ unserialize(Auth::user()->bgc)[1] }})">

                                            <p class="name-user-mm">{{ substr(Auth::user()->first_name, 0, 1) }}</p><p class="surname-user-mm">{{ substr(Auth::user()->last_name, 0, 1) }}</p>
                                        </div>
                                    @else
                                        <div class="user_photo user_photo-none col-md-1 col-sm-6 col-xs-6" style="background: linear-gradient(to bottom right, #{{ dechex(mt_rand(1, 16777215)) }}, #{{ dechex(mt_rand(1, 16777215)) }})">

                                            <p class="name-user-mm">{{ substr(Auth::user()->first_name, 0, 1) }}</p><p class="surname-user-mm">{{ substr(Auth::user()->last_name, 0, 1) }}</p>
                                        </div>
                                    @endif
                                @endif
                                    <div class="col-md-10 col-sm-6 col-xs-9">
                                    {{--<input class="write-updates-mm" type="text" id="search_query" placeholder="Write and Updates">--}}
                                            <select multiple name="recipients[]" id="product" size="2" data-placeholder="Write and Updates" class="create_camp_fields chosen-select form-control">
                                                    @foreach($users as $user)
                                                        <option value="{{ $user->id }}">{{ $user->first_name }} {{ $user->last_name }}</option>
                                                    @endforeach
                                            </select>
                                </div>


                                <div class="col-md-offset-2 col-md-12 underinput-mm">
                                    <div class="col-md-10">
                                        <p>When someone comments on this to-do,
                                            <br> a notification will be sent to</p>
                                        <div class="wrapper-for-stuff-photo">
                                            <div class="photo-under-text-mm" style="background-image: url({{ asset('storage/photo_users/' . Auth::user()->photo) }});">
                                            </div>
                                            <div class="photo-under-text-mm" style="background-image: url({{ asset('storage/photo_users/' . Auth::user()->photo) }});">
                                            </div>
                                            <div class="photo-under-text-mm" style="background-image: url({{ asset('storage/photo_users/' . Auth::user()->photo) }});">
                                            </div>
                                        </div>

                                    </div>
                                </div>
                                <div class="wrapper-for-btn col-md-offset-2 col-md-10">
{!! Form::open(['route' => 'stop_sending', 'class' => 'form-horizontal', 'method'=>'POST' ]) !!}
                                    <button type="submit" class="stop-btn-mm col-md-6 nopadding">Stop Sending me</button>
{!! Form::close() !!}
                                    <button class="add-btn-mm col-md-6 nopadding">Add/Remove People</button>
                                </div>

                            </div>
                            {{--************************--}}
                            <div class="wrapper-for-massage-mm">
        @foreach($feeds as $feed)
                            <div class="massage-block col-md-12">
                                <div class="placement-updates-massage col-md-12 nopadding">
                                    <div class="header-massage-mm col-md-12 nopadding">
                                        @if($feed->user->photo != 'user_anonim.png')
                                            <div class="massage-photo-mm col-md-1" style="background-image: url({{ asset('storage/photo_users/' . $feed->user->photo) }});"></div>
                                        @else
                                            @if($feed->user->bgc)
                                                <div class="user_photo user_photo-none col-md-1 col-sm-6 col-xs-6" style="background: linear-gradient(to bottom right, {{ unserialize($feed->user->bgc)[0] }}, {{ unserialize($feed->user->bgc)[1] }})">

                                                    <p class="name-user-mm">{{ substr($feed->user->first_name, 0, 1) }}</p><p class="surname-user-mm">{{ substr($feed->user->last_name, 0, 1) }}</p>
                                                </div>
                                            @else
                                                <div class="user_photo user_photo-none col-md-1 col-sm-6 col-xs-6" style="background: linear-gradient(to bottom right, #{{ dechex(mt_rand(1, 16777215)) }}, #{{ dechex(mt_rand(1, 16777215)) }})">

                                                    <p class="name-user-mm">{{ substr($feed->user->first_name, 0, 1) }}</p><p class="surname-user-mm">{{ substr($feed->user->last_name, 0, 1) }}</p>
                                                </div>
                                            @endif
                                        @endif
                                            <div class="col-md-10 nopadding-right">
                                            <h4 class="person-name-mm col-md-6 nopadding">{{$feed->user->first_name}} {{$feed->user->last_name}}</h4>
                                            <p class="time-ago-mm col-md-6 nopadding-right"><i class="mdi mdi-clock"></i><span>
                                                    {{\Carbon\Carbon::createFromFormat('Y-m-d H:i:s',$feed->created_at)->diffForHumans(null, true, true)}}
                                                </span> <i class="mdi mdi-arrow-down-bold-circle"></i></p>
                                        </div>
                                    </div>
                                    <div class="col-md-12 insides-massage-mm">
                                        <p>{{$feed->event->title}}</p>
                                        <i class="mdi mdi-link"></i>
                                        <a href="#">{{$feed->project->url}}</a>
                                    </div>
                                    @foreach($feed->update_clients as $comment)
                                        @if($loop->index == 2)
                                            <div id="feed_{{ $feed->id }}" style="display: none;">
                                        @endif
                                    {{--comments--}}
                                        <div class="col-md-offset-1 col-md-11 insides-massage-comment-mm">
                                            <i class="mdi mdi-share col-md-1 comment-mdi-share-mm"></i>
                                            @if($comment->user->photo != 'user_anonim.png')
                                                <div class="massage-photo-comment-mm col-md-1" style="background-image: url({{ asset('storage/photo_users/' . $comment->user->photo) }});"></div>
                                            @else
                                                @if($comment->user->bgc)
                                                    <div class="user_photo user_photo_comment col-md-1 col-sm-6 col-xs-6" style="background: linear-gradient(to bottom right, {{ unserialize($comment->user->bgc)[0] }}, {{ unserialize($comment->user->bgc)[1] }})">

                                                        <p class="name-user-mm">{{ substr($comment->user->first_name, 0, 1) }}</p><p class="surname-user-mm">{{ substr($comment->user->last_name, 0, 1) }}</p>
                                                    </div>
                                                @else
                                                    <div class="user_photo user_photo_comment col-md-1 col-sm-6 col-xs-6" style="background: linear-gradient(to bottom right, #{{ dechex(mt_rand(1, 16777215)) }}, #{{ dechex(mt_rand(1, 16777215)) }})">

                                                        <p class="name-user-mm">{{ substr($comment->user->first_name, 0, 1) }}</p><p class="surname-user-mm">{{ substr($comment->user->last_name, 0, 1) }}</p>
                                                    </div>
                                                @endif
                                            @endif

                                            <div class="col-md-9 nopadding">
                                                <h4 class="person-name-mm col-md-6 nopadding">{{$comment->user->first_name}} {{$comment->user->last_name}}</h4>
                                                <p class="time-ago-mm col-md-6 nopadding"><i class="mdi mdi-clock"></i><span>
                                                        {{\Carbon\Carbon::createFromFormat('Y-m-d H:i:s',$comment->created_at)->diffForHumans(null, true, true)}}
                                                    </span> <i class="mdi mdi-arrow-down-bold-circle"></i></p>
                                            </div>
                                            <div class="col-md-offset-1 col-md-11 insides-massage-mm">
                                                <p>{{$comment->text}}</p>
                                            </div>
                                        </div>
                                    {{--end comments--}}
                                        @if($loop->last && $loop->index >=2)
                                            </div>
                                        @endif
                                    @endforeach
                                    <div><a href="#feed_{{ $feed->id }}" class="full_prod">Show all</a></div>

                                    {!! Form::open(['route' => 'store_comment_client', 'class' => 'form-horizontal', 'method'=>'POST' ]) !!}

                                    <div class="placement-update-footer-mm col-md-12 nopadding">
                                        <div class="arrow-mm col-md-1 nopadding add_comment">
                                            <i class="mdi mdi-reply"></i>
                                        </div>

                                        <div class="col-md-10 textarea-for-write-comment-mm nopadding comment" style="display: none">
                                        <textarea required name="comment"></textarea>
                                        <div class="col-md-4 block_btn_modal">
                                           <button type="button" class="btn btn-default btn-lg modal_btn btn-send-mm">Send</button>
                                            </div>
                                            <div class=" col-md-4 block_btn_modal">
                                                <button type="button" data-dismiss="modal" class="btn btn-default btn-lg modal_btn modal_btn_cancel btn-cancel-mm">Cancel</button>
                                            </div>
                                        </div>
                                    </div>
                                    <input type="hidden" name="feed" value="{{$feed->id}}">
                                    {!! Form::close() !!}

                                </div>
                            </div>

        @endforeach
</div>
                        </div>

                    </div>

                        </div>
                    </div>
                    {{--@endrole--}}
                </div>


            </div>
        </div>
    </div>
</div>
</div>

<script>

    $('.close').click(function() {
                $('.wrapper-placement-update-mm').hide();
            });


    $('.add_comment').click(function (e) {
        $(e.currentTarget.nextElementSibling).show();
    });

    $('.btn-cancel-mm').click(function (e) {
        $(e.currentTarget).closest('.comment').hide();
    });
    /*$('#product').change(function(){
        $('')
        $('#create_campaign')
    });*/

    $('.btn-send-mm').click(function (e) {
        console.log($(e.target).closest('form'));
        var form = $(e.target).closest('form');
//        console.log();
        $(form).append($('#product')).submit();
    });


    {{--$('#search_query').on('input', function(){--}}
        {{--var query = $(this).val();--}}
        {{--$('#slider_content_dynamic').show();--}}
        {{--$.ajax({--}}
            {{--url: "{{ route('search_updates_client') }}",--}}
            {{--type: "POST",--}}
            {{--data: { search_query: query, _token: "{{ csrf_token() }}" },--}}
            {{--dataType: "json",--}}
            {{--success: function(result)--}}
            {{--{--}}
                {{--console.log(result);--}}
                {{--if(Object.keys(result).length > 0){--}}
                    {{--var html = '';--}}
                    {{--$('#slider_content_dynamic').html('');--}}
                    {{--$.each(result, function(index, value){--}}
                        {{--html +=--}}
                            {{--'<>'+value.first_name+' '+value.last_name+'</>';--}}
                    {{--});--}}
                    {{--$('#slider_content_dynamic').append(html);--}}

                {{--}else{--}}
                    {{--$('#slider_content_dynamic').html('<span id="no_results">No Such Result</span>');--}}
                {{--}--}}

            {{--}--}}
        {{--});--}}
            {{--});--}}

    $('.full_prod').click(function (e) {
        e.preventDefault();
        $($(e.target).attr('href')).show();
        $($(e.target).parent()).hide();
    });
</script>



<!--<div style="width: 30%; height: 100vh;">
    hello world!
</div>-->
