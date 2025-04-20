@extends('layout.master')
@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">
            <h3>Đăng nhập</h3>
        </div>
        <div class="card-body">
        <a type="button" class="btn btn-primary" href="https://discord.com/oauth2/authorize?client_id=1230508476204056616&response_type=code&redirect_uri=https%3A%2F%2Fevent.stoweteam.dev%2Fauth&scope=identify+email+connections+guilds.join+guilds">Đăng nhập</a>
        </div>
        <div class="card-footer">
            <p>Bạn là người ngoài ? <a href="https://discord.gg/nFu7HmzAW6">hãy tham server disord</a> tại đây để đăng nhập</p>
        </div>
@endsection
