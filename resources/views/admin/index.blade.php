@extends('layouts.layout')
@section('title', 'Админ-панель')
@section('content')
    <div class="col-md-12">
        <h1>Админ-панель</h1>
        <p>Вы вошли как <b>{{ Auth::user()->name }}</b>.</p>

        <h4>Последние заказы</h4>
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr><th>#</th><th>Клиент</th><th>Email</th><th>Телефон</th><th>Кол-во</th><th>Сумма</th><th>Дата</th></tr>
                </thead>
                <tbody>
                    @forelse ($orders as $order)
                        <tr>
                            <td>{{ $order->id }}</td>
                            <td>{{ $order->name }}</td>
                            <td>{{ $order->email }}</td>
                            <td>{{ $order->phone }}</td>
                            <td>{{ $order->qty }}</td>
                            <td>@price_format($order->total) руб.</td>
                            <td>{{ $order->created_at }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="7">Заказов пока нет</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
