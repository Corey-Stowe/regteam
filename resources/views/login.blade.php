@extends('layout.master')
@section('content')

{{-- <a type="button" class="btn btn-primary" href="https://discord.com/oauth2/authorize?client_id=1230508476204056616&response_type=code&redirect_uri=http%3A%2F%2F127.0.0.1%3A8000%2Fauth&scope=identify+email+connections+guilds+guilds.join">Đăng nhập</a> --}}
<a type="button" class="btn btn-primary" href="https://discord.com/oauth2/authorize?client_id=1230508476204056616&response_type=code&redirect_uri=https%3A%2F%2Fc045-123-24-221-82.ngrok-free.app%2Fauth&scope=identify+email+connections+guilds+guilds.join">Đăng nhập</a>
@endsection
