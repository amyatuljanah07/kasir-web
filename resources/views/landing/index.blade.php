<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sellin Kasir - Sistem Kasir Cerdas</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
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
            overflow-x: hidden;
        }
        
        /* Navbar */
        .navbar {
            background: white;
            padding: 1rem 0;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            position: sticky;
            top: 0;
            z-index: 1000;
        }
        
        .nav-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .logo {
            font-size: 1.8rem;
            font-weight: 700;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .nav-menu {
            display: flex;
            gap: 2rem;
            list-style: none;
        }
        
        .nav-menu a {
            color: #475569;
            text-decoration: none;
            font-weight: 500;
            transition: color 0.3s;
        }
        
        .nav-menu a:hover {
            color: #667eea;
        }
        
        .btn-login {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 0.6rem 1.5rem;
            border-radius: 12px;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s;
        }
        
        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.3);
        }
        
        /* Hero Section */
        .hero {
            max-width: 1200px;
            margin: 0 auto;
            padding: 6rem 2rem;
            text-align: center;
            background: white;
            border-radius: 24px;
            margin-top: 30px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.08);
        }
        
        .hero h1 {
            font-size: 3.5rem;
            font-weight: 700;
            margin-bottom: 1rem;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            animation: fadeInUp 0.8s ease-out;
        }
        
        .hero p {
            font-size: 1.3rem;
            color: #64748B;
            margin-bottom: 2.5rem;
            animation: fadeInUp 0.8s ease-out 0.2s backwards;
        }
        
        .hero-buttons {
            display: flex;
            gap: 1.5rem;
            justify-content: center;
            flex-wrap: wrap;
            animation: fadeInUp 0.8s ease-out 0.4s backwards;
        }
        
        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 1rem 2.5rem;
            border-radius: 12px;
            text-decoration: none;
            font-weight: 600;
            font-size: 1.1rem;
            transition: all 0.3s;
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.3);
        }
        
        .btn-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(102, 126, 234, 0.4);
        }
        
        .btn-secondary {
            background: white;
            color: #667eea;
            padding: 1rem 2.5rem;
            border-radius: 12px;
            text-decoration: none;
            font-weight: 600;
            font-size: 1.1rem;
            transition: all 0.3s;
            border: 2px solid #667eea;
        }
        
        .btn-secondary:hover {
            background: #667eea;
            color: white;
            transform: translateY(-3px);
        }
        
        /* About Section */
        .about {
            max-width: 1200px;
            margin: 4rem auto;
            padding: 0 2rem;
        }
        
        .section-title {
            text-align: center;
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 1rem;
            color: #1E293B;
        }
        
        .section-subtitle {
            text-align: center;
            font-size: 1.1rem;
            color: #64748B;
            margin-bottom: 3rem;
        }
        
        .about-card {
            background: white;
            padding: 3rem;
            border-radius: 20px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.08);
            text-align: center;
        }
        
        .about-card p {
            font-size: 1.1rem;
            color: #475569;
            line-height: 1.8;
        }
        
        /* Features Section */
        .features {
            max-width: 1200px;
            margin: 6rem auto;
            padding: 0 2rem;
        }
        
        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
            margin-top: 3rem;
        }
        
        .feature-card {
            background: white;
            padding: 2.5rem;
            border-radius: 20px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.08);
            transition: all 0.3s;
            cursor: pointer;
            position: relative;
            overflow: hidden;
        }
        
        .feature-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 5px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            transform: scaleX(0);
            transition: transform 0.3s;
        }
        
        .feature-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 50px rgba(0, 0, 0, 0.12);
        }
        
        .feature-card:hover::before {
            transform: scaleX(1);
        }
        
        .feature-icon {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, #ede9fe, #fae8ff);
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2.5rem;
            margin-bottom: 1.5rem;
        }
        
        .feature-card:nth-child(1) .feature-icon { 
            background: linear-gradient(135deg, #ede9fe, #ddd6fe);
            color: #667eea; 
        }
        .feature-card:nth-child(2) .feature-icon { 
            background: linear-gradient(135deg, #fef3c7, #fde68a);
            color: #f59e0b; 
        }
        .feature-card:nth-child(3) .feature-icon { 
            background: linear-gradient(135deg, #d1fae5, #a7f3d0);
            color: #10b981; 
        }
        
        .feature-card h3 {
            font-size: 1.5rem;
            font-weight: 600;
            margin-bottom: 1rem;
            color: #1E293B;
        }
        
        .feature-card p {
            color: #64748B;
            line-height: 1.6;
        }
        
        /* Footer */
        .footer {
            background: #1E293B;
            color: white;
            padding: 3rem 2rem;
            margin-top: 6rem;
            text-align: center;
        }
        
        .footer-content {
            max-width: 1200px;
            margin: 0 auto;
        }
        
        .footer h3 {
            font-size: 1.5rem;
            margin-bottom: 1rem;
        }
        
        .footer p {
            color: #94A3B8;
            margin-bottom: 0.5rem;
        }
        
        .footer-links {
            margin-top: 2rem;
            display: flex;
            gap: 2rem;
            justify-content: center;
            flex-wrap: wrap;
        }
        
        .footer-links a {
            color: #94A3B8;
            text-decoration: none;
            transition: color 0.3s;
        }
        
        .footer-links a:hover {
            color: #667eea;
        }
        
        /* Animations */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        /* Responsive */
        @media (max-width: 768px) {
            .hero h1 {
                font-size: 2.5rem;
            }
            
            .hero p {
                font-size: 1.1rem;
            }
            
            .nav-menu {
                display: none;
            }
            
            .hero-buttons {
                flex-direction: column;
            }
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar">
        <div class="nav-container">
            <div class="logo">
                <i class="bi bi-wallet2"></i> Sellin Kasir
            </div>
            <ul class="nav-menu">
                <li><a href="#home">Home</a></li>
                <li><a href="#about">About</a></li>
                <li><a href="#features">Features</a></li>
                <li><a href="#contact">Contact</a></li>
            </ul>
          
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero" id="home">
        <h1>Sellin Kasir — Sistem Kasir Cerdas untuk Bisnis Modern</h1>
        <p>Kelola transaksi, produk, dan laporan dengan mudah dalam satu platform</p>
        <div class="hero-buttons">
            <a href="/register" class="btn-primary">Get Started</a>
            <a href="/login" class="btn-secondary">Login</a>
        </div>
    </section>

    <!-- About Section -->
    <section class="about" id="about">
        <h2 class="section-title">Tentang Sellin Kasir</h2>
        <p class="section-subtitle">Solusi Digital untuk Manajemen Kasir Modern</p>
        <div class="about-card">
            <p>
                <strong>Sellin Kasir</strong> adalah sistem Point of Sale (POS) berbasis web yang dirancang untuk 
                mempermudah pengelolaan transaksi penjualan, inventori produk, dan laporan keuangan secara real-time. 

                <br><br>
                Proyek ini menggabungkan tiga peran pengguna utama: <strong>Admin</strong> yang mengelola produk dan sistem, 
                <strong>Kasir</strong> yang memproses transaksi dengan cepat, dan <strong>Customer</strong> yang dapat 
                berbelanja secara mandiri menggunakan Virtual Card. Dengan fitur lengkap seperti membership rewards, 
                early access produk eksklusif, dan sistem top-up saldo dengan verifikasi admin, Sellin Kasir 
                memberikan pengalaman yang efisien dan modern.

                
               
            </p>
        </div>
    </section>

    <!-- Features Section -->
    <section class="features" id="features">
        <h2 class="section-title">Fitur Unggulan</h2>
        <p class="section-subtitle">Semua yang Anda butuhkan dalam satu sistem</p>
        <div class="features-grid">
            <div class="feature-card">
                <div class="feature-icon">
                    <i class="bi bi-shield-check"></i>
                </div>
                <h3>Manajemen Admin</h3>
                <p>Kelola produk, stok, pengguna, dan akses laporan komprehensif. Dashboard intuitif untuk monitoring bisnis real-time.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">
                    <i class="bi bi-cash-register"></i>
                </div>
                <h3>Sistem Kasir</h3>
                <p>Proses transaksi cepat dengan pemindaian barcode, kalkulasi otomatis, dan cetak struk instan dalam hitungan detik.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">
                    <i class="bi bi-person-check"></i>
                </div>
                <h3>Portal Customer</h3>
                <p>Self-service shopping dengan Virtual Card! Customer belanja mandiri, bayar otomatis dengan PIN, dan ambil pesanan di kasir setelah verifikasi.</p>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer" id="contact">
        <div class="footer-content">
            <h3><i class="bi bi-wallet2"></i> Sellin Kasir</h3>
           
            <p style="margin-top: 1.5rem;">📧 support@sellinkasir.local • 📞 0812-3456-7890</p>
            <div class="footer-links">
                <a href="#about">Tentang</a>
                <a href="#features">Fitur</a>
                <a href="/register">Daftar</a>
            </div>
            <p style="margin-top: 2rem; font-size: 0.9rem;">© 2025 Sellin Kasir. All rights reserved.</p>
        </div>
    </footer>

    <script>
        // Smooth scroll
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({ behavior: 'smooth', block: 'start' });
                }
            });
        });

        // Scroll animation
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver(entries => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.animation = 'fadeInUp 0.8s ease-out forwards';
                }
            });
        }, observerOptions);

        document.querySelectorAll('.feature-card, .role-btn, .about-card').forEach(el => {
            observer.observe(el);
        });
    </script>
</body>
</html>
