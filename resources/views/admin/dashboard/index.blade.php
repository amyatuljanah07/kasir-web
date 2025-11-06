<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Sellin Kasir</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: #f9fafb;
            color: #1E293B;
        }

        /* Top Navbar */
        .top-navbar {
            background: white;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            padding: 1rem 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: sticky;
            top: 0;
            z-index: 100;
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
            background: linear-gradient(135deg, #EF4444, #DC2626);
            color: white;
            padding: 0.6rem 1.2rem;
            border-radius: 10px;
            text-decoration: none;
            font-size: 0.9rem;
            font-weight: 500;
            transition: all 0.3s;
            border: none;
            cursor: pointer;
        }

        .btn-logout:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(239, 68, 68, 0.3);
        }

        /* Layout */
        .dashboard-layout {
            display: flex;
            min-height: calc(100vh - 77px);
        }

        /* Sidebar */
        .sidebar {
            width: 260px;
            background: white;
            box-shadow: 2px 0 10px rgba(0, 0, 0, 0.05);
            padding: 2rem 0;
            position: sticky;
            top: 77px;
            height: calc(100vh - 77px);
            overflow-y: auto;
        }

        .sidebar-menu {
            list-style: none;
        }

        .sidebar-menu li {
            margin-bottom: 0.5rem;
        }

        .sidebar-menu a {
            display: flex;
            align-items: center;
            gap: 1rem;
            padding: 0.9rem 1.5rem;
            color: #64748B;
            text-decoration: none;
            transition: all 0.3s;
            font-weight: 500;
            font-size: 0.95rem;
        }

        .sidebar-menu a i {
            font-size: 1.2rem;
            width: 24px;
        }

        .sidebar-menu a:hover {
            background: linear-gradient(90deg, rgba(59, 130, 246, 0.1), transparent);
            color: #3B82F6;
        }

        .sidebar-menu a.active {
            background: linear-gradient(90deg, rgba(59, 130, 246, 0.15), transparent);
            color: #3B82F6;
            border-left: 4px solid #3B82F6;
        }

        /* Main Content */
        .main-content {
            flex: 1;
            padding: 2rem;
            overflow-y: auto;
        }

        .page-header {
            margin-bottom: 2rem;
        }

        .page-title {
            font-size: 2rem;
            font-weight: 700;
            color: #1E293B;
            margin-bottom: 0.5rem;
        }

        .page-subtitle {
            color: #64748B;
            font-size: 0.95rem;
        }

        /* Stats Cards */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .stat-card {
            background: white;
            border-radius: 16px;
            padding: 1.5rem;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
            transition: all 0.3s;
            position: relative;
            overflow: hidden;
        }

        .stat-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, #3B82F6, #FDBA74);
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
        }

        .stat-card.blue::before { background: linear-gradient(135deg, #667eea, #764ba2); }
        .stat-card.orange::before { background: linear-gradient(135deg, #f59e0b, #d97706); }
        .stat-card.green::before { background: linear-gradient(135deg, #10b981, #059669); }
        .stat-card.purple::before { background: linear-gradient(135deg, #8B5CF6, #7C3AED); }

        .stat-icon {
            width: 55px;
            height: 55px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.8rem;
            margin-bottom: 1rem;
        }

        .stat-card.blue .stat-icon { background: #ede9fe; color: #667eea; }
        .stat-card.orange .stat-icon { background: #fef3c7; color: #f59e0b; }
        .stat-card.green .stat-icon { background: #d1fae5; color: #10b981; }
        .stat-card.purple .stat-icon { background: #f3e8ff; color: #8B5CF6; }

        .stat-value {
            font-size: 2rem;
            font-weight: 700;
            color: #1E293B;
            margin-bottom: 0.3rem;
        }

        .stat-label {
            color: #64748B;
            font-size: 0.9rem;
            font-weight: 500;
        }

        .stat-change {
            font-size: 0.85rem;
            margin-top: 0.5rem;
        }

        .stat-change.positive {
            color: #10B981;
        }

        .stat-change.negative {
            color: #EF4444;
        }

        /* Chart Section */
        .chart-section {
            background: white;
            border-radius: 16px;
            padding: 2rem;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
            margin-bottom: 2rem;
        }

        .section-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
        }

        .section-title {
            font-size: 1.3rem;
            font-weight: 600;
            color: #1E293B;
        }

        .chart-container {
            position: relative;
            height: 300px;
        }

        /* Low Stock Table */
        .table-section {
            background: white;
            border-radius: 16px;
            padding: 2rem;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
        }

        .table-wrapper {
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        thead {
            background: #F8FAFC;
        }

        thead th {
            padding: 1rem;
            text-align: left;
            font-weight: 600;
            color: #475569;
            font-size: 0.9rem;
            border-bottom: 2px solid #E2E8F0;
        }

        tbody td {
            padding: 1rem;
            border-bottom: 1px solid #F1F5F9;
            color: #334155;
            font-size: 0.9rem;
        }

        tbody tr:hover {
            background: #F8FAFC;
        }

        .badge {
            display: inline-block;
            padding: 0.4rem 0.8rem;
            border-radius: 8px;
            font-size: 0.8rem;
            font-weight: 600;
        }

        .badge-danger {
            background: #FEE2E2;
            color: #991B1B;
        }

        .badge-warning {
            background: #FEF3C7;
            color: #92400E;
        }

        /* Responsive */
        @media (max-width: 1024px) {
            .sidebar {
                width: 220px;
            }
        }

        @media (max-width: 768px) {
            .dashboard-layout {
                flex-direction: column;
            }

            .sidebar {
                width: 100%;
                height: auto;
                position: static;
            }

            .main-content {
                padding: 1.5rem;
            }

            .top-navbar {
                padding: 1rem;
            }

            .user-info {
                display: none;
            }

            .stats-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <!-- Top Navbar -->
    <nav class="top-navbar">
        <div class="logo-section">
            <div class="logo-icon">
                <i class="bi bi-wallet2"></i>
            </div>
            <span class="logo-text">Sellin Kasir</span>
        </div>
        <div class="user-section">
            <div class="user-info">
                <div class="user-name">{{ auth()->user()->name }}</div>
                <div class="user-role">Administrator</div>
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
    </nav>

    <div class="dashboard-layout">
        <!-- Sidebar -->
        <aside class="sidebar">
            <ul class="sidebar-menu">
                <li>
                    <a href="{{ route('admin.dashboard') }}" class="active">
                        <i class="bi bi-speedometer2"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.products.index') }}">
                        <i class="bi bi-box-seam"></i>
                        <span>Products</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.users.index') }}">
                        <i class="bi bi-people"></i>
                        <span>Users</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.topup.index') }}">
                        <i class="bi bi-credit-card"></i>
                        <span>Top-Up Verification</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.reports') }}">
                        <i class="bi bi-file-earmark-bar-graph"></i>
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
            <div class="page-header">
                <h1 class="page-title">Dashboard Overview</h1>
                <p class="page-subtitle">Welcome back! Here's what's happening today.</p>
            </div>

            <!-- Stats Cards -->
            <div class="stats-grid">
                <div class="stat-card blue">
                    <div class="stat-icon">
                        <i class="bi bi-box-seam"></i>
                    </div>
                    <div class="stat-value">{{ $totalProducts ?? 0 }}</div>
                    <div class="stat-label">Total Products</div>
                    <div class="stat-change positive">
                        <i class="bi bi-arrow-up"></i> +5% dari bulan lalu
                    </div>
                </div>

                <div class="stat-card orange">
                    <div class="stat-icon">
                        <i class="bi bi-cash-coin"></i>
                    </div>
                    <div class="stat-value">Rp {{ number_format($todaySales ?? 0, 0, ',', '.') }}</div>
                    <div class="stat-label">Total Sales Today</div>
                    <div class="stat-change positive">
                        <i class="bi bi-arrow-up"></i> +12% dari kemarin
                    </div>
                </div>

                <div class="stat-card green">
                    <div class="stat-icon">
                        <i class="bi bi-person-badge"></i>
                    </div>
                    <div class="stat-value">{{ $totalCashiers ?? 0 }}</div>
                    <div class="stat-label">Total Cashiers</div>
                    <div class="stat-change">
                        <i class="bi bi-dash"></i> Tidak ada perubahan
                    </div>
                </div>

                <div class="stat-card purple">
                    <div class="stat-icon">
                        <i class="bi bi-people"></i>
                    </div>
                    <div class="stat-value">{{ $totalCustomers ?? 0 }}</div>
                    <div class="stat-label">Total Customers</div>
                    <div class="stat-change positive">
                        <i class="bi bi-arrow-up"></i> +8 customer baru
                    </div>
                </div>
            </div>

            <!-- Chart Section -->
            <div class="chart-section">
                <div class="section-header">
                    <h2 class="section-title">
                        <i class="bi bi-graph-up-arrow"></i> Sales Overview - Last 7 Days
                    </h2>
                </div>
                <div class="chart-container">
                    <canvas id="salesChart"></canvas>
                </div>
            </div>

            <!-- Low Stock Table -->
            <div class="table-section">
                <div class="section-header">
                    <h2 class="section-title">
                        <i class="bi bi-exclamation-triangle"></i> Low Stock Products
                    </h2>
                    <a href="{{ route('admin.products.index') }}" style="color: #3B82F6; text-decoration: none; font-weight: 500;">
                        View All <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
                <div class="table-wrapper">
                    <table>
                        <thead>
                            <tr>
                                <th>Product ID</th>
                                <th>Product Name</th>
                                <th>Category</th>
                                <th>Stock</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($lowStockProducts ?? [] as $product)
                            <tr>
                                <td>#{{ $product->id }}</td>
                                <td>{{ $product->name }}</td>
                                <td>{{ $product->category ?? 'Uncategorized' }}</td>
                                <td>{{ $product->stock ?? 0 }}</td>
                                <td>
                                    @if(($product->stock ?? 0) == 0)
                                        <span class="badge badge-danger">Out of Stock</span>
                                    @else
                                        <span class="badge badge-warning">Low Stock</span>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" style="text-align: center; padding: 2rem; color: #64748B;">
                                    <i class="bi bi-check-circle" style="font-size: 2rem; display: block; margin-bottom: 0.5rem;"></i>
                                    All products are well stocked!
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </div>

    <script>
        // Sales Chart
        const ctx = document.getElementById('salesChart').getContext('2d');
        const salesChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: {!! json_encode($chartLabels ?? ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun']) !!},
                datasets: [{
                    label: 'Sales (Rp)',
                    data: {!! json_encode($chartData ?? [120000, 190000, 150000, 220000, 180000, 250000, 200000]) !!},
                    backgroundColor: 'rgba(59, 130, 246, 0.8)',
                    borderColor: 'rgba(59, 130, 246, 1)',
                    borderWidth: 2,
                    borderRadius: 8,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        backgroundColor: 'rgba(30, 41, 59, 0.9)',
                        padding: 12,
                        titleFont: {
                            size: 14,
                            weight: '600'
                        },
                        bodyFont: {
                            size: 13
                        },
                        borderRadius: 8,
                        callbacks: {
                            label: function(context) {
                                return 'Sales: Rp ' + context.parsed.y.toLocaleString('id-ID');
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: 'rgba(0, 0, 0, 0.05)'
                        },
                        ticks: {
                            callback: function(value) {
                                return 'Rp ' + (value / 1000) + 'k';
                            },
                            font: {
                                size: 12
                            }
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        },
                        ticks: {
                            font: {
                                size: 12,
                                weight: '500'
                            }
                        }
                    }
                }
            }
        });
    </script>
</body>
</html>
