@extends('layouts.layout')
@section('title', 'Добавить товар')
@section('content')
    <div class="col-md-8 offset-md-2">
        <h1>Добавить товар</h1>
        {{-- enctype нужен для загрузки файла --}}
        <form action="{{ route('admin.products.store') }}" method="post" enctype="multipart/form-data">
            @csrf
            @include('admin.products._form')
            <button type="submit" class="btn btn-primary">Сохранить</button>
            <a href="{{ route('admin.products.index') }}" class="btn btn-link">Назад</a>
        </form>
    </div>
@endsection
