{{-- Общие поля формы для create и edit. Ожидает: $product, $categories, $statuses --}}
@if ($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="form-group">
    <label for="title">Название</label>
    <input type="text" name="title" id="title" class="form-control" value="{{ old('title', $product->title) }}">
</div>

<div class="form-group">
    <label for="content">Описание</label>
    <textarea name="content" id="content" rows="5" class="form-control">{{ old('content', $product->content) }}</textarea>
</div>

<div class="form-row">
    <div class="form-group col-md-6">
        <label for="category_id">Категория</label>
        <select name="category_id" id="category_id" class="form-control">
            <option value="">Выберите категорию</option>
            @foreach ($categories as $category)
                <option value="{{ $category->id }}" @selected(old('category_id', $product->category_id) == $category->id)>
                    {{ $category->title }}
                </option>
            @endforeach
        </select>
    </div>
    <div class="form-group col-md-6">
        <label for="status_id">Статус</label>
        <select name="status_id" id="status_id" class="form-control">
            <option value="">Выберите статус</option>
            @foreach ($statuses as $status)
                <option value="{{ $status->id }}" @selected(old('status_id', $product->status_id) == $status->id)>
                    {{ $status->title }}
                </option>
            @endforeach
        </select>
    </div>
</div>

<div class="form-row">
    <div class="form-group col-md-4">
        <label for="price">Цена</label>
        <input type="number" step="0.01" min="0" name="price" id="price" class="form-control" value="{{ old('price', $product->price) }}">
    </div>
    <div class="form-group col-md-4">
        <label for="old_price">Старая цена</label>
        <input type="number" step="0.01" min="0" name="old_price" id="old_price" class="form-control" value="{{ old('old_price', $product->old_price) }}">
    </div>
    <div class="form-group col-md-4">
        <label for="qty">Количество</label>
        <input type="number" min="0" name="qty" id="qty" class="form-control" value="{{ old('qty', $product->qty ?? 0) }}">
    </div>
</div>

<div class="form-group">
    <div class="form-check form-check-inline">
        <input type="checkbox" class="form-check-input" name="hit" id="hit" value="1" @checked(old('hit', $product->hit))>
        <label class="form-check-label" for="hit">Хит</label>
    </div>
    <div class="form-check form-check-inline">
        <input type="checkbox" class="form-check-input" name="sale" id="sale" value="1" @checked(old('sale', $product->sale))>
        <label class="form-check-label" for="sale">Распродажа</label>
    </div>
</div>

<div class="form-group">
    <label for="img">Изображение</label>
    @if ($product->img)
        <div class="mb-2"><img src="{{ $product->getImage() }}" alt="" style="max-height: 120px;"></div>
    @endif
    <input type="file" name="img" id="img" class="form-control-file">
</div>
