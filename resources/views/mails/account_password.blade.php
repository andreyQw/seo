<h1>Dear {{  $data['first_name'] }}!</h1>
<p>You are new user on NO-BS platform!</p>

<p>Credentials:</p>
<p>You can change your password on this link</p>
<p>
    Link: <a href="{{ $data['link'] }}">{{ $data['link'] }}</a>
</p>

<p>Login: {{ $data['login'] }}</p>
<p>Password: {{ $data['random_password'] }}</p>