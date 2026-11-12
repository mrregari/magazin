@extends('layouts.layout')
@section('title', 'Вход')
@section('content')
    <div class="col-md-6 offset-md-3">
        <h1>Вход</h1>

        {{-- Ошибки валидации и неверный логин/пароль --}}
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('login.store') }}" method="post">
            @csrf
            <div class="input-group mb-3">
                <input type="email" class="form-control" placeholder="Email" name="email" value="{{ old('email') }}">
                <div class="input-group-append"><div class="input-group-text"><span class="fas fa-envelope"></span></div></div>
            </div>
            <div class="input-group mb-3">
                <input type="password" class="form-control" placeholder="Пароль" name="password">
                <div class="input-group-append"><div class="input-group-text"><span class="fas fa-lock"></span></div></div>
            </div>
            <div class="form-check mb-3">
                <input type="checkbox" class="form-check-input" id="remember" name="remember" value="1">
                <label class="form-check-label" for="remember">Запомнить меня</label>
            </div>
            <button type="submit" class="btn btn-primary">Войти</button>
            <a href="{{ route('register.create') }}" class="btn btn-link">Регистрация</a>
        </form>
    </div>
@endsection
