<?php

namespace App\Http\Controllers;

use App\Models\Order;

class AdminController extends Controller
{
    /**
     * Главная страница админ-панели: последние заказы.
     */
    public function index()
    {
        $orders = Order::latest()->take(20)->get();
        return view('admin.index', compact('orders'));
    }
}
