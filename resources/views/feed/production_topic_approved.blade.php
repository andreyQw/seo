@role('client|super_admin|admin|pm|partner|production')
<div class="col-xs-12 @if($count%2 != 0)left_feed_block @else right_feed_block @endif pid_help" data-count="{{ $count }}" data-pid="{{ $feed->project_id }}" id="production_topic_approved">
    <div class="@if($count%2 != 0)message_box_left @else message_box_right col-md-offset-6 @endif col-xs-6">
        <div class="col-sm-12 col-xs-12 user_block">
            @if(Auth::user()->photo != 'user_anonim.png')
                <div class="user_photo col-sm-6 col-xs-6" style="background-image: url({{ asset('storage/photo_users/' . Auth::user()->photo) }});"></div>
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
            <div class="user_name col-sm-6 col-xs-9">
                <h4 id="website_name">{{ $feed->project->url }}</h4>
                <h4 id="user_name">{{ Auth::user()->first_name }} {{ Auth::user()->last_name }}</h4>
            </div>
        </div>
        <div class="time_ago"><i class="mdi mdi-clock"></i>
            @if($tz > 0)
                {{ \Carbon\Carbon::parse($feed->created_at)->addHours($tz)->format('g:ia') }}
            @elseif($tz < 0)
                {{ \Carbon\Carbon::parse($feed->created_at)->subHours($tz)->format('g:ia') }}
            @else
                {{ (new \DateTime($feed->created_at, new \DateTimeZone('Australia/Sydney')))->format('g:ia') }}
            @endif
        </div>
        <div class="message arrow_box">
            <p style="margin: 0;" class="topic_approved">
                Topic Approved <br>
                <div class="row">
                    <div class="col-sm-12 col-xs-12 nopadding">
                    @role('client')
                        @foreach($feed->update_clients as $comment)
                            @if($loop->index == 2)
                                <div id="feed_{{ $feed->id }}" style="display: none;">
                            @endif
                                    <div class="col-md-offset-1 col-md-11 insides-massage-comment-mm">
                                        @if($comment->user->photo != 'user_anonim.png')
                                            <div class="massage-photo-comment-mm col-md-1" style="background-image: url({{ asset('storage/photo_users/' . $comment->user->photo) }});"></div>
                                        @else
                                            @if($comment->user->bgc)
                                                <div class="massage-photo-comment-mm user_photo-none col-md- col-xs-1" style="background: linear-gradient(to bottom right, {{ unserialize($comment->user->bgc)[0] }}, {{ unserialize($comment->user->bgc)[1] }})">

                                                    <p class="name-user-mm-1">{{ substr($comment->user->first_name, 0, 1) }}</p><p class="surname-user-mm-1">{{ substr($comment->user->last_name, 0, 1) }}</p>
                                                </div>
                                            @else
                                                <div class="massage-photo-comment-mm user_photo-none col-md-1" style="background: linear-gradient(to bottom right, #{{ dechex(mt_rand(1, 16777215)) }}, #{{ dechex(mt_rand(1, 16777215)) }})">

                                                    <p class="name-user-mm-1">{{ substr($comment->user->first_name, 0, 1) }}</p><p class="surname-user-mm-1">{{ substr($comment->user->last_name, 0, 1) }}</p>
                                                </div>
                                            @endif
                                        @endif
                                        <div class="col-md-10 col-xs-9 nopadding">
                                            <h4 class="person-name-mm col-md-6 col-xs-6 nopadding">{{$comment->user->first_name}} {{$comment->user->last_name}}</h4>
                                            <p class="time-ago-mm col-md-6 col-xs-6 nopadding">
                                                <i class="mdi mdi-clock"></i>
                                                <span>
                                                    {{\Carbon\Carbon::createFromFormat('Y-m-d H:i:s',$comment->created_at)->diffForHumans(null, true, true)}}
                                                </span>
                                                <i class="mdi mdi-arrow-down-bold-circle"></i>
                                            </p>
                                        </div>
                                        <div class="col-md-offset-1 col-md-11 col-xs-11 insides-massage-mm">
                                            <p>{{$comment->text}}</p>
                                        </div>
                                    </div>
                            @if($loop->last && $loop->index >= 2)
                                </div>
                            @endif
                        @endforeach
                    @else
                        @foreach($feed->update_nobses as $comment)
                            @if($loop->index == 2)
                                <div id="feed_{{ $feed->id }}" style="display: none;">
                            @endif
                                    <div class="col-md-offset-1 col-md-11 insides-massage-comment-mm">
                                        @if($comment->user->photo != 'user_anonim.png')
                                            <div class="massage-photo-comment-mm col-md-1" style="background-image: url({{ asset('storage/photo_users/' . $comment->user->photo) }});"></div>
                                        @else
                                            @if($comment->user->bgc)
                                                <div class="massage-photo-comment-mm user_photo-none col-md-1" style="background: linear-gradient(to bottom right, {{ unserialize($comment->user->bgc)[0] }}, {{ unserialize($comment->user->bgc)[1] }})">

                                                    <p class="name-user-mm-1">{{ substr($comment->user->first_name, 0, 1) }}</p><p class="surname-user-mm-1">{{ substr($comment->user->last_name, 0, 1) }}</p>
                                                </div>
                                            @else
                                                <div class="massage-photo-comment-mm user_photo-none col-md-1" style="background: linear-gradient(to bottom right, #{{ dechex(mt_rand(1, 16777215)) }}, #{{ dechex(mt_rand(1, 16777215)) }})">

                                                    <p class="name-user-mm-1">{{ substr($comment->user->first_name, 0, 1) }}</p><p class="surname-user-mm-1">{{ substr($comment->user->last_name, 0, 1) }}</p>
                                                </div>
                                            @endif
                                        @endif
                                        <div class="col-md-10 nopadding">
                                            <h4 class="person-name-mm col-md-6 nopadding">{{$comment->user->first_name}} {{$comment->user->last_name}}</h4>
                                            <p class="time-ago-mm col-md-6 nopadding">
                                                <i class="mdi mdi-clock"></i>
                                                <span>
                                                    {{\Carbon\Carbon::createFromFormat('Y-m-d H:i:s',$comment->created_at)->diffForHumans(null, true, true)}}
                                                </span>
                                                <i class="mdi mdi-arrow-down-bold-circle"></i>
                                            </p>
                                        </div>
                                        <div class="col-md-offset-1 col-md-11 insides-massage-mm">
                                            <p>{{$comment->text}}</p>
                                        </div>
                                    </div>
                            @if($loop->last && $loop->index >= 2)
                                </div>
                            @endif
                        @endforeach
                    @endrole
                </div>
                </div>

                @role('client')
                    @if(count($feed->update_clients) > 2)
                        <div class="full_cont"><i class="mdi mdi-link-variant"></i><a href="#feed_{{ $feed->id }}" class="full_prod">Full detail</a></div>
                    @endif
                @else
                    @if(count($feed->update_nobses) > 2)
                        <div class="full_cont"><i class="mdi mdi-link-variant"></i><a href="#feed_{{ $feed->id }}" class="full_prod">Full detail</a></div>
                    @endif
                @endrole

        </div>
    </div>
</div>
@endrole
