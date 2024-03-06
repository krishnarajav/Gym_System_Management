<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>@yield('title', 'Home Page')</title>
        <link rel="stylesheet" href="{{asset('css/styles.css')}}">
    </head>
    <body>
        <div class="container">
            <div class="navigation">
                <h2>Welcome,<br>{{ session('name') }}</h2>
                <a class="nav" href="{{route('customers')}}">Customers</a>
                <div class="sep"></div>
                <a class="nav" href="{{route('trainers')}}">Trainers</a>
                <div class="sep"></div>
                <a class="nav" href="{{route('plans')}}">Plans</a>
                <div class="sep"></div>
                <a class="nav" href="{{route('sessions')}}">Sessions</a>
                <div class="sep"></div>
                <a class="nav" href="{{route('paytransactions')}}">Transactions</a>
                <div class="sep"></div>
                <a class="nav" href="{{route('equipments')}}">Equipments</a>
                <div class="sep"></div>
                <br>    
                <a class="logout" href="{{route('logout')}}">
                    <button class="logout-btn">Logout</button>
                </a>
            </div>

            <div class="content">
                @section('content')

                @show
            </div>
            
        </div>
    </body>
</html>