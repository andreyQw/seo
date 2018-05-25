@extends('layouts.orderFormLayout')
@section('content')
<div style="padding: 30px">
    <h2>Success registration</h2>
    <h3>login and pass was send on your email.
        {{--<span style="background-color: #fff3e0">{{ $email }}</span>--}}
    </h3>

    <a href="{{ route('setAccountForm') }}">Account setup</a>
    {{--<a href="{{ route('login') }}">Login</a>--}}
</div>

@endsection