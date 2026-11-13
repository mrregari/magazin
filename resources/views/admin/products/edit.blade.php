@extends('layouts.layout')
@section('title', 'Редактировать товар')
@section('content')
    <div class="col-md-8 offset-md-2">
        <h1>Редактировать товар</h1>
        <form action="{{ route('admin.products.update', $product) }}" method="post" enctype="multipart/form-data">
            @csrf
            {{-- HTML-формы умеют только GET/POST, поэтому PUT передаём через @method --}}
            @method('PUT')
            @include('admin.products._form')
            <button type="submit" class="btn btn-primary">Обновить</button>
            <a href="{{ route('admin.products.index') }}" class="btn btn-link">Назад</a>
        </form>
    </div>
@endsection
