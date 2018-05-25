@if(!empty($dates))

    @foreach($dates as $date => $counts)

        @if($date != 'continue')
            <div class="col-sm-12 day_correspondence">
                <h3>{{ $date }}</h3>
            </div>
        @endif

        @foreach($counts as $count => $feeds)

            @foreach($feeds as $feed)

                @include('feed.' . $feed->event->type, ['feed' => $feed, 'count' => $count])

            @endforeach

        @endforeach

    @endforeach

@endif