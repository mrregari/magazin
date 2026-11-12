<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;

class ProductController extends Controller
{
    public function index()
    {
        $title = 'Главная';
        $products = Product::with(['category', 'status'])->orderBy('id', 'desc')->paginate(10);

        // Статистика магазина для главной страницы
        $stats = [
            'products' => Product::count(),
            'categories' => Category::count(),
            'users' => User::count(),
            'orders' => Order::count(),
        ];

        return view('products.index', compact('title', 'products', 'stats'));
    }

    public function show(string $slug)
    {
        $product = Product::query()->with(['category', 'status'])->where('slug', $slug)->firstOrFail();
        $title = $product->title;
        return view('products.show', compact('product', 'title'));
    }
}
