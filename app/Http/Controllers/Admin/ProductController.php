<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\Status;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Список товаров.
     */
    public function index()
    {
        $products = Product::with(['category', 'status'])->orderBy('id', 'desc')->paginate(10);
        return view('admin.products.index', compact('products'));
    }

    /**
     * Форма создания товара.
     */
    public function create()
    {
        return view('admin.products.create', [
            'product' => new Product(),   // пустая модель, чтобы _form работала одинаково для create и edit
            'categories' => Category::all(),
            'statuses' => Status::all(),
        ]);
    }

    /**
     * Сохранение нового товара.
     */
    public function store(Request $request)
    {
        // Валидация для создания: название должно быть уникальным, картинка необязательна
        $data = $request->validate([
            'title' => 'required|string|max:255|unique:products,title',
            'content' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'status_id' => 'required|exists:statuses,id',
            'price' => 'required|numeric|min:0',
            'old_price' => 'nullable|numeric|min:0',
            'qty' => 'required|integer|min:0',
            'hit' => 'nullable|boolean',
            'sale' => 'nullable|boolean',
            'img' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ], [], $this->attributes());

        $data['old_price'] = $data['old_price'] ?? 0;
        // Чекбоксы: если не отмечены, в запросе их нет
        $data['hit'] = $request->boolean('hit');
        $data['sale'] = $request->boolean('sale');

        if ($request->hasFile('img')) {
            // Сохраняем в storage/app/public/products, путь пишем в БД
            $data['img'] = $request->file('img')->store('products', 'public');
        }

        // slug создаётся автоматически (Sluggable)
        Product::create($data);

        return redirect()->route('admin.products.index')->with('success', 'Товар добавлен');
    }

    /**
     * Просмотр товара: отдельной страницы в админке нет, ведём на редактирование.
     */
    public function show(Product $product)
    {
        return redirect()->route('admin.products.edit', $product);
    }

    /**
     * Форма редактирования.
     */
    public function edit(Product $product)
    {
        return view('admin.products.edit', [
            'product' => $product,
            'categories' => Category::all(),
            'statuses' => Status::all(),
        ]);
    }

    /**
     * Обновление товара.
     */
    public function update(Request $request, Product $product)
    {
        // Валидация для обновления: название уникально, но текущий товар исключаем
        $data = $request->validate([
            'title' => 'required|string|max:255|unique:products,title,' . $product->id,
            'content' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'status_id' => 'required|exists:statuses,id',
            'price' => 'required|numeric|min:0',
            'old_price' => 'nullable|numeric|min:0',
            'qty' => 'required|integer|min:0',
            'hit' => 'nullable|boolean',
            'sale' => 'nullable|boolean',
            'img' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ], [], $this->attributes());

        $data['old_price'] = $data['old_price'] ?? 0;
        $data['hit'] = $request->boolean('hit');
        $data['sale'] = $request->boolean('sale');

        if ($request->hasFile('img')) {
            // Новая картинка загружена: удаляем старую и сохраняем новую
            $this->deleteImage($product);
            $data['img'] = $request->file('img')->store('products', 'public');
        } else {
            // Файл не выбран: оставляем прежнюю картинку
            unset($data['img']);
        }

        $product->update($data);

        return redirect()->route('admin.products.index')->with('success', 'Товар обновлён');
    }

    /**
     * Удаление товара.
     */
    public function destroy(Product $product)
    {
        $this->deleteImage($product);
        $product->delete();

        return redirect()->route('admin.products.index')->with('success', 'Товар удалён');
    }

    /**
     * Удаляет файл картинки из storage (картинки из public/assets не трогаем).
     */
    private function deleteImage(Product $product): void
    {
        if ($product->img && !str_starts_with($product->img, 'assets/')) {
            Storage::disk('public')->delete($product->img);
        }
    }

    /**
     * Русские названия полей для сообщений об ошибках.
     */
    private function attributes(): array
    {
        return [
            'title' => 'Название',
            'content' => 'Описание',
            'category_id' => 'Категория',
            'status_id' => 'Статус',
            'price' => 'Цена',
            'old_price' => 'Старая цена',
            'qty' => 'Количество',
            'img' => 'Изображение',
        ];
    }
}
