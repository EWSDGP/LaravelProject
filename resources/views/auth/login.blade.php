<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>University Staff/Admin Login</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <style>
    * {
      box-sizing: border-box;
    }

    body {
      margin: 0;
      font-family: 'Poppins', sans-serif;
      background: #f2f2f2;
      display: flex;
      align-items: center;
      justify-content: center;
      height: 100vh;
    }

    .container {
      display: flex;
      width: 90%;
      max-width: 1000px;
      background: #fff;
      border-radius: 20px;
      overflow: hidden;
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    }

    .left-panel {
      flex: 1;
      background: linear-gradient(to bottom right, #FFD700, #FFC107);
      color: white;
      padding: 40px 20px;
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
      text-align: center;
    }

    .left-panel img {
      width: 100px;
      height: 100px;
      object-fit: contain;
      margin-bottom: 20px;
    }

    .left-panel h1 {
      font-size: 24px;
      margin: 10px 0;
      font-weight: 700;
    }

    .left-panel p {
      font-size: 14px;
      max-width: 300px;
      margin: 5px 0;
    }

    .login-container {
      flex: 1;
      background: #fff;
      padding: 40px 30px;
      display: flex;
      flex-direction: column;
      justify-content: center;
    }

    .logo-container {
      text-align: center;
      margin-bottom: 20px;
    }

    .logo-container h1 {
      margin: 0;
      color: #333;
      font-weight: 700;
    }

    .logo-container h5 {
      margin: 0;
      color: #F59A23;
    }

    .login-form {
      display: flex;
      flex-direction: column;
      gap: 20px;
    }

    .input {
      position: relative;
    }

    .input label {
      font-weight: 500;
      margin-bottom: 5px;
      display: block;
      color: #333;
    }

    .input input {
      width: 100%;
      padding: 12px 40px;
      padding-left: 45px;
      border: 1px solid #ccc;
      border-radius: 30px;
      box-sizing: border-box;
      outline: none;
      font-size: 14px;
    }

    .input .fa-solid {
      position: absolute;
      top: 65%;
      left: 18px;
      transform: translateY(-50%);
      color: #999;
      font-size: 16px;
      pointer-events: none;
    }

    .input .btn-link {
      font-size: 13px;
      text-align: right;
      display: block;
      margin-top: 5px;
      color: #FFC107;
      text-decoration: none;
    }

    .input .btn-link:hover {
      text-decoration: underline;
    }

    .input button {
      width: 100%;
      padding: 12px;
      border: none;
      border-radius: 30px;
      background: #FFC107;
      color: white;
      font-size: 16px;
      cursor: pointer;
      transition: background 0.3s ease;
    }

    .input button:hover {
      background: #e6ac00;
    }

    .error-message {
      color: red;
      font-size: 14px;
      text-align: center;
    }

    .invalid-feedback {
      color: red;
      font-size: 13px;
    }

    @media screen and (max-width: 768px) {
      .container {
        flex-direction: column;
        height: auto;
      }
    }
  </style>
</head>
<body>
@if (session('error'))
    <div class="alert alert-danger" style="text-align: center; color: red; padding: 10px; margin-bottom: 10px;">
        {{ session('error') }}
    </div>
@endif
<div class="container">
    <div class="left-panel">
        <img src="https://cdn-icons-png.flaticon.com/512/833/833472.png" alt="Logo">
        <h1>K M D</h1>
        <p>Welcome to the University Ideas Portal. This secure system is designed for all academic and support staff to submit, view, and engage with ideas for improvement across the University. Please log in using your staff credentials—your identity will be stored securely for accountability, but you may choose to post ideas and comments anonymously.</p>
        
    </div>
    <div class="login-container">
        <div class="logo-container">
            <h1>KMD</h1>
            <h5>Aim High Think High</h5>
        </div>
        <div class="login-form">
            <form method="POST" action="{{ route('login') }}" onsubmit="return validateForm()">
                @csrf
                <div class="input">
                    <label for="email">Email Address</label>
                    <i class="fa-solid fa-user"></i>
                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                           name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                    @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

                <div class="input">
                    <label for="password">Password</label>
                    <i class="fa-solid fa-lock"></i>
                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror"
                           name="password" required autocomplete="current-password">
                    @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

                <div class="input">
                    @if (Route::has('password.request'))
                        <a class="btn-link" href="{{ route('password.request') }}">
                            {{ __('Forgot Your Password?') }}
                        </a>
                    @endif
                </div>

                <div class="input">
                    <button type="submit">
                        {{ __('Login') }}
                    </button>
                </div>

                <div class="input">
                    <p id="error-message" class="error-message"></p>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    function validateForm() {
        const email = document.getElementById('email').value;
        const password = document.getElementById('password').value;
        const errorMessage = document.getElementById('error-message');

        if (email === "" || password === "") {
            errorMessage.textContent = "All fields are required.";
            return false;
        }

        if (password.length < 6) {
            errorMessage.textContent = "Password must be at least 6 characters long.";
            return false;
        }

        errorMessage.textContent = "";
        return true;
    }
</script>
</body>
</html>





{{-- <!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>

<body>

@if (session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Login') }}</div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('login') }}">
                            @csrf

                            <div class="row mb-3">
                                <label for="email"
                                    class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label>

                                <div class="col-md-6">
                                    <input id="email" type="email"
                                        class="form-control @error('email') is-invalid @enderror" name="email"
                                        value="{{ old('email') }}" required autocomplete="email" autofocus>

                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="password"
                                    class="col-md-4 col-form-label text-md-end">{{ __('Password') }}</label>

                                <div class="col-md-6">
                                    <input id="password" type="password"
                                        class="form-control @error('password') is-invalid @enderror" name="password"
                                        required autocomplete="current-password">

                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6 offset-md-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="remember" id="remember"
                                            {{ old('remember') ? 'checked' : '' }}>

                                        <label class="form-check-label" for="remember">
                                            {{ __('Remember Me') }}
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-0">
                                <div class="col-md-8 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Login') }}
                                    </button>

                                    @if (Route::has('password.request'))
                                        <a class="btn btn-link" href="{{ route('password.request') }}">
                                            {{ __('Forgot Your Password?') }}
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html> --}}
