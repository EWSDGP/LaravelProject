<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>University Staff/Admin Login</title>
    <!-- <link rel="stylesheet" href="style.css"> -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;700&display=swap" rel="stylesheet">
</head>

<style>

body {
    font-family: 'Poppins', sans-serif;
    /*background: linear-gradient(to right, #00ABE4, #336699);*/
    background: linear-gradient(to right, #fff, #00ABE4);
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    margin: 0;
}

.login-container {
    background: #fff;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    max-width: 400px;
    width: 100%;
}

.logo-container {
    text-align: center;
    margin-bottom: 20px;
}

/*.logo {
    width: 100px;
    height: 100px;
}*/

.logo-container h1 {
    margin: 10px 0 0;
    color: #333;
}

.logo-container h5 {
    margin: 10px 0 0;
    color: #F59A23;
}

.login-form {
    display: flex;
    flex-direction: column;
}

.input {
    margin-bottom: 15px;
}

.input label {
    display: block;
    margin-bottom: 5px;
    color: #333;
}

.input input {
    width: 100%;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 4px;
    box-sizing: border-box;
}

.input .forgot-password {
    display: block;
    text-align: right;
    margin-top: -10px;
    margin-bottom: 10px;
    color: #0066cc;
    text-decoration: none;
}

.input .forgot-password:hover {
    text-decoration: underline;
}

.input button {
    width: 100%;
    padding: 10px;
    background: #00ABE4;
    color: #fff;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    font-size: 16px;
}

.input button:hover {
    background: #003366;
}

.error-message {
    color: red;
    text-align: center;
    margin-top: 10px;
}

.register-container {
    background: #fff;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    max-width: 400px;
    width: 100%;
}

.register-form {
    display: flex;
    flex-direction: column;
}

.input input, .input select {
    width: 100%;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 4px;
    box-sizing: border-box;
}

.radio-group {
    display: flex;
}

.radio-group label {
    display: flex;
    align-items: center;
    color: #333;
}


</style>

<body>
@if (session('error'))
    <div class="alert alert-danger" style="text-align: center; color: red; padding: 10px; margin-bottom: 10px;">
        {{ session('error') }}
    </div>
@endif

    <div class="login-container">
        <div class="logo-container">
            <!-- <img src="hhh.png" alt="Logo" class="logo"> -->
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
                        <a class="btn btn-link" href="{{ route('password.request') }}">
                            {{ __('Forgot Your Password?') }}
                        </a>
                    @endif
                </div>
                <div class="input">
                    <button type="submit" class="btn btn-primary">
                        {{ __('Login') }}
                    </button>
                    
                </div>
                <div class="input">
                    <p id="error-message" class="error-message"></p>
                </div>
            </form>
        </div>
    </div>
    <script>
        function validateForm() {
            const username = document.getElementById('username').value;
            const password = document.getElementById('password').value;
            const errorMessage = document.getElementById('error-message');

            if (username === "" || password === "") {
                errorMessage.textContent = "All fields are required.";
                return false;
            }

            if (password.length < 6) {
                errorMessage.textContent = "Password must be at least 6 characters long.";
                return false;
            }

            errorMessage.textContent = "";
            alert('Login successful!');
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
