<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>University Staff/Admin Login</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;700&display=swap" rel="stylesheet">
    <style>
        body {
            margin: 0;
            font-family: 'Poppins', sans-serif;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: stretch;
        }

        .container {
            display: flex;
            width: 100%;
            height: 100%;
        }

        .left-panel {
            flex: 1;
            color: white;
            padding: 60px 40px;
            background: linear-gradient(135deg, #ff6a00, #ee0979);
            display: flex;
            flex-direction: column;
            justify-content: center;
            text-align: left;
        }

        .left-panel h1 {
            font-size: 36px;
            margin-bottom: 20px;
        }

        .left-panel p {
            font-size: 16px;
            line-height: 1.6;
        }

        .login-container {
            flex: 1;
            background: #fff;
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 40px;
            max-width: 500px;
            width: 100%;
            box-sizing: border-box;
        }

        .logo-container {
            text-align: center;
            margin-bottom: 30px;
        }

        .logo-container h1 {
            margin: 0;
            color: #333;
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

        .input label {
            font-weight: 500;
            margin-bottom: 5px;
            display: block;
            color: #333;
        }

        .input input {
            width: 100%;
            padding: 12px;
            border: 1px solid #ccc;
            border-radius: 30px;
            box-sizing: border-box;
            outline: none;
            font-size: 14px;
        }

        .input input:focus {
            border-color: #8E2DE2;
        }

        .input .forgot-password,
        .btn-link {
            font-size: 13px;
            text-align: right;
            display: block;
            margin-top: 5px;
            color: #8E2DE2;
            text-decoration: none;
        }

        .input .forgot-password:hover,
        .btn-link:hover {
            text-decoration: underline;
        }

        .input button {
            width: 100%;
            padding: 12px;
            border: none;
            border-radius: 30px;
            background: linear-gradient(to right, #8E2DE2, #4A00E0);
            color: white;
            font-size: 16px;
            cursor: pointer;
            transition: background 0.3s ease;
        }

        .input button:hover {
            background: linear-gradient(to right, #4A00E0, #8E2DE2);
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
            }
            .left-panel, .login-container {
                flex: none;
                width: 100%;
                padding: 30px;
                height: auto;
            }
            .left-panel {
                text-align: center;
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
    <!-- Left welcome panel -->
    <div class="left-panel">
        <h1>Welcome to School</h1>
        <p>Hello Welcome from Our School Website. Have a nice day!!!</p>
    </div>

    <!-- Right login panel -->
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
