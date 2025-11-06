<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - Sellin Kasir</title>
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: #f3f4f6;
        }

        /* Navbar */
        .navbar {
            background: white;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            padding: 15px 0;
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .navbar-container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 0 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .navbar-brand {
            display: flex;
            align-items: center;
            gap: 12px;
            text-decoration: none;
        }

        .brand-icon {
            font-size: 32px;
        }

        .brand-text h1 {
            font-size: 24px;
            font-weight: 800;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .brand-text p {
            font-size: 11px;
            color: #6b7280;
            font-weight: 500;
        }

        .navbar-menu {
            display: flex;
            align-items: center;
            gap: 30px;
        }

        .nav-link {
            text-decoration: none;
            color: #374151;
            font-weight: 600;
            font-size: 15px;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .nav-link:hover {
            color: #667eea;
        }

        .nav-link.active {
            color: #667eea;
        }

        .user-menu {
            position: relative;
        }

        .user-trigger {
            display: flex;
            align-items: center;
            gap: 10px;
            cursor: pointer;
            padding: 8px 16px;
            border-radius: 50px;
            transition: all 0.3s ease;
        }

        .user-trigger:hover {
            background: #f3f4f6;
        }

        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 700;
            font-size: 16px;
        }

        .user-info {
            display: flex;
            flex-direction: column;
        }

        .user-name {
            font-size: 14px;
            font-weight: 600;
            color: #1f2937;
        }

        .user-role {
            font-size: 12px;
            color: #6b7280;
        }

        .dropdown-menu {
            position: absolute;
            top: calc(100% + 10px);
            right: 0;
            background: white;
            border-radius: 16px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.1);
            min-width: 200px;
            opacity: 0;
            visibility: hidden;
            transform: translateY(-10px);
            transition: all 0.3s ease;
        }

        .user-menu:hover .dropdown-menu {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }

        .dropdown-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 20px;
            color: #374151;
            text-decoration: none;
            transition: all 0.3s ease;
            font-size: 14px;
            font-weight: 500;
        }

        .dropdown-item:first-child {
            border-radius: 16px 16px 0 0;
        }

        .dropdown-item:last-child {
            border-radius: 0 0 16px 16px;
        }

        .dropdown-item:hover {
            background: #f3f4f6;
        }

        .dropdown-item i {
            font-size: 18px;
        }

        .mobile-toggle {
            display: none;
            font-size: 24px;
            cursor: pointer;
            color: #374151;
        }

        @media (max-width: 768px) {
            .navbar-menu {
                display: none;
            }

            .mobile-toggle {
                display: block;
            }

            .navbar-container {
                padding: 0 20px;
            }
        }
    </style>

    @stack('styles')
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar">
        <div class="navbar-container">
            <a href="{{ route('customer.dashboard') }}" class="navbar-brand">
                <div class="brand-icon">🛒</div>
                <div class="brand-text">
                    <h1>Sellin Kasir</h1>
                    <p>Customer Portal</p>
                </div>
            </a>

            <div class="navbar-menu">
                <a href="{{ route('customer.shop') }}" class="nav-link {{ request()->routeIs('customer.shop') ? 'active' : '' }}">
                    <i class="bi bi-shop"></i>
                    Belanja
                </a>
                <a href="{{ route('customer.virtual-card') }}" class="nav-link {{ request()->routeIs('customer.virtual-card*') ? 'active' : '' }}">
                    <i class="bi bi-credit-card"></i>
                    Kartu Saya
                </a>
                <a href="{{ route('customer.balance') }}" class="nav-link {{ request()->routeIs('customer.balance*') ? 'active' : '' }}">
                    <i class="bi bi-wallet2"></i>
                    Saldo
                </a>
                <a href="{{ route('customer.orders') }}" class="nav-link {{ request()->routeIs('customer.orders*') ? 'active' : '' }}">
                    <i class="bi bi-bag-check"></i>
                    Pesanan
                </a>
                <a href="{{ route('customer.membership') }}" class="nav-link {{ request()->routeIs('customer.membership*') ? 'active' : '' }}">
                    <i class="bi bi-star"></i>
                    Membership
                </a>
                <a href="{{ route('customer.leaderboard') }}" class="nav-link {{ request()->routeIs('customer.leaderboard*') ? 'active' : '' }}">
                    <i class="bi bi-trophy"></i>
                    Leaderboard
                </a>

                <div class="user-menu">
                    <div class="user-trigger">
                        <div class="user-avatar">
                            @if(auth()->user()->profile_photo)
                                <img src="{{ asset('storage/' . auth()->user()->profile_photo) }}" alt="{{ auth()->user()->name }}" style="width: 100%; height: 100%; border-radius: 50%; object-fit: cover;">
                            @else
                                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                            @endif
                        </div>
                        <div class="user-info">
                            <span class="user-name">{{ auth()->user()->name }}</span>
                            <span class="user-role">
                                @if(auth()->user()->membership)
                                    {{ auth()->user()->membership->level->name }} Member
                                @else
                                    Customer
                                @endif
                            </span>
                        </div>
                        <i class="bi bi-chevron-down"></i>
                    </div>
                    <div class="dropdown-menu">
                        <a href="{{ route('customer.profile') }}" class="dropdown-item">
                            <i class="bi bi-person"></i>
                            Profil Saya
                        </a>
                        <a href="{{ route('customer.balance') }}" class="dropdown-item">
                            <i class="bi bi-wallet2"></i>
                            Saldo: Rp {{ number_format(auth()->user()->balance, 0, ',', '.') }}
                        </a>
                        @if(auth()->user()->membership)
                            <a href="{{ route('customer.membership.exclusive') }}" class="dropdown-item">
                                <i class="bi bi-lock"></i>
                                Member Exclusive
                            </a>
                        @endif
                        <form action="{{ route('logout') }}" method="POST" style="margin: 0;">
                            @csrf
                            <button type="submit" class="dropdown-item" style="width: 100%; border: none; background: none; cursor: pointer; text-align: left;">
                                <i class="bi bi-box-arrow-right"></i>
                                Logout
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="mobile-toggle">
                <i class="bi bi-list"></i>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main>
        @yield('content')
    </main>

    @stack('scripts')
</body>
</html>
