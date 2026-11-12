# Magazin (Laravel 10)

Интернет-магазин: каталог, корзина (сессия + AJAX), оформление заказа, регистрация/вход, админ-панель.

## Запуск
```
composer install
cp .env.example .env
php artisan key:generate
# создайте БД "magazin" и поправьте DB_* в .env
php artisan migrate:fresh --seed
php artisan storage:link
php artisan serve
```

## Тестовые аккаунты (пароль `password`)
- admin@example.com - администратор (доступ к `/admin`)
- user@example.com - обычный пользователь

## Авторизация
- `UserController`: `create/store` (регистрация), `loginForm/login` (вход), `logout` (POST)
- `AdminMiddleware` (алиас `admin` в `Kernel.php`) пускает в `/admin` только `is_admin = 1`
