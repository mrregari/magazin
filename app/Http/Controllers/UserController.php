<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Показать форму регистрации.
     */
    public function create()
    {
        return view('user.create');
    }

    /**
     * Обработать форму регистрации: валидация, создание пользователя, автоматический вход.
     */
    public function store(Request $request)
    {
        // Правила валидации; "confirmed" ищет поле password_confirmation
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6|confirmed',
        ]);

        // Пароль хешируется автоматически через cast 'hashed' в модели User
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
        ]);

        session()->flash('success', 'Регистрация пройдена');
        Auth::login($user);

        return redirect()->route('home');
    }

    /**
     * Показать форму входа.
     */
    public function loginForm()
    {
        return view('user.login');
    }

    /**
     * Обработать форму входа.
     */
    public function login(Request $request)
    {
        // Проверяем, что поля заполнены и email имеет корректный формат
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Auth::attempt сам сравнивает хеш пароля; второй аргумент - галочка "Запомнить меня"
        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            // Защита от session fixation: после входа выдаём новый ID сессии
            $request->session()->regenerate();
            session()->flash('success', 'Вы вошли в систему');

            // Администратор попадает в админку, обычный пользователь - на главную
            if (Auth::user()->is_admin) {
                return redirect()->route('admin.index');
            }
            return redirect()->intended(route('home'));
        }

        // Неверные данные: возвращаем на форму с ошибкой, email оставляем в поле
        return back()
            ->withErrors(['email' => 'Неверный email или пароль'])
            ->onlyInput('email');
    }

    /**
     * Выход из системы (вызывается методом POST).
     */
    public function logout(Request $request)
    {
        Auth::logout();
        // Сбрасываем сессию и CSRF-токен
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
