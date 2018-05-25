<h1>NO-BS platform!</h1>
<h2>Dear {{  $data['first_name'] }}!</h2>
<p>Your password was changed</p>

<p>Credentials:</p>

<p>
    Link: <a href="{{ $data['link'] }}">{{ $data['link'] }}</a>
</p>

<p>Login: {{ $data['login'] }}</p>
<p>Password: {{ $data['new_password'] }}</p>