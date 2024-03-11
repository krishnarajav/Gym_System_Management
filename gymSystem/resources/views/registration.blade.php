<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Registration Page')</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            background: url('images/logged_out.jpg') center/cover no-repeat fixed;
        }

        .registration-container {
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }

        .registration-form {
            background-color: rgba(255, 255, 255, 0.04);
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 10px 10px rgba(255, 255, 255, 0.5);
            max-width: 400px;
            width: 350px;
            height: 550px;
            text-align: left;
            color: #ddd;
        }

        .form-group {
            margin-bottom: 20px;
        }
        
        h1 {
            text-align: center;
            color: #ddd;
            margin-top: 10px;
            margin-bottom: 20px;
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

        .login-register {
            text-align: center;
            color: #aaa;
        }

        .login-link {
            color: #ccc;
            text-decoration: none;
            font-weight: bold;
            font-style: normal;
        }

        ::placeholder {
            color: #aaa;
        }

        .alert-danger {
            margin-top: 10px;
            text-align: center;
            justify-content: center;
            color: rgb(255, 80, 80);
        }

    </style>
</head>

<body>
    <div class="registration-container">
        <form class="registration-form" action="{{route('registration.post')}}" method="post">
            @csrf
            <h1>Registration</h1>
            <div class="form-group">
                <label for="username">Full Name</label>
                <input type="text" name="name" placeholder="Enter Full Name" required>
            </div>
            <div class="form-group">
                <label for="username">UserID</label>
                <input type="text" name="id" placeholder="Enter UserID" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" name="password" placeholder="Enter Password" required>
            </div>
            <div class="form-group">
                <label for="password">Confirm Password</label>
                <input type="password" name="password_confirmation" placeholder="Enter Confirmation Password" required>
            </div>
            <button type="submit">Register</button>
            <div class="nt-5">
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
                <p>Already have an account? <a href="{{route('login')}}" class="login-link">Login</a></p>
            </div>
        </form>
    </div>
</body>
</html>
