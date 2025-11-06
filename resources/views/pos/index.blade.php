<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Quick POS - Fast Service | Sellin Kasir</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }
        
        body {
            background: #F3F4F6;
            color: #1F2937;
        }
        
        /* Top Bar */
        .top-bar {
            background: linear-gradient(135deg, #667eea, #764ba2);
            padding: 0.6rem 1.5rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            color: white;
            box-shadow: 0 4px 20px rgba(102, 126, 234, 0.3);
            position: sticky;
            top: 0;
            z-index: 1000;
        }
        
        .top-actions {
            display: flex;
            align-items: center;
            gap: 0.8rem;
        }
        
        .btn-top-action {
            background: rgba(255, 255, 255, 0.2);
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 10px;
            border: none;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.85rem;
        }
        
        .btn-top-action:hover {
            background: rgba(255, 255, 255, 0.3);
            transform: translateY(-2px);
            color: white;
        }
        
        .user-info {
            display: flex;
            align-items: center;
            gap: 1rem;
        }
        
        .user-name {
            font-weight: 600;
            font-size: 0.9rem;
        }
        
        .btn-logout-top {
            background: rgba(239, 68, 68, 0.9);
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 10px;
            border: none;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
            font-size: 0.85rem;
        }
        
        .btn-logout-top:hover {
            background: #EF4444;
            transform: translateY(-2px);
        }
        
        /* Main Layout */
        .main-layout {
            display: grid;
            grid-template-columns: 1fr 380px;
            gap: 1rem;
            padding: 1rem;
            max-width: 1600px;
            margin: 0 auto;
        }
        
        /* Left Panel */
        .products-panel {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }
        
        /* Popular Items Section */
        .popular-section {
            background: white;
            padding: 1rem;
            border-radius: 16px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
        }
        
        .section-header {
            display: flex;
            align-items: center;
            gap: 0.6rem;
            margin-bottom: 1rem;
        }
        
        .section-icon {
            font-size: 1.5rem;
            color: #F59E0B;
        }
        
        .section-title {
            font-size: 1.1rem;
            font-weight: 700;
            color: #1F2937;
        }
        
        .popular-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
            gap: 0.8rem;
        }
        
        /* Combo Items */
        .combo-item {
            background: linear-gradient(135deg, #EC4899, #EF4444);
            padding: 0.8rem;
            border-radius: 16px;
            cursor: pointer;
            transition: all 0.3s;
            text-align: center;
            color: white;
            box-shadow: 0 4px 15px rgba(236, 72, 153, 0.4);
            position: relative;
            overflow: hidden;
            display: flex;
            flex-direction: column;
        }
        
        .combo-item::before {
            content: '🎁';
            position: absolute;
            top: -10px;
            right: -10px;
            font-size: 4rem;
            opacity: 0.2;
        }
        
        .combo-image {
            width: 100%;
            height: 120px;
            object-fit: cover;
            border-radius: 12px;
            margin-bottom: 0.8rem;
            background: white;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        }
        
        .combo-item:hover {
            transform: translateY(-8px) scale(1.03);
            box-shadow: 0 12px 35px rgba(236, 72, 153, 0.5);
        }
        
        .combo-badge {
            background: linear-gradient(135deg, #FBBF24, #F59E0B);
            color: white;
            padding: 0.4rem 0.8rem;
            border-radius: 8px;
            font-size: 0.75rem;
            font-weight: 800;
            margin-bottom: 0.8rem;
            display: inline-block;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);
        }
        
        .combo-item-name {
            font-size: 1rem;
            font-weight: 800;
            margin-bottom: 0.3rem;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
        }
        
        .combo-item-detail {
            font-size: 0.8rem;
            opacity: 0.9;
            margin-bottom: 0.6rem;
        }
        
        .combo-item-price {
            margin-bottom: 0.5rem;
        }
        
        .combo-price-label {
            display: block;
            font-size: 0.8rem;
            opacity: 0.9;
            margin-bottom: 0.2rem;
        }
        
        .combo-price-value {
            font-size: 1.3rem;
            font-weight: 900;
            display: block;
        }
        
        .combo-info {
            background: rgba(255, 255, 255, 0.2);
            padding: 0.4rem 0.8rem;
            border-radius: 8px;
            font-size: 0.85rem;
            font-weight: 600;
            margin-top: 0.5rem;
        }
        
        /* Categories */
        .categories-section {
            display: flex;
            gap: 0.8rem;
            overflow-x: auto;
            padding-bottom: 0.5rem;
        }
        
        .categories-section::-webkit-scrollbar {
            height: 6px;
        }
        
        .categories-section::-webkit-scrollbar-thumb {
            background: #CBD5E1;
            border-radius: 10px;
        }
        
        .category-btn {
            padding: 0.8rem 1.5rem;
            border-radius: 12px;
            background: white;
            color: #64748B;
            border: 2px solid #E2E8F0;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
            white-space: nowrap;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        .category-btn:hover {
            border-color: #667eea;
            color: #667eea;
            transform: translateY(-2px);
        }
        
        .category-btn.active {
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            border-color: transparent;
        }
        
        /* Products Grid */
        .products-section {
            background: white;
            padding: 1rem;
            border-radius: 16px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
        }
        
        .products-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(140px, 1fr));
            gap: 0.8rem;
        }
        
        .product-card {
            background: #F9FAFB;
            border-radius: 12px;
            padding: 0.8rem;
            cursor: pointer;
            transition: all 0.3s;
            position: relative;
            border: 2px solid transparent;
        }
        
        .product-card:hover {
            border-color: #667eea;
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(102, 126, 234, 0.2);
        }
        
        .product-image {
            width: 100%;
            height: 100px;
            object-fit: cover;
            border-radius: 10px;
            margin-bottom: 0.6rem;
            background: white;
        }
        
        .product-name {
            font-weight: 600;
            font-size: 0.85rem;
            margin-bottom: 0.2rem;
            color: #1F2937;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
        
        .product-variant {
            font-size: 0.7rem;
            color: #6B7280;
            margin-bottom: 0.4rem;
        }
        
        .product-price {
            font-weight: 700;
            font-size: 0.9rem;
            color: #10B981;
        }
        
        .discount-badge {
            position: absolute;
            top: 0.5rem;
            right: 0.5rem;
            background: #EF4444;
            color: white;
            padding: 0.2rem 0.5rem;
            border-radius: 6px;
            font-size: 0.75rem;
            font-weight: 700;
        }
        
        .exclusive-badge {
            position: absolute;
            top: 0.5rem;
            left: 0.5rem;
            background: linear-gradient(135deg, #FBBF24, #F59E0B);
            color: white;
            padding: 0.3rem 0.6rem;
            border-radius: 8px;
            font-size: 0.65rem;
            font-weight: 800;
            box-shadow: 0 2px 8px rgba(251, 191, 36, 0.5);
            z-index: 10;
        }
        
        .stock-badge {
            position: absolute;
            bottom: 0.5rem;
            left: 0.5rem;
            background: #3B82F6;
            color: white;
            padding: 0.2rem 0.5rem;
            border-radius: 6px;
            font-size: 0.7rem;
            font-weight: 600;
        }
        
        /* Right Panel - Cart */
        .cart-panel {
            background: white;
            border-radius: 16px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            display: flex;
            flex-direction: column;
            max-height: calc(100vh - 90px);
            position: sticky;
            top: 70px;
            overflow: hidden;
        }
        
        .cart-header {
            padding: 1rem;
            border-bottom: 2px solid #F3F4F6;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-shrink: 0;
        }
        
        .cart-title {
            font-size: 1.1rem;
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        .cart-count {
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            padding: 0.2rem 0.6rem;
            border-radius: 10px;
            font-size: 0.85rem;
        }
        
        .btn-clear {
            background: #FEE2E2;
            color: #EF4444;
            border: none;
            padding: 0.4rem 0.8rem;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
            font-size: 0.85rem;
        }
        
        .btn-clear:hover {
            background: #EF4444;
            color: white;
        }
        
        .cart-items {
            flex: 1;
            overflow-y: auto;
            padding: 0.8rem;
            max-height: calc(100vh - 500px);
            min-height: 120px;
        }
        
        .cart-items::-webkit-scrollbar {
            width: 6px;
        }
        
        .cart-items::-webkit-scrollbar-track {
            background: #F3F4F6;
            border-radius: 10px;
        }
        
        .cart-items::-webkit-scrollbar-thumb {
            background: #667eea;
            border-radius: 10px;
        }
        
        .cart-items::-webkit-scrollbar-thumb:hover {
            background: #5a67d8;
        }
        
        .cart-item {
            background: #F9FAFB;
            padding: 0.8rem;
            border-radius: 12px;
            margin-bottom: 0.6rem;
            display: flex;
            flex-direction: column;
            gap: 0.6rem;
        }
        
        .combo-cart-item {
            background: linear-gradient(135deg, #FEF3F2, #FEE2E2);
            border: 2px solid #EC4899;
            box-shadow: 0 2px 8px rgba(236, 72, 153, 0.2);
        }
        
        .combo-cart-item .cart-item-price {
            color: #EC4899;
        }
        
        .cart-item-header {
            display: flex;
            justify-content: space-between;
            align-items: start;
        }
        
        .cart-item-info {
            flex: 1;
        }
        
        .cart-item-name {
            font-weight: 600;
            font-size: 0.85rem;
            margin-bottom: 0.2rem;
        }
        
        .cart-item-variant {
            font-size: 0.75rem;
            color: #6B7280;
        }
        
        .cart-item-price {
            font-weight: 700;
            color: #10B981;
            font-size: 0.9rem;
        }
        
        .cart-item-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .qty-controls {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            background: white;
            padding: 0.3rem;
            border-radius: 10px;
        }
        
        .qty-btn {
            width: 28px;
            height: 28px;
            border-radius: 8px;
            border: none;
            font-weight: 700;
            font-size: 1rem;
            cursor: pointer;
            transition: all 0.3s;
        }
        
        .qty-btn.minus {
            background: #FEE2E2;
            color: #EF4444;
        }
        
        .qty-btn.plus {
            background: #D1FAE5;
            color: #10B981;
        }
        
        .qty-btn:hover {
            transform: scale(1.1);
        }
        
        .qty-display {
            min-width: 30px;
            text-align: center;
            font-weight: 700;
            font-size: 0.9rem;
        }
        
        .item-subtotal {
            font-weight: 700;
            font-size: 1rem;
        }
        
        .btn-remove {
            background: #FEE2E2;
            color: #EF4444;
            border: none;
            width: 28px;
            height: 28px;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.3s;
        }
        
        .btn-remove:hover {
            background: #EF4444;
            color: white;
            transform: rotate(90deg);
        }
        
        .cart-summary {
            padding: 1rem;
            border-top: 2px solid #F3F4F6;
            background: #F9FAFB;
            flex-shrink: 0;
        }
        
        .summary-row {
            display: flex;
            justify-content: space-between;
            padding: 0.4rem 0;
            font-size: 0.85rem;
        }
        
        .summary-row.total {
            font-size: 1.3rem;
            font-weight: 800;
            color: #667eea;
            border-top: 2px solid #E5E7EB;
            padding-top: 0.8rem;
            margin-top: 0.4rem;
        }
        
        .btn-checkout {
            width: 100%;
            background: linear-gradient(135deg, #10B981, #059669);
            color: white;
            padding: 1rem;
            border-radius: 12px;
            border: none;
            font-weight: 700;
            font-size: 1rem;
            cursor: pointer;
            transition: all 0.3s;
            box-shadow: 0 4px 15px rgba(16, 185, 129, 0.3);
            margin-top: 0.8rem;
        }
        
        .btn-checkout:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(16, 185, 129, 0.4);
        }
        
        .btn-checkout:disabled {
            background: #D1D5DB;
            cursor: not-allowed;
            box-shadow: none;
        }
        
        /* Payment Methods */
        .payment-methods {
            margin-top: 0.8rem;
            margin-bottom: 0.8rem;
        }
        
        /* Customer Section */
        .customer-section {
            margin-top: 0.8rem;
            margin-bottom: 0.8rem;
            padding: 0.8rem;
            background: linear-gradient(135deg, #FEF3C7, #FDE68A);
            border-radius: 10px;
            border: 2px solid #F59E0B;
        }
        
        .customer-label {
            font-size: 0.85rem;
            font-weight: 600;
            color: #92400E;
            margin-bottom: 0.6rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        .customer-select {
            width: 100%;
            padding: 0.8rem;
            border: 2px solid #F59E0B;
            border-radius: 10px;
            font-size: 0.85rem;
            font-weight: 600;
            color: #92400E;
            background: white;
            cursor: pointer;
            transition: all 0.3s;
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='24' height='24' viewBox='0 0 24 24' fill='none' stroke='%23F59E0B' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='6 9 12 15 18 9'%3E%3C/polyline%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 0.8rem center;
            background-size: 1.2rem;
            padding-right: 2.5rem;
        }
        
        .customer-select:hover {
            border-color: #D97706;
            box-shadow: 0 2px 8px rgba(245, 158, 11, 0.2);
        }
        
        .customer-select:focus {
            outline: none;
            border-color: #F59E0B;
            box-shadow: 0 0 0 3px rgba(245, 158, 11, 0.1);
        }
        
        .manual-customer {
            margin-top: 0.8rem;
        }
        
        .customer-input {
            width: 100%;
            padding: 0.8rem;
            border: 2px solid #F59E0B;
            border-radius: 8px;
            font-size: 0.85rem;
            font-weight: 500;
            color: #92400E;
            background: white;
            transition: all 0.3s;
        }
        
        .customer-input:focus {
            outline: none;
            box-shadow: 0 0 0 3px rgba(245, 158, 11, 0.2);
            border-color: #D97706;
        }
        
        .customer-input::placeholder {
            color: #D97706;
            font-weight: 400;
        }
        
        .payment-label {
            font-size: 0.85rem;
            font-weight: 600;
            color: #374151;
            margin-bottom: 0.6rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        .payment-select {
            width: 100%;
            padding: 0.8rem;
            border: 2px solid #E5E7EB;
            border-radius: 10px;
            font-size: 0.9rem;
            font-weight: 600;
            color: #374151;
            background: white;
            cursor: pointer;
            transition: all 0.3s;
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='24' height='24' viewBox='0 0 24 24' fill='none' stroke='%23667eea' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='6 9 12 15 18 9'%3E%3C/polyline%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 0.8rem center;
            background-size: 1.2rem;
            padding-right: 2.5rem;
        }
        
        .payment-select:hover {
            border-color: #667eea;
            box-shadow: 0 2px 8px rgba(102, 126, 234, 0.2);
        }
        
        .payment-select:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }
        
        .bank-options {
            margin-top: 0.8rem;
            padding: 0.8rem;
            background: linear-gradient(135deg, #F0F9FF, #E0F2FE);
            border-radius: 10px;
            border: 2px solid #38BDF8;
            display: none;
            animation: slideDown 0.3s ease;
        }
        
        .bank-options.active {
            display: block;
        }
        
        .bank-select {
            width: 100%;
            padding: 0.8rem;
            border: 2px solid #38BDF8;
            border-radius: 8px;
            font-size: 0.85rem;
            font-weight: 600;
            color: #0C4A6E;
            background: white;
            cursor: pointer;
            transition: all 0.3s;
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='24' height='24' viewBox='0 0 24 24' fill='none' stroke='%2338BDF8' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='6 9 12 15 18 9'%3E%3C/polyline%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 0.8rem center;
            background-size: 1.2rem;
            padding-right: 2.5rem;
        }
        
        .bank-select:focus {
            outline: none;
            box-shadow: 0 0 0 3px rgba(56, 189, 248, 0.2);
        }
        
        .bank-label {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.8rem;
            font-weight: 600;
            color: #0C4A6E;
            margin-bottom: 0.5rem;
        }
        
        /* Cash Options */
        .cash-options {
            margin-top: 0.8rem;
            padding: 1rem;
            background: linear-gradient(135deg, #F0FDF4, #DCFCE7);
            border-radius: 10px;
            border: 2px solid #10b981;
            display: none;
            animation: slideDown 0.3s ease;
        }
        
        .cash-options.active {
            display: block;
        }
        
        .payment-input {
            width: 100%;
            padding: 0.9rem;
            border: 2px solid #10b981;
            border-radius: 8px;
            font-size: 1rem;
            font-weight: 600;
            color: #065f46;
            background: white;
            transition: all 0.3s;
            margin-top: 0.5rem;
        }
        
        .payment-input:focus {
            outline: none;
            box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.2);
            border-color: #059669;
        }
        
        .payment-input::placeholder {
            color: #9ca3af;
            font-weight: 500;
        }
        
        .change-display {
            margin-top: 1rem;
            padding: 0.8rem;
            background: white;
            border-radius: 8px;
            border: 2px dashed #10b981;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .change-label {
            font-size: 0.85rem;
            font-weight: 600;
            color: #065f46;
        }
        
        .change-amount {
            font-size: 1.1rem;
            font-weight: 800;
            color: #10b981;
            transition: color 0.3s;
        }
        
        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        /* Empty Cart */
        .empty-cart {
            text-align: center;
            padding: 2rem 1rem;
            color: #9CA3AF;
        }
        
        .empty-cart i {
            font-size: 3rem;
            margin-bottom: 0.8rem;
            opacity: 0.5;
        }
        
        /* Notifications */
        .notification {
            position: fixed;
            top: 100px;
            right: 2rem;
            padding: 1rem 1.5rem;
            border-radius: 12px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
            z-index: 9999;
            display: none;
            animation: slideIn 0.3s;
            font-weight: 600;
        }
        
        .notification.active {
            display: block;
        }
        
        .notification.success {
            background: #10B981;
            color: white;
        }
        
        .notification.error {
            background: #EF4444;
            color: white;
        }
        
        @keyframes slideIn {
            from {
                transform: translateX(400px);
                opacity: 0;
            }
            to {
                transform: translateX(0);
                opacity: 1;
            }
        }
        
        /* Responsive */
        @media (max-width: 1400px) {
            .main-layout {
                grid-template-columns: 1fr 360px;
            }
        }
        
        @media (max-width: 1200px) {
            .main-layout {
                grid-template-columns: 1fr 340px;
            }
            
            .products-grid {
                grid-template-columns: repeat(auto-fill, minmax(130px, 1fr));
            }
        }
        
        @media (max-width: 1024px) {
            .main-layout {
                grid-template-columns: 1fr;
            }
            
            .cart-panel {
                position: fixed;
                bottom: 0;
                left: 0;
                right: 0;
                max-height: 50vh;
                border-radius: 20px 20px 0 0;
                z-index: 100;
                top: auto;
            }
        }
    </style>
</head>
<body>
    <!-- Top Bar -->
    <div class="top-bar">
        <div class="top-actions">
            <a href="{{ route('cashier.verification') }}" class="btn-top-action">
                <i class="bi bi-clipboard-check"></i> Verifikasi Order
            </a>
            <a href="{{ route('cashier.reports') }}" class="btn-top-action">
                <i class="bi bi-graph-up"></i> Laporan
            </a>
        </div>
        <div class="user-info">
            <span class="user-name">
                <i class="bi bi-person-circle"></i> {{ Auth::user()->name }}
            </span>
            <form action="{{ route('logout') }}" method="POST" style="margin: 0;">
                @csrf
                <button type="submit" class="btn-logout-top">
                    <i class="bi bi-box-arrow-right"></i> Logout
                </button>
            </form>
        </div>
    </div>

    <!-- Main Layout -->
    <div class="main-layout">
        <!-- Left Panel - Products -->
        <div class="products-panel">
            <!-- Paket Combo -->
            <div class="popular-section">
                <div class="section-header">
                    <i class="bi bi-gift-fill section-icon"></i>
                    <h2 class="section-title">🎁 Paket Combo - BELI 1 GRATIS 1</h2>
                </div>
                <div class="popular-grid">
                    @php
                        $comboVariants = $variants
                            ->filter(function($variant) {
                                // Exclude member exclusive products from combo
                                $excludeProducts = ['MUJIGAE BANANA MILK CHOCOLATE', 'Cokelat Pistachio (ピスタチオチョコレート)', 'Ediya Coffee Beanist'];
                                return !in_array($variant->product->name, $excludeProducts);
                            })
                            ->sortByDesc(function($variant) {
                                return $variant->stock;
                            })
                            ->take(4);
                    @endphp
                    @foreach($comboVariants as $variant)
                    <div class="combo-item" onclick="addComboToCart({{ $variant->id }}, '{{ $variant->product->name }}', '{{ $variant->variant_name }}', {{ $variant->price }}, {{ $variant->discount }}, {{ $variant->stock }}, '{{ $variant->product->image ? asset('storage/' . $variant->product->image) : 'https://via.placeholder.com/200' }}')">
                        <div class="combo-badge">BELI 1 GRATIS 1</div>
                        <img src="{{ $variant->product->image ? asset('storage/' . $variant->product->image) : 'https://via.placeholder.com/200' }}" 
                             alt="{{ $variant->product->name }}" 
                             class="combo-image">
                        <div class="combo-item-name">{{ $variant->product->name }}</div>
                        <div class="combo-item-detail">{{ $variant->variant_name }}</div>
                        <div class="combo-item-price">
                            <div style="text-decoration: line-through; color: #999; font-size: 0.75rem; margin-bottom: 2px;">
                                Harga Normal: Rp {{ number_format(($variant->price * (1 - $variant->discount / 100)) * 2, 0, ',', '.') }}
                            </div>
                            <span class="combo-price-label">Harga Paket:</span>
                            <span class="combo-price-value">Rp {{ number_format($variant->price * (1 - $variant->discount / 100), 0, ',', '.') }}</span>
                            <div style="color: #10b981; font-weight: 600; font-size: 0.7rem; margin-top: 2px;">
                                💰 Hemat 50%!
                            </div>
                        </div>
                        <div class="combo-info">Dapat 2 produk!</div>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Categories -->
            <div class="categories-section">
                <button class="category-btn active" onclick="filterCategory('all')">
                    <i class="bi bi-grid"></i> Semua
                </button>
                <button class="category-btn" onclick="filterCategory('Makanan')">
                    <i class="bi bi-egg-fried"></i> Makanan
                </button>
                <button class="category-btn" onclick="filterCategory('Minuman')">
                    <i class="bi bi-cup-straw"></i> Minuman
                </button>
                <button class="category-btn" onclick="filterCategory('Snack')">
                    <i class="bi bi-bag"></i> Snack
                </button>
                <button class="category-btn" onclick="filterCategory('Lainnya')">
                    <i class="bi bi-three-dots"></i> Lainnya
                </button>
            </div>

            <!-- All Products -->
            <div class="products-section">
                <div class="section-header">
                    <i class="bi bi-grid-3x3-gap section-icon" style="color: #667eea;"></i>
                    <h2 class="section-title">Semua Produk</h2>
                </div>
                <div class="products-grid" id="productsGrid">
                    @foreach($variants as $variant)
                    <div class="product-card" data-category="{{ $variant->product->category ?? 'Lainnya' }}" onclick="addToCart({{ $variant->id }}, '{{ $variant->product->name }}', '{{ $variant->variant_name }}', {{ $variant->price }}, {{ $variant->discount }}, {{ $variant->stock }}, '{{ $variant->product->image ? asset('storage/' . $variant->product->image) : 'https://via.placeholder.com/200' }}', {{ $variant->product->is_early_access ? 'true' : 'false' }})">
                        @if($variant->product->is_early_access)
                        <div class="exclusive-badge">⭐ MEMBER</div>
                        @endif
                        @if($variant->discount > 0)
                        <div class="discount-badge">-{{ $variant->discount }}%</div>
                        @endif
                        <img src="{{ $variant->product->image ? asset('storage/' . $variant->product->image) : 'https://via.placeholder.com/200' }}" 
                             alt="{{ $variant->product->name }}" 
                             class="product-image">
                        <div class="product-name">{{ $variant->product->name }}</div>
                        <div class="product-variant">{{ $variant->variant_name }}</div>
                        <div class="product-price">
                            @if($variant->discount > 0)
                                <div style="text-decoration: line-through; color: #999; font-size: 0.75rem;">
                                    Rp {{ number_format($variant->price, 0, ',', '.') }}
                                </div>
                                <div style="color: #EF4444; font-weight: 700; font-size: 1rem;">
                                    Rp {{ number_format($variant->price * (1 - $variant->discount / 100), 0, ',', '.') }}
                                </div>
                            @else
                                Rp {{ number_format($variant->price, 0, ',', '.') }}
                            @endif
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Right Panel - Cart -->
        <div class="cart-panel">
            <div class="cart-header">
                <div class="cart-title">
                    <i class="bi bi-cart3"></i>
                    Pesanan <span class="cart-count" id="cartCount">0</span>
                </div>
                <button class="btn-clear" onclick="clearCart()">
                    <i class="bi bi-trash"></i> Clear
                </button>
            </div>
            
            <div class="cart-items" id="cartItems">
                <div class="empty-cart">
                    <i class="bi bi-cart-x"></i>
                    <p>Belum ada pesanan</p>
                </div>
            </div>
            
            <div class="cart-summary">
                <div class="summary-row">
                    <span>Subtotal</span>
                    <span id="subtotal">Rp 0</span>
                </div>
                <div class="summary-row total">
                    <span>TOTAL</span>
                    <span id="total">Rp 0</span>
                </div>
                
                <!-- Customer Selection -->
                <div class="customer-section">
                    <label class="customer-label">
                        <i class="bi bi-person-fill"></i> Customer / Member
                    </label>
                    <select class="customer-select" id="customerSelect" onchange="handleCustomerChange()">
                        <option value="">-- Pilih Customer / Member --</option>
                        @foreach($customers as $customer)
                        <option value="{{ $customer->id }}" data-is-member="{{ $customer->is_member ? '1' : '0' }}">
                            {{ $customer->name }} {{ $customer->is_member ? '⭐ MEMBER' : '' }}
                        </option>
                        @endforeach
                    </select>
                    
                    <!-- Manual Customer Name Input (if no customer selected) -->
                    <div class="manual-customer" id="manualCustomer">
                        <input type="text" 
                               class="customer-input" 
                               id="customerNameInput" 
                               placeholder="Atau ketik nama customer"
                               maxlength="100">
                    </div>
                </div>
                
                <!-- Payment Method Selection -->
                <div class="payment-methods">
                    <label class="payment-label">
                        <i class="bi bi-credit-card-fill"></i> Metode Pembayaran
                    </label>
                    <select class="payment-select" id="paymentMethod" onchange="handlePaymentMethodChange()">
                        <option value="tunai">💵 Tunai</option>
                        <option value="bank">🏦 Transfer Bank</option>
                    </select>
                    
                    <!-- Cash Payment Input (appears when Tunai is selected) -->
                    <div class="cash-options active" id="cashOptions">
                        <label class="payment-label">
                            <i class="bi bi-cash-coin"></i> Uang Diterima
                        </label>
                        <input type="number" 
                               class="payment-input" 
                               id="cashInput" 
                               placeholder="Masukkan jumlah uang"
                               oninput="calculateChange()"
                               min="0">
                        
                        <div class="change-display" id="changeDisplay">
                            <div class="change-label">Kembalian:</div>
                            <div class="change-amount" id="changeAmount">Rp 0</div>
                        </div>
                    </div>
                    
                    <!-- Bank Options (appears when Bank is selected) -->
                    <div class="bank-options" id="bankOptions">
                        <label class="bank-label">
                            <i class="bi bi-bank2"></i> Pilih Bank
                        </label>
                        <select class="bank-select" id="bankSelect" onchange="handleBankChange()">
                            <option value="">-- Pilih Bank --</option>
                            <option value="BCA">🏦 BCA (Bank Central Asia)</option>
                            <option value="Mandiri">🏦 Bank Mandiri</option>
                            <option value="BRI">🏦 BRI (Bank Rakyat Indonesia)</option>
                            <option value="BNI">🏦 BNI (Bank Negara Indonesia)</option>
                            <option value="CIMB">🏦 CIMB Niaga</option>
                            <option value="Permata">🏦 Bank Permata</option>
                            <option value="Danamon">🏦 Bank Danamon</option>
                            <option value="BTN">🏦 BTN (Bank Tabungan Negara)</option>
                            <option value="BSI">🏦 BSI (Bank Syariah Indonesia)</option>
                            <option value="Muamalat">🏦 Bank Muamalat</option>
                        </select>
                    </div>
                </div>
                
                <button class="btn-checkout" id="btnCheckout" onclick="processCheckout()" disabled>
                    <i class="bi bi-credit-card"></i> Proses Pembayaran
                </button>
            </div>
        </div>
    </div>

    <!-- Notification -->
    <div class="notification" id="notification"></div>

    <script>
        let cart = [];
        let subtotal = 0;
        let selectedPaymentMethod = 'tunai'; // Default payment method
        let selectedBank = ''; // Selected bank name
        let cashPaid = 0; // Cash paid by customer
        let changeAmount = 0; // Change to return
        let selectedCustomerId = null; // Selected customer ID
        let selectedCustomerName = ''; // Customer name
        let isMember = false; // Is customer a member

        // Handle customer selection
        function handleCustomerChange() {
            const customerSelect = document.getElementById('customerSelect');
            const selectedOption = customerSelect.options[customerSelect.selectedIndex];
            
            selectedCustomerId = customerSelect.value ? parseInt(customerSelect.value) : null;
            selectedCustomerName = selectedCustomerId ? selectedOption.text.replace(' ⭐ MEMBER', '').trim() : '';
            isMember = selectedOption.dataset.isMember === '1';
            
            // Clear manual input if customer selected from dropdown
            if (selectedCustomerId) {
                document.getElementById('customerNameInput').value = '';
                if (isMember) {
                    showNotification(`Member ${selectedCustomerName} dipilih! ⭐`, 'success');
                } else {
                    showNotification(`Customer ${selectedCustomerName} dipilih`, 'success');
                }
            }
            
            updateCart();
        }
        
        // Calculate change when cash input changes
        function calculateChange() {
            const cashInput = document.getElementById('cashInput');
            cashPaid = parseFloat(cashInput.value) || 0;
            
            changeAmount = cashPaid - subtotal;
            
            const changeDisplay = document.getElementById('changeAmount');
            if (changeAmount >= 0) {
                changeDisplay.textContent = `Rp ${formatNumber(changeAmount)}`;
                changeDisplay.style.color = '#10b981'; // Green
            } else {
                changeDisplay.textContent = `Kurang Rp ${formatNumber(Math.abs(changeAmount))}`;
                changeDisplay.style.color = '#ef4444'; // Red
            }
        }

        // Handle payment method change
        function handlePaymentMethodChange() {
            const paymentSelect = document.getElementById('paymentMethod');
            const bankOptions = document.getElementById('bankOptions');
            const cashOptions = document.getElementById('cashOptions');
            
            selectedPaymentMethod = paymentSelect.value;
            
            // Show/hide options based on payment method
            if (selectedPaymentMethod === 'bank') {
                bankOptions.classList.add('active');
                cashOptions.classList.remove('active');
                cashPaid = 0;
                changeAmount = 0;
            } else {
                bankOptions.classList.remove('active');
                cashOptions.classList.add('active');
                selectedBank = '';
                document.getElementById('bankSelect').value = '';
                // Recalculate change in case cart was updated
                calculateChange();
            }
        }
        
        // Handle bank selection change
        function handleBankChange() {
            const bankSelect = document.getElementById('bankSelect');
            selectedBank = bankSelect.value;
            
            if (selectedBank) {
                showNotification(`Bank ${selectedBank} dipilih`, 'success');
            }
        }

        // Add COMBO to cart (BELI 1 GRATIS 1)
        function addComboToCart(variantId, productName, variantName, price, discount, stock, image) {
            const priceAfterDiscount = price * (1 - discount / 100);
            
            // Check if stock enough for combo (need 2 items)
            if (stock < 2) {
                showNotification('Stok tidak cukup untuk paket combo!', 'error');
                return;
            }
            
            const existingItem = cart.find(item => item.variantId === variantId && item.isCombo);
            
            if (existingItem) {
                // Check if stock available for adding more combo
                if (existingItem.quantity + 2 <= stock) {
                    existingItem.quantity += 2; // Add 2 items (buy 1 get 1)
                    showNotification('🎁 Paket Combo ditambahkan! +2 items', 'success');
                } else {
                    showNotification('Stok tidak cukup untuk combo tambahan!', 'error');
                    return;
                }
            } else {
                cart.push({
                    variantId,
                    productName,
                    variantName: variantName + ' (COMBO)',
                    price: priceAfterDiscount,
                    originalPrice: price,
                    discount,
                    quantity: 2, // BELI 1 GRATIS 1 = dapat 2
                    stock,
                    image,
                    isCombo: true,
                    comboPrice: priceAfterDiscount // Harga untuk 2 items
                });
                showNotification('🎁 Paket Combo Ditambahkan! BELI 1 GRATIS 1', 'success');
            }
            
            updateCart();
        }

        // Add to cart (regular)
        function addToCart(variantId, productName, variantName, price, discount, stock, image, isEarlyAccess = false) {
            // Cek apakah produk eksklusif member dan customer bukan member
            if (isEarlyAccess && !isMember) {
                showNotification('⭐ Produk ini eksklusif untuk MEMBER saja! Pilih member di dropdown customer.', 'error');
                return;
            }

            const priceAfterDiscount = price * (1 - discount / 100);
            
            const existingItem = cart.find(item => item.variantId === variantId && !item.isCombo);
            
            if (existingItem) {
                if (existingItem.quantity < stock) {
                    existingItem.quantity++;
                    showNotification('Quantity updated!', 'success');
                } else {
                    showNotification('Stok tidak cukup!', 'error');
                    return;
                }
            } else {
                if (stock > 0) {
                    cart.push({
                        variantId,
                        productName,
                        variantName,
                        price: priceAfterDiscount,
                        originalPrice: price,
                        discount,
                        quantity: 1,
                        stock,
                        image,
                        isCombo: false
                    });
                    showNotification('Ditambahkan!', 'success');
                } else {
                    showNotification('Stok habis!', 'error');
                    return;
                }
            }
            
            updateCart();
        }

        // Update cart display
        function updateCart() {
            const cartItems = document.getElementById('cartItems');
            const cartCount = document.getElementById('cartCount');
            const btnCheckout = document.getElementById('btnCheckout');
            
            const totalItems = cart.reduce((sum, item) => sum + item.quantity, 0);
            
            // Calculate subtotal with combo pricing
            subtotal = cart.reduce((sum, item) => {
                if (item.isCombo) {
                    // For combo: price is for 2 items, but charged as 1
                    const comboSets = Math.floor(item.quantity / 2);
                    return sum + (item.comboPrice * comboSets);
                } else {
                    return sum + (item.price * item.quantity);
                }
            }, 0);
            
            cartCount.textContent = totalItems;
            document.getElementById('subtotal').textContent = `Rp ${formatNumber(subtotal)}`;
            document.getElementById('total').textContent = `Rp ${formatNumber(subtotal)}`;
            
            // Recalculate change if payment method is tunai
            if (selectedPaymentMethod === 'tunai') {
                calculateChange();
            }
            
            if (cart.length === 0) {
                cartItems.innerHTML = `
                    <div class="empty-cart">
                        <i class="bi bi-cart-x"></i>
                        <p>Belum ada pesanan</p>
                    </div>
                `;
                btnCheckout.disabled = true;
            } else {
                cartItems.innerHTML = cart.map(item => {
                    let displayPrice, displayTotal;
                    
                    if (item.isCombo) {
                        const comboSets = Math.floor(item.quantity / 2);
                        displayPrice = `<span style="color: #EC4899;">🎁 COMBO</span>`;
                        displayTotal = formatNumber(item.comboPrice * comboSets);
                    } else {
                        displayPrice = formatNumber(item.price);
                        displayTotal = formatNumber(item.price * item.quantity);
                    }
                    
                    return `
                    <div class="cart-item ${item.isCombo ? 'combo-cart-item' : ''}">
                        <div class="cart-item-header">
                            <div class="cart-item-info">
                                <div class="cart-item-name">${item.productName}</div>
                                <div class="cart-item-variant">${item.variantName}</div>
                                ${item.isCombo ? '<div style="font-size: 0.7rem; color: #EC4899; font-weight: 700;">BELI 1 GRATIS 1</div>' : ''}
                            </div>
                            <div class="cart-item-price">Rp ${displayPrice}</div>
                        </div>
                        <div class="cart-item-footer">
                            <div class="qty-controls">
                                <button class="qty-btn minus" onclick="updateQuantity(${item.variantId}, ${item.isCombo ? -2 : -1}, ${item.isCombo})">-</button>
                                <div class="qty-display">${item.quantity}</div>
                                <button class="qty-btn plus" onclick="updateQuantity(${item.variantId}, ${item.isCombo ? 2 : 1}, ${item.isCombo})">+</button>
                            </div>
                            <div class="item-subtotal">Rp ${displayTotal}</div>
                            <button class="btn-remove" onclick="removeFromCart(${item.variantId}, ${item.isCombo})">
                                <i class="bi bi-x-lg"></i>
                            </button>
                        </div>
                    </div>
                `}).join('');
                btnCheckout.disabled = false;
            }
        }

        // Update quantity
        function updateQuantity(variantId, change, isCombo) {
            const item = cart.find(i => i.variantId === variantId && i.isCombo === isCombo);
            if (!item) return;
            
            const newQty = item.quantity + change;
            
            if (newQty <= 0) {
                removeFromCart(variantId, isCombo);
            } else if (newQty <= item.stock) {
                item.quantity = newQty;
                updateCart();
            } else {
                showNotification('Stok tidak cukup!', 'error');
            }
        }

        // Remove from cart
        function removeFromCart(variantId, isCombo) {
            cart = cart.filter(item => !(item.variantId === variantId && item.isCombo === isCombo));
            updateCart();
            showNotification('Item dihapus', 'success');
        }

        // Clear cart
        function clearCart() {
            if (cart.length === 0) return;
            
            if (confirm('Hapus semua pesanan?')) {
                cart = [];
                selectedPaymentMethod = 'tunai';
                selectedBank = '';
                cashPaid = 0;
                changeAmount = 0;
                selectedCustomerId = null;
                selectedCustomerName = '';
                isMember = false;
                
                // Reset payment method UI
                document.getElementById('paymentMethod').value = 'tunai';
                document.getElementById('bankSelect').value = '';
                document.getElementById('cashInput').value = '';
                document.getElementById('customerSelect').value = '';
                document.getElementById('customerNameInput').value = '';
                document.getElementById('bankOptions').classList.remove('active');
                document.getElementById('cashOptions').classList.add('active');
                document.getElementById('changeAmount').textContent = 'Rp 0';
                document.getElementById('changeAmount').style.color = '#10b981';
                
                updateCart();
                showNotification('Keranjang dikosongkan', 'success');
            }
        }

        // Process checkout
        function processCheckout() {
            if (cart.length === 0) {
                showNotification('Keranjang masih kosong!', 'error');
                return;
            }
            
            // Get customer name from manual input if no customer selected
            const manualCustomerName = document.getElementById('customerNameInput').value.trim();
            let customerName = selectedCustomerName || manualCustomerName || 'Customer';
            
            // Validate payment method specific requirements
            if (selectedPaymentMethod === 'tunai') {
                if (cashPaid < subtotal) {
                    showNotification('Uang yang dibayarkan kurang!', 'error');
                    return;
                }
            } else if (selectedPaymentMethod === 'bank') {
                if (!selectedBank) {
                    showNotification('Silakan pilih bank terlebih dahulu!', 'error');
                    return;
                }
            }
            
            const total = subtotal;
            const paidAmount = selectedPaymentMethod === 'tunai' ? cashPaid : total;
            
            // Prepare data
            const items = cart.map(item => ({
                variant_id: item.variantId,
                quantity: item.quantity
            }));
            
            const data = {
                items: items,
                payment_method: selectedPaymentMethod,
                paid_amount: paidAmount,
                change: selectedPaymentMethod === 'tunai' ? changeAmount : 0,
                customer_id: selectedCustomerId,
                customer_name: customerName
            };
            
            // Send to server
            axios.post('/pos/sales', data, {
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            })
            .then(response => {
                const saleId = response.data.sale_id;
                
                let successMessage = `Transaksi berhasil! ⚡`;
                if (selectedPaymentMethod === 'bank' && selectedBank) {
                    successMessage = `Transaksi berhasil via ${selectedBank}! ⚡`;
                } else {
                    successMessage = `Transaksi berhasil! (${selectedPaymentMethod.toUpperCase()}) ⚡`;
                }
                
                showNotification(successMessage, 'success');
                
                // Ask to print receipt
                setTimeout(() => {
                    if (confirm('Cetak struk?')) {
                        window.open(`/pos/receipt/${saleId}`, '_blank');
                    }
                }, 1000);
                
                // Reset
                cart = [];
                subtotal = 0;
                selectedPaymentMethod = 'tunai';
                selectedBank = '';
                cashPaid = 0;
                changeAmount = 0;
                selectedCustomerId = null;
                selectedCustomerName = '';
                isMember = false;
                
                // Reset payment method UI
                document.getElementById('paymentMethod').value = 'tunai';
                document.getElementById('bankSelect').value = '';
                document.getElementById('cashInput').value = '';
                document.getElementById('customerSelect').value = '';
                document.getElementById('customerNameInput').value = '';
                document.getElementById('bankOptions').classList.remove('active');
                document.getElementById('cashOptions').classList.add('active');
                document.getElementById('changeAmount').textContent = 'Rp 0';
                document.getElementById('changeAmount').style.color = '#10b981';
                
                updateCart();
            })
            .catch(error => {
                console.error('Error detail:', error);
                const message = error.response?.data?.message || error.response?.data?.error || 'Terjadi kesalahan saat proses transaksi';
                showNotification(message, 'error');
            });
        }

        // Filter by category
        function filterCategory(category) {
            const products = document.querySelectorAll('.product-card');
            const buttons = document.querySelectorAll('.category-btn');
            
            // Update active button
            buttons.forEach(btn => btn.classList.remove('active'));
            event.target.classList.add('active');
            
            // Filter products
            products.forEach(product => {
                const productCategory = product.dataset.category;
                if (category === 'all' || productCategory === category) {
                    product.style.display = 'block';
                } else {
                    product.style.display = 'none';
                }
            });
        }

        // Format number
        function formatNumber(num) {
            return Math.round(num).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
        }

        // Show notification
        function showNotification(message, type) {
            const notification = document.getElementById('notification');
            notification.textContent = message;
            notification.className = `notification ${type} active`;
            
            setTimeout(() => {
                notification.classList.remove('active');
            }, 2500);
        }
    </script>
</body>
</html>
