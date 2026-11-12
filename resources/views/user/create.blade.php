@extends('layouts.layout')
@section('title', 'Регистрация')
@section('content')
    <div class="col-md-6 offset-md-3">
        <h1>Регистрация</h1>

        {{-- Ошибки валидации --}}
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('register.store') }}" method="post">
            @csrf
            <div class="input-group mb-3">
                <input type="text" class="form-control" placeholder="Имя" name="name" value="{{ old('name') }}">
                <div class="input-group-append"><div class="input-group-text"><span class="fas fa-user"></span></div></div>
            </div>
            <div class="input-group mb-3">
                <input type="email" class="form-control" placeholder="Email" name="email" value="{{ old('email') }}">
                <div class="input-group-append"><div class="input-group-text"><span class="fas fa-envelope"></span></div></div>
            </div>
            <div class="input-group mb-3">
                <input type="password" class="form-control" placeholder="Пароль" name="password">
                <div class="input-group-append"><div class="input-group-text"><span class="fas fa-lock"></span></div></div>
            </div>
            <div class="input-group mb-3">
                <input type="password" name="password_confirmation" class="form-control" placeholder="Повторите пароль">
                <div class="input-group-append"><div class="input-group-text"><span class="fas fa-lock"></span></div></div>
            </div>
            <button type="submit" class="btn btn-primary">Зарегистрироваться</button>
            <a href="{{ route('login') }}" class="btn btn-link">Уже есть аккаунт?</a>
        </form>
    </div>
@endsection
