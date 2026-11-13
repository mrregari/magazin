@extends('layouts.layout')
@section('title', 'Товары')
@section('content')
    <div class="col-md-12">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h1 class="mb-0">Товары</h1>
            <a href="{{ route('admin.products.create') }}" class="btn btn-success">Добавить товар</a>
        </div>

        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>#</th><th>Фото</th><th>Название</th><th>Категория</th>
                        <th>Цена</th><th>Кол-во</th><th>Статус</th><th></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($products as $product)
                        <tr>
                            <td>{{ $product->id }}</td>
                            <td><img src="{{ $product->getImage() }}" alt="" style="height: 40px;"></td>
                            <td>{{ $product->title }}</td>
                            <td>{{ $product->category->title ?? '-' }}</td>
                            <td>@price_format($product->price) руб.</td>
                            <td>{{ $product->qty }}</td>
                            <td>{{ $product->status->title ?? '-' }}</td>
                            <td class="text-nowrap">
                                <a href="{{ route('admin.products.edit', $product) }}" class="btn btn-sm btn-primary">Изменить</a>
                                <form action="{{ route('admin.products.destroy', $product) }}" method="post" class="d-inline"
                                      onsubmit="return confirm('Удалить товар?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">Удалить</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="8">Товаров пока нет</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{ $products->links() }}
    </div>
@endsection
