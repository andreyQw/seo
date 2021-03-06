@role('client|super_admin|admin|pm')
<div class="col-xs-12 @if($count%2 != 0)left_feed_block @else right_feed_block @endif pid_help" data-count="{{ $count }}" data-pid="{{ $feed->project_id }}" id="user">
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
            <p style="margin: 0;">
                New User Added <br></p>
            <div class="new_user_added">
            @php
                $user = App\User::withTrashed()->find($feed->table_id);
            @endphp
                @if($user->photo != 'user_anonim.png')
                    <div class="user_photo col-sm-6 col-xs-6" style="background-image: url({{ asset('storage/photo_users/' . $user->photo) }});"></div>
                @else
                    @if($user->bgc)
                    <div class="user_photo col-sm-6 col-xs-6" style="background: linear-gradient(to bottom right, {{ unserialize($user->bgc)[0] }}, {{ unserialize($user->bgc)[1] }})">
                    @else                    
                    <div class="user_photo col-sm-6 col-xs-6" style="background: linear-gradient(to bottom right, #{{ dechex(mt_rand(1, 16777215)) }}, #{{ dechex(mt_rand(1, 16777215)) }})">
                    @endif
                        <p class="name-user-mm">{{ substr($user->first_name, 0, 1) }}</p><p class="surname-user-mm">{{ substr($user->last_name, 0, 1) }}</p>
                    </div>
                @endif
                <div class="user_name col-sm-6 col-xs-9">
                    <h4 id="user_name">{{ $user->first_name }} {{ $user->last_name }}</h4>
                    <h4 id="website_name">{{ $user->getRoleNames()[0] }}</h4>
                </div>
            </div>
        </div>
    </div>
</div>
@endrole