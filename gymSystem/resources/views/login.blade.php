<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Login Page')</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            background: url('images/login.jpg') center/cover no-repeat fixed;
        }

        .login-container {
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }

        .login-form {
            background-color: rgba(255, 255, 255, 0.04);
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 10px 10px rgba(255, 255, 255, 0.5);
            max-width: 400px;
            width: 350px;
            height: 430px;
            text-align: left;
            color: #ddd;
        }

        .success-message {
            text-align: center;
            color: #68b1ff;
        }

        .form-group {
            margin-bottom: 30px;
        }
        
        h1 {
            text-align: center;
            color: #ddd;
            margin-bottom: 50px;
        }

        label {
            display: block;
            font-weight: bold;
            margin-bottom: 10px;
        }

        input {
            width: 100%;
            height: 40px;
            background: none;   
            padding: 10px;
            box-sizing: border-box;
            border: 1px solid #ddd;
            border-radius: 4px;
            margin-bottom: 5px;
            color: #ddd;
            font-size: 0.9em;
        }

        button {
            background-color: #550000;
            width: 100%;
            height: 40px;
            color: #ddd;
            border: none;
            padding: 10px 20px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 1.1em;
            font-weight: bold;
        }

        button:hover {
            background-color: #002040;
        }

        .error-message {
            color: rgb(255, 80, 80);
            margin-top: 10px;
            text-align: center;
        }

        .login-register {
            text-align: center;
            color: #aaa;
        }

        .register-link {
            color: #ccc;
            text-decoration: none;
            font-weight: bold;
            font-style: normal;
        }

        ::placeholder {
            color: #aaa;
        }
    </style>
</head>

<body>
    <div class="login-container">
        <form class="login-form" action="{{route('login.post')}}" method="post">
            <div class="success-message">
                @if(session()->has('success'))
                    <div class="alert alert-success">{{session('success')}}</div>
                @endif
            </div>
            @csrf
            <h1>Login</h1>
            <div class="form-group">
                <label for="username">UserID</label>
                <input type="text" name="id" placeholder="Enter UserID" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" name="password" placeholder="Enter Password" required>
            </div>
            <button type="submit">Login</button>
            <div class="error-message">
                @if($errors->any())
                    <div class="col-12">
                        @foreach($errors->all() as $error)
                            <div class="alert alert-danger">{{$error}}</div>
                        @endforeach
                    </div>
                @endif
        
                @if(session()->has('error'))
                    <div class="alert alert-danger">{{session('error')}}</div>
                @endif
            </div>
            <div class="login-register">
                <p>Don't have an account? <a href="{{route('registration')}}" class="register-link">Register</a></p>
            </div>
        </form>
    </div>
</body>
</html>
