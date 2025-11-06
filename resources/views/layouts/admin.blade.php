<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Admin - Sellin Kasir' }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        * {
            font-family: 'Poppins', sans-serif;
        }

        body {
            background: #f9fafb;
            margin: 0;
            padding: 0;
        }

        /* Top Navbar */
        .navbar {
            background: white;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            padding: 1rem 2rem;
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        .navbar-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            max-width: 100%;
        }

        .logo-section {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .logo-icon {
            width: 45px;
            height: 45px;
            background: linear-gradient(135deg, #667eea, #764ba2);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.5rem;
        }

        .logo-text {
            font-size: 1.5rem;
            font-weight: 700;
            background: linear-gradient(135deg, #667eea, #764ba2);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .user-section {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .user-info {
            text-align: right;
        }

        .user-name {
            font-weight: 600;
            color: #1E293B;
            font-size: 0.95rem;
        }

        .user-role {
            font-size: 0.8rem;
            color: #64748B;
        }

        .user-avatar {
            width: 45px;
            height: 45px;
            background: linear-gradient(135deg, #ede9fe, #ddd6fe);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
            color: #667eea;
        }

        .btn-logout {
            background: linear-gradient(135deg, #ef4444, #dc2626);
            color: white;
            padding: 0.6rem 1.2rem;
            border-radius: 10px;
            border: none;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
            font-size: 0.9rem;
        }

        .btn-logout:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(239, 68, 68, 0.3);
        }

        /* Layout with Sidebar */
        .dashboard-layout {
            display: flex;
            min-height: calc(100vh - 85px);
        }

        /* Sidebar */
        .sidebar {
            width: 280px;
            background: white;
            box-shadow: 2px 0 10px rgba(0, 0, 0, 0.05);
            padding: 2rem 0;
            position: sticky;
            top: 85px;
            height: calc(100vh - 85px);
            overflow-y: auto;
        }

        .sidebar-menu {
            list-style: none;
            padding: 0 1rem;
        }

        .sidebar-menu li {
            margin-bottom: 0.5rem;
        }

        .sidebar-menu a {
            display: flex;
            align-items: center;
            gap: 1rem;
            padding: 1rem 1.5rem;
            color: #64748b;
            text-decoration: none;
            border-radius: 12px;
            transition: all 0.3s;
            font-weight: 500;
        }

        .sidebar-menu a i {
            font-size: 1.3rem;
            width: 24px;
        }

        .sidebar-menu a:hover {
            background: #ede9fe;
            color: #667eea;
        }

        .sidebar-menu a.active {
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);
        }

        /* Main Content */
        .main-content {
            flex: 1;
            padding: 2rem;
            overflow-x: hidden;
        }

        /* Footer */
        footer {
            background: white;
            border-top: 1px solid #e2e8f0;
            padding: 1.5rem 0;
            text-align: center;
        }

        footer p {
            color: #64748B;
            margin: 0;
            font-size: 0.9rem;
        }

        /* Responsive */
        @media (max-width: 1024px) {
            .sidebar {
                width: 240px;
            }
        }

        @media (max-width: 768px) {
            .navbar {
                padding: 1rem;
            }

            .dashboard-layout {
                flex-direction: column;
            }

            .sidebar {
                width: 100%;
                height: auto;
                position: relative;
                top: 0;
            }

            .navbar-container {
                flex-direction: column;
                gap: 1rem;
            }

            .user-section {
                width: 100%;
                justify-content: space-between;
            }

            .user-info {
                text-align: left;
            }

            .main-content {
                padding: 1rem;
            }
        }
    </style>
</head>
<body>
    <!-- Top Navbar -->
    <nav class="navbar">
        <div class="navbar-container container-fluid">
            <div class="logo-section">
                <div class="logo-icon">
                    <i class="bi bi-wallet2"></i>
                </div>
                <div class="logo-text">Sellin Kasir</div>
            </div>
            <div class="user-section">
                <div class="user-info">
                    <div class="user-name">{{ auth()->user()->name }}</div>
                    <div class="user-role">{{ ucfirst(auth()->user()->role->name) }}</div>
                </div>
                <div class="user-avatar">
                    <i class="bi bi-person-fill"></i>
                </div>
                <form action="{{ route('logout') }}" method="POST" style="margin: 0;">
                    @csrf
                    <button type="submit" class="btn-logout">
                        <i class="bi bi-box-arrow-right"></i> Logout
                    </button>
                </form>
            </div>
        </div>
    </nav>

    <div class="dashboard-layout">
        <!-- Sidebar -->
        <aside class="sidebar">
            <ul class="sidebar-menu">
                <li>
                    <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                        <i class="bi bi-speedometer2"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.products.index') }}" class="{{ request()->routeIs('admin.products.*') ? 'active' : '' }}">
                        <i class="bi bi-box-seam"></i>
                        <span>Products</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.users.index') }}" class="{{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                        <i class="bi bi-people"></i>
                        <span>Users</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.topup.index') }}" class="{{ request()->routeIs('admin.topup.*') ? 'active' : '' }}">
                        <i class="bi bi-credit-card"></i>
                        <span>Top-Up Verification</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.reports') }}" class="{{ request()->routeIs('admin.reports') ? 'active' : '' }}">
                        <i class="bi bi-bar-chart"></i>
                        <span>Reports</span>
                    </a>
                </li>
                <li>
                    <a href="#">
                        <i class="bi bi-gear"></i>
                        <span>Settings</span>
                    </a>
                </li>
            </ul>
        </aside>

        <!-- Main Content -->
        <main class="main-content">
            @yield('content')
        </main>
    </div>

    <!-- Footer -->
    <footer>
        <p>&copy; {{ date('Y') }} Sellin Kasir. All rights reserved.</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>
