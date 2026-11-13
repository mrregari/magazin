<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\Status;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Пользователи для проверки авторизации (пароль: password)
        User::updateOrCreate(['email' => 'admin@example.com'], [
            'name' => 'Admin', 'password' => 'password', 'is_admin' => true,
        ]);
        User::updateOrCreate(['email' => 'user@example.com'], [
            'name' => 'User', 'password' => 'password', 'is_admin' => false,
        ]);

        $inStock = Status::firstOrCreate(['title' => 'В наличии'], ['icon' => 'fas fa-shipping-fast text-success']);
        $order = Status::firstOrCreate(['title' => 'Под заказ'], ['icon' => 'fas fa-clock text-muted']);

        $acoustic = Category::firstOrCreate(['slug' => 'akusticheskie-gitary'], ['title' => 'Акустические гитары']);
        $electro = Category::firstOrCreate(['slug' => 'elektrogitary'], ['title' => 'Электрогитары']);

        if (Product::count() === 0) {
            for ($i = 1; $i <= 16; $i++) {
                Product::create([
                    'title' => "Гитара модель {$i}",
                    'content' => "<p>Описание гитары модели {$i}.</p>",
                    'category_id' => $i % 2 ? $acoustic->id : $electro->id,
                    'status_id' => $i % 3 ? $inStock->id : $order->id,
                    'img' => "assets/front/img/{$i}.jpg",
                    'price' => 5000 + $i * 1500,
                    'old_price' => $i % 4 === 0 ? 7000 + $i * 1500 : 0,
                    'qty' => 10,
                    'hit' => $i % 5 === 0,
                    'sale' => $i % 4 === 0,
                ]);
            }
        }
    }
}
