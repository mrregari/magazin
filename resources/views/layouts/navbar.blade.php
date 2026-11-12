<nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top">
    <a class="navbar-brand" href="{{ route('home') }}">Shop</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarColor01" aria-controls="navbarColor01" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarColor01">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item {{ request()->routeIs('home') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('home') }}">Главная</a>
            </li>
            {{-- Категории (приходят из View Composer в AppServiceProvider) --}}
            @foreach ($categories as $category)
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('categories.show', ['slug' => $category->slug]) }}">{{ $category->title }}</a>
                </li>
            @endforeach
            <li class="nav-item">
                <button type="button" onclick="getCart(`{{ route('cart.show') }}`)" class="btn btn-primary">
                    Корзина <span class="badge bg-light text-dark mini-cart-qty">{{ session('cart_qty') ?? 0 }}</span>
                </button>
            </li>
        </ul>

        {{-- Блок авторизации --}}
        <ul class="navbar-nav">
            @auth
                {{-- Название учётной записи --}}
                <li class="nav-item">
                    <span class="navbar-text mr-3">
                        <i class="fas fa-user"></i> {{ Auth::user()->name }}
                    </span>
                </li>
                @if (Auth::user()->is_admin)
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.index') }}">Админка</a>
                    </li>
                @endif
                {{-- Выход: POST-форма с CSRF-токеном --}}
                <li class="nav-item">
                    <form action="{{ route('logout') }}" method="post" class="form-inline">
                        @csrf
                        <button type="submit" class="btn btn-link nav-link">Выйти</button>
                    </form>
                </li>
            @else
                <li class="nav-item"><a class="nav-link" href="{{ route('login') }}">Вход</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('register.create') }}">Регистрация</a></li>
            @endauth
        </ul>
    </div>
</nav>
