@extends('layouts.admin')

@section('content')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');
    
    * {
        font-family: 'Poppins', sans-serif;
    }
    
    body {
        background: #f9fafb;
    }
    
    /* Page Header */
    .page-header-section {
        background: white;
        padding: 2rem;
        border-radius: 16px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
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
    
    /* Search & Action Bar */
    .search-action-bar {
        display: flex;
        gap: 1rem;
        align-items: center;
        margin-top: 1.5rem;
    }
    
    .search-box {
        flex: 1;
        position: relative;
    }
    
    .search-box input {
        width: 100%;
        padding: 0.85rem 1rem 0.85rem 3rem;
        border: 2px solid #E2E8F0;
        border-radius: 12px;
        font-size: 0.95rem;
        transition: all 0.3s;
        background: #F8FAFC;
    }
    
    .search-box input:focus {
        outline: none;
        border-color: #667eea;
        background: white;
        box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
    }
    
    .search-box i {
        position: absolute;
        left: 1rem;
        top: 50%;
        transform: translateY(-50%);
        color: #64748B;
        font-size: 1.1rem;
    }
    
    .btn-add-product {
        background: linear-gradient(135deg, #667eea, #764ba2);
        color: white;
        padding: 0.85rem 1.8rem;
        border-radius: 12px;
        border: none;
        font-weight: 600;
        font-size: 0.95rem;
        cursor: pointer;
        transition: all 0.3s;
        box-shadow: 0 5px 15px rgba(102, 126, 234, 0.3);
        white-space: nowrap;
    }
    
    .btn-add-product:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(102, 126, 234, 0.4);
    }
    
    /* Stats Cards */
    .stats-row {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
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
    }
    
    .stat-card.blue::before { background: linear-gradient(90deg, #667eea, #764ba2); }
    .stat-card.purple::before { background: linear-gradient(90deg, #8B5CF6, #7C3AED); }
    .stat-card.orange::before { background: linear-gradient(90deg, #f59e0b, #d97706); }
    
    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
    }
    
    .stat-icon {
        width: 50px;
        height: 50px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        margin-bottom: 1rem;
    }
    
    .stat-card.blue .stat-icon { background: #ede9fe; color: #667eea; }
    .stat-card.purple .stat-icon { background: #f3e8ff; color: #8B5CF6; }
    .stat-card.orange .stat-icon { background: #fef3c7; color: #f59e0b; }
    
    .stat-value {
        font-size: 1.8rem;
        font-weight: 700;
        color: #1E293B;
        margin-bottom: 0.3rem;
    }
    
    .stat-label {
        color: #64748B;
        font-size: 0.9rem;
        font-weight: 500;
    }
    
    /* Table Section */
    .table-section {
        background: white;
        border-radius: 16px;
        padding: 2rem;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
    }
    
    .table-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1.5rem;
    }
    
    .table-title {
        font-size: 1.3rem;
        font-weight: 600;
        color: #1E293B;
    }
    
    .filter-select {
        padding: 0.6rem 1rem;
        border: 2px solid #E2E8F0;
        border-radius: 10px;
        font-size: 0.9rem;
        color: #475569;
        background: #F8FAFC;
        cursor: pointer;
        transition: all 0.3s;
    }
    
        .filter-select:focus {
        outline: none;
        border-color: #667eea;
        box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
    }
    
    /* Custom Table */
    .products-table {
        width: 100%;
        border-collapse: collapse;
    }
    
    .products-table thead {
        background: #F8FAFC;
    }
    
    .products-table thead th {
        padding: 1rem;
        text-align: left;
        font-weight: 600;
        color: #475569;
        font-size: 0.9rem;
        border-bottom: 2px solid #E2E8F0;
    }
    
    .products-table tbody td {
        padding: 1rem;
        border-bottom: 1px solid #F1F5F9;
        color: #334155;
        font-size: 0.9rem;
    }
    
    .products-table tbody tr {
        transition: all 0.2s;
    }
    
    .products-table tbody tr:hover {
        background: #EFF6FF;
    }
    
    .product-image {
        width: 60px;
        height: 60px;
        border-radius: 10px;
        object-fit: cover;
    }
    
    .no-image {
        width: 60px;
        height: 60px;
        border-radius: 10px;
        background: linear-gradient(135deg, #E2E8F0, #CBD5E1);
        display: flex;
        align-items: center;
        justify-content: center;
        color: #64748B;
        font-size: 0.8rem;
    }
    
    .product-name {
        font-weight: 600;
        color: #1E293B;
        margin-bottom: 0.3rem;
    }
    
    .product-variants {
        font-size: 0.8rem;
        color: #64748B;
    }
    
    .badge {
        display: inline-block;
        padding: 0.4rem 0.8rem;
        border-radius: 8px;
        font-size: 0.8rem;
        font-weight: 600;
    }
    
    .badge-success { background: #d1fae5; color: #065f46; }
    .badge-warning { background: #fef3c7; color: #92400e; }
    .badge-danger { background: #fee2e2; color: #991b1b; }
    .badge-info { background: #ede9fe; color: #5b21b6; }
    
    /* Action Buttons */
    .btn-action {
        padding: 0.5rem 1rem;
        border-radius: 8px;
        border: none;
        font-size: 0.85rem;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.3s;
        margin-right: 0.5rem;
    }
    
    .btn-edit {
        background: #ede9fe;
        color: #667eea;
    }
    
    .btn-edit:hover {
        background: #667eea;
        color: white;
        transform: translateY(-2px);
    }
    
    .btn-delete {
        background: #fee2e2;
        color: #991b1b;
    }
    
    .btn-delete:hover {
        background: #ef4444;
        color: white;
        transform: translateY(-2px);
    }
    
    /* Alert */
    .alert-success {
        background: #d1fae5;
        border: 2px solid #86efac;
        color: #065f46;
        padding: 1rem 1.5rem;
        border-radius: 12px;
        margin-bottom: 1.5rem;
        display: flex;
        align-items: center;
        gap: 0.8rem;
    }
    
    .alert-success i {
        font-size: 1.5rem;
        color: #10b981;
    }
    
    /* Responsive */
    @media (max-width: 768px) {
        .search-action-bar {
            flex-direction: column;
        }
        
        .search-box {
            width: 100%;
        }
        
        .btn-add-product {
            width: 100%;
            text-align: center;
        }
        
        .stats-row {
            grid-template-columns: 1fr;
        }
        
        .table-section {
            overflow-x: auto;
        }
        
        .products-table {
            min-width: 800px;
        }
    }
</style>

<div class="container-fluid">
    <!-- Page Header -->
    <div class="page-header-section">
        <div class="d-flex justify-content-between align-items-start">
            <div>
                <h1 class="page-title">
                    <i class="bi bi-box-seam"></i> Product Management
                </h1>
                <p class="page-subtitle">Manage your products, stock, and inventory</p>
            </div>
        </div>
        
        <!-- Search & Action Bar -->
        <div class="search-action-bar">
            <div class="search-box">
                <i class="bi bi-search"></i>
                <input type="text" id="searchInput" placeholder="Search products..." onkeyup="searchProducts()">
            </div>
            <div class="filter-box">
                <select id="categoryFilter" class="form-select" onchange="filterByCategory()" style="padding: 0.85rem 1rem; border: 2px solid #E2E8F0; border-radius: 12px; font-size: 0.95rem; background: #F8FAFC; min-width: 200px;">
                    <option value="">All Categories</option>
                    <option value="Makanan">Makanan</option>
                    <option value="Minuman">Minuman</option>
                    <option value="Snack">Snack</option>
                    <option value="Alat Tulis">Alat Tulis</option>
                    <option value="Elektronik">Elektronik</option>
                    <option value="Peralatan Rumah Tangga">Peralatan Rumah Tangga</option>
                    <option value="Lainnya">Lainnya</option>
                </select>
            </div>
            <a href="{{ route('admin.products.create') }}" class="btn-add-product">
                <i class="bi bi-plus-circle"></i> Add Product
            </a>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="stats-row">
        <div class="stat-card blue">
            <div class="stat-icon">
                <i class="bi bi-box-seam"></i>
            </div>
            <div class="stat-value">{{ $products->count() }}</div>
            <div class="stat-label">Total Products</div>
        </div>
        
        <div class="stat-card orange">
            <div class="stat-icon">
                <i class="bi bi-exclamation-triangle"></i>
            </div>
            <div class="stat-value">
                @php
                    $outOfStock = $products->filter(function($product) {
                        return $product->variants->sum('stock') == 0;
                    })->count();
                @endphp
                {{ $outOfStock }}
            </div>
            <div class="stat-label">Out of Stock</div>
        </div>
        
        <div class="stat-card purple">
            <div class="stat-icon">
                <i class="bi bi-star"></i>
            </div>
            <div class="stat-value">
                @php
                    $lowStock = $products->filter(function($product) {
                        $totalStock = $product->variants->sum('stock');
                        return $totalStock > 0 && $totalStock < 10;
                    })->count();
                @endphp
                {{ $lowStock }}
            </div>
            <div class="stat-label">Low Stock</div>
        </div>
    </div>

    <!-- Success Alert -->
    @if(session('success'))
        <div class="alert-success">
            <i class="bi bi-check-circle-fill"></i>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    <!-- Table Section -->
    <div class="table-section">
        <div class="table-header">
            <h2 class="table-title">
                <i class="bi bi-list-ul"></i> Product List
            </h2>
            <form method="GET" action="{{ route('admin.products.index') }}" style="margin: 0;">
                <select name="filter" class="filter-select" onchange="this.form.submit()">
                    <option value="">All Products</option>
                    <option value="available" {{ request('filter') == 'available' ? 'selected' : '' }}>Available</option>
                    <option value="out_of_stock" {{ request('filter') == 'out_of_stock' ? 'selected' : '' }}>Out of Stock</option>
                    <option value="expired" {{ request('filter') == 'expired' ? 'selected' : '' }}>Expired</option>
                </select>
            </form>
        </div>
        
        <div style="overflow-x: auto;">
            <table class="products-table" id="productsTable">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Image</th>
                        <th>Product Name</th>
                        <th>Category</th>
                        <th>Total Stock</th>
                        <th>Variants</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($products as $index => $product)
                    @php
                        $hasExpired = $product->variants->where('expiry_date', '<', now())->count() > 0;
                        $totalStock = $product->variants->sum('stock');
                        $variantCount = $product->variants->count();
                    @endphp
                    <tr>
                        <td><strong>{{ $index + 1 }}</strong></td>
                        <td>
                            @if($product->image)
                                <img src="{{ asset('storage/' . $product->image) }}" 
                                     alt="{{ $product->name }}" 
                                     class="product-image">
                            @else
                                <div class="no-image">
                                    <i class="bi bi-image"></i>
                                </div>
                            @endif
                        </td>
                        <td>
                            <div class="product-name">{{ $product->name }}</div>
                            <div class="product-variants">
                                {{ Str::limit($product->description, 40) }}
                            </div>
                        </td>
                        <td>
                            <span class="badge badge-info">
                                {{ $product->category ?? 'Uncategorized' }}
                            </span>
                        </td>
                        <td>
                            <span class="badge {{ $totalStock > 10 ? 'badge-success' : ($totalStock > 0 ? 'badge-warning' : 'badge-danger') }}">
                                {{ $totalStock }} items
                            </span>
                        </td>
                        <td>
                            <span class="badge badge-info">
                                <i class="bi bi-tags"></i> {{ $variantCount }} variant{{ $variantCount > 1 ? 's' : '' }}
                            </span>
                        </td>
                        <td>
                            @if($hasExpired)
                                <span class="badge badge-danger">
                                    <i class="bi bi-exclamation-triangle"></i> Expired
                                </span>
                            @elseif($totalStock == 0)
                                <span class="badge badge-danger">
                                    <i class="bi bi-x-circle"></i> Out of Stock
                                </span>
                            @elseif($totalStock < 10)
                                <span class="badge badge-warning">
                                    <i class="bi bi-exclamation-circle"></i> Low Stock
                                </span>
                            @else
                                <span class="badge badge-success">
                                    <i class="bi bi-check-circle"></i> Available
                                </span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('admin.products.edit', $product) }}" 
                               class="btn-action btn-edit"
                               title="Edit Product">
                                <i class="bi bi-pencil"></i> Edit
                            </a>
                            <button onclick="confirmDelete({{ $product->id }})" 
                                    class="btn-action btn-delete"
                                    title="Delete Product">
                                <i class="bi bi-trash"></i> Delete
                            </button>
                            <form id="delete-form-{{ $product->id }}" 
                                  action="{{ route('admin.products.destroy', $product) }}" 
                                  method="POST" 
                                  style="display: none;">
                                @csrf
                                @method('DELETE')
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" style="text-align: center; padding: 3rem;">
                            <i class="bi bi-inbox" style="font-size: 3rem; color: #CBD5E1; display: block; margin-bottom: 1rem;"></i>
                            <p style="color: #64748B; font-size: 1.1rem; margin: 0;">No products found</p>
                            <p style="color: #94A3B8; font-size: 0.9rem; margin-top: 0.5rem;">Start by adding your first product!</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    // Search functionality
    function searchProducts() {
        const input = document.getElementById('searchInput');
        const filter = input.value.toUpperCase();
        const categoryFilter = document.getElementById('categoryFilter').value.toUpperCase();
        const table = document.getElementById('productsTable');
        const tr = table.getElementsByTagName('tr');
        
        for (let i = 1; i < tr.length; i++) {
            const td = tr[i].getElementsByTagName('td');
            let txtValue = '';
            let categoryValue = '';
            
            // Search in product name and category columns
            if (td[2]) txtValue += td[2].textContent || td[2].innerText;
            if (td[3]) {
                txtValue += td[3].textContent || td[3].innerText;
                categoryValue = td[3].textContent || td[3].innerText;
            }
            
            const matchesSearch = txtValue.toUpperCase().indexOf(filter) > -1;
            const matchesCategory = categoryFilter === '' || categoryValue.toUpperCase().indexOf(categoryFilter) > -1;
            
            if (matchesSearch && matchesCategory) {
                tr[i].style.display = '';
            } else {
                tr[i].style.display = 'none';
            }
        }
    }
    
    // Filter by category
    function filterByCategory() {
        searchProducts(); // Reuse search function with category filter
    }
    
    // Delete confirmation
    function confirmDelete(productId) {
        if (confirm('Are you sure you want to delete this product? This action cannot be undone.')) {
            document.getElementById('delete-form-' + productId).submit();
        }
    }
    
    // Auto-hide success alert after 5 seconds
    setTimeout(function() {
        const alert = document.querySelector('.alert-success');
        if (alert) {
            alert.style.transition = 'opacity 0.5s ease';
            alert.style.opacity = '0';
            setTimeout(() => alert.remove(), 500);
        }
    }, 5000);
</script>

@endsection
