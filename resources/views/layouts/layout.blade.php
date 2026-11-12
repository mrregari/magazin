<!doctype html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css">
    <link rel="stylesheet" href="{{ asset('assets/front/css/main.css') }}">

    {{-- Заголовок страницы: @section('title', '...') в дочернем шаблоне --}}
    <title>@yield('title', 'Laravel Shop')</title>
</head>
<body>

@include('layouts.navbar')

<div class="wrapper mt-5">
    <div class="container">

        {{-- Флеш-сообщения (успех / ошибка доступа) --}}
        @if (session()->has('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if (session()->has('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <div class="row">
            @yield('content')
        </div><!-- /row -->
    </div><!-- /container -->
</div><!-- /wrapper -->

<!-- Модальное окно корзины: содержимое подгружается через AJAX -->
<div class="modal fade cart-modal" id="cart-modal" tabindex="-1" aria-labelledby="cartModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="cartModalLabel">Корзина</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body"></div>
        </div>
    </div>
</div>

{{-- Скрипты: сначала jQuery, потом Bootstrap, потом наш код --}}
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // CSRF-токен для всех AJAX-запросов
    $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });
</script>
<script src="{{ asset('assets/front/js/main.js') }}"></script>
</body>
</html>
