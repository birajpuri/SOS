<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login</title>
  <link rel="stylesheet" href="{{ asset('css/login.css') }}">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
    }

    body {
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
    }

    .login-container {
      background: white;
      padding: 40px;
      border-radius: 12px;
      box-shadow: 0 8px 24px rgba(0, 0, 0, 0.1);
      width: 100%;
      max-width: 400px;
      margin: 20px;
    }

    .header {
      margin-bottom: 30px;
      text-align: center;
    }

    .header h1 {
      color: #2c3e50;
      font-size: 28px;
      font-weight: 600;
      margin-bottom: 5px;
    }

    .header p {
      color: #7f8c8d;
      font-size: 14px;
    }

    .form-group {
      position: relative;
      margin-bottom: 24px;
    }

    .form-group input {
      width: 100%;
      padding: 12px 16px;
      padding-left: 40px;
      border: 1px solid #ddd;
      border-radius: 8px;
      font-size: 15px;
      transition: all 0.3s ease;
      background: #f8f9fa;
    }

    .form-group input:focus {
      border-color: #4a90e2;
      background: white;
      outline: none;
      box-shadow: 0 0 0 3px rgba(74, 144, 226, 0.1);
    }

    .form-group i {
      position: absolute;
      left: 14px;
      top: 50%;
      transform: translateY(-50%);
      color: #95a5a6;
    }

    .form-group input:focus+i {
      color: #4a90e2;
    }

    .forgot-pass {
      text-align: right;
      margin-bottom: 20px;
    }

    .forgot-pass a {
      color: #7f8c8d;
      font-size: 14px;
      text-decoration: none;
      transition: color 0.3s;
    }

    .forgot-pass a:hover {
      color: #4a90e2;
    }

    button {
      width: 100%;
      padding: 12px;
      background: #4a90e2;
      border: none;
      border-radius: 8px;
      color: white;
      font-size: 16px;
      font-weight: 500;
      cursor: pointer;
      transition: background 0.3s ease;
    }

    button:hover {
      background: #357abd;
    }

    .sign-up {
      margin-top: 20px;
      text-align: center;
      font-size: 14px;
      color: #7f8c8d;
    }

    .sign-up a {
      color: #4a90e2;
      text-decoration: none;
      font-weight: 500;
      margin-left: 5px;
    }

    .sign-up a:hover {
      text-decoration: underline;
    }

    @media (max-width: 480px) {
      .login-container {
        padding: 30px;
        margin: 15px;
      }
    }
  </style>
</head>

<body>
  <div class="login-container">
    <div class="header">
      <h1>Welcome Back</h1>
      <p>Please sign in to continue</p>
    </div>
    <form id="loginForm" action="{{ route('login.authenticate') }}" method="POST">
      @csrf
      <div class="form-group">
        <input type="text" id="email" name="email" placeholder="Email or Phone" required>
        <i class="fas fa-user"></i>
      </div>
      <div class="form-group">
        <input type="password" id="password" name="password" placeholder="Password" required>
        <i class="fas fa-lock"></i>
      </div>
      <div class="forgot-pass">
        <a href="#">Forgot Password?</a>
      </div>
      <button type="submit">Sign In</button>
      <div class="sign-up">
        Don't have an account?<a href="{{ route('register') }}">Sign Up</a>
      </div>
    </form>
  </div>

  {{-- <script>
        // Check if user is already logged in
        window.onload = function() {
            const isLoggedIn = localStorage.getItem('isLoggedIn');
            if (isLoggedIn === 'true') {
                window.location.href = 'index.html';
            }
        }

        function handleLogin(event) {
            event.preventDefault();
            
            const email = document.getElementById('email').value;
            const password = document.getElementById('password').value;
            
            if (email && password) {
                localStorage.setItem('isLoggedIn', 'true');
                localStorage.setItem('userEmail', email);
                window.location.href = 'index.html';
            } else {
                alert('Please fill in all fields');
            }
            return false;
        }
    </script> --}}
</body>

</html>
