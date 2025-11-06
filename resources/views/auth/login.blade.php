<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login - Sellin Kasir</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: 'Poppins', sans-serif;
      background: #f9fafb;
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 2rem 1rem;
    }

    .login-container {
      max-width: 450px;
      width: 100%;
      animation: fadeInUp 0.6s ease-out;
    }

    .login-card {
      background: white;
      border-radius: 20px;
      box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
      padding: 3rem 2.5rem;
      position: relative;
      overflow: hidden;
    }

    .login-card::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      height: 5px;
      background: linear-gradient(90deg, #667eea, #764ba2);
    }

    .logo-section {
      text-align: center;
      margin-bottom: 2.5rem;
    }

    .logo-icon {
      width: 80px;
      height: 80px;
      background: linear-gradient(135deg, #ede9fe, #ddd6fe);
      border-radius: 16px;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      font-size: 2.5rem;
      margin-bottom: 1rem;
    }

    .login-title {
      font-size: 2rem;
      font-weight: 700;
      color: #1E293B;
      margin-bottom: 0.5rem;
    }

    .login-subtitle {
      color: #64748B;
      font-size: 0.95rem;
    }

    .form-group {
      margin-bottom: 1.5rem;
    }

    .form-label {
      display: block;
      font-weight: 500;
      color: #334155;
      margin-bottom: 0.5rem;
      font-size: 0.9rem;
    }

    .form-control {
      width: 100%;
      padding: 0.85rem 1rem;
      border: 2px solid #E2E8F0;
      border-radius: 12px;
      font-size: 0.95rem;
      font-family: 'Poppins', sans-serif;
      transition: all 0.3s;
      background: #F8FAFC;
    }

    .form-control:focus {
      outline: none;
      border-color: #667eea;
      background: white;
      box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
    }

    .form-control.is-invalid {
      border-color: #EF4444;
      background: #FEF2F2;
    }

    .invalid-feedback {
      color: #EF4444;
      font-size: 0.85rem;
      margin-top: 0.5rem;
      display: block;
    }

    .alert {
      padding: 1rem;
      border-radius: 12px;
      margin-bottom: 1.5rem;
      border: none;
      background: #FEF2F2;
      color: #991B1B;
      font-size: 0.9rem;
    }

    .alert i {
      color: #EF4444;
    }

    .btn-login {
      width: 100%;
      padding: 1rem;
      background: linear-gradient(135deg, #667eea, #764ba2);
      color: white;
      border: none;
      border-radius: 12px;
      font-size: 1rem;
      font-weight: 600;
      cursor: pointer;
      transition: all 0.3s;
      box-shadow: 0 5px 15px rgba(102, 126, 234, 0.3);
    }

    .btn-login:hover {
      transform: translateY(-2px);
      box-shadow: 0 8px 25px rgba(102, 126, 234, 0.4);
    }

    .btn-login:active {
      transform: translateY(0);
    }

    .register-link {
      text-align: center;
      margin-top: 1.5rem;
      color: #64748B;
      font-size: 0.95rem;
    }

    .register-link a {
      color: #667eea;
      text-decoration: none;
      font-weight: 600;
      transition: color 0.3s;
    }

    .register-link a:hover {
      color: #764ba2;
      text-decoration: underline;
    }

    .back-link {
      text-align: center;
      margin-top: 1.5rem;
    }

    .back-link a {
      color: #64748B;
      text-decoration: none;
      font-size: 0.9rem;
      transition: color 0.3s;
    }

    .back-link a:hover {
      color: #667eea;
    }

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

    @media (max-width: 576px) {
      .login-card {
        padding: 2rem 1.5rem;
      }

      .login-title {
        font-size: 1.6rem;
      }

      body {
        padding: 1rem;
      }
    }
  </style>
</head>
<body>
  <div class="login-container">
    <div class="login-card">
      <div class="logo-section">
        <div class="logo-icon">
          <i class="bi bi-wallet2" style="color: #667eea;"></i>
        </div>
        <h1 class="login-title">Login to Sellin Kasir</h1>
        <p class="login-subtitle">Enter your credentials to access your account</p>
      </div>

      @if($errors->any())
      <div class="alert">
        <i class="bi bi-exclamation-triangle-fill"></i>
        <strong>Login Gagal!</strong> Email atau password salah.
      </div>
      @endif

      <form method="POST" action="/login">
        @csrf
        
        <div class="form-group">
          <label class="form-label">Email</label>
          <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" 
                 value="{{ old('email') }}" placeholder="contoh@email.com" required autofocus>
          @error('email')
          <span class="invalid-feedback">{{ $message }}</span>
          @enderror
        </div>

        <div class="form-group">
          <label class="form-label">Password</label>
          <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" 
                 placeholder="Masukkan password" required>
          @error('password')
          <span class="invalid-feedback">{{ $message }}</span>
          @enderror
        </div>

        <button type="submit" class="btn-login">
          <i class="bi bi-box-arrow-in-right" style="margin-right: 8px;"></i>Masuk
        </button>

        <div class="register-link">
          Belum punya akun? <a href="/register">Daftar</a>
        </div>
      </form>
    </div>

    <div class="back-link">
      <a href="/">
        <i class="bi bi-arrow-left"></i> Kembali ke Beranda
      </a>
    </div>
  </div>
</body>
</html>
