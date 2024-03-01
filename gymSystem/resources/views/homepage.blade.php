    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>@yield('title', 'Home Page')</title>
        <style>
        body {
                margin: 0;
                padding: 0;
                font-family: Arial, sans-serif;
                background: url('images/admin_home.jpg') center/cover no-repeat fixed;
            }

            .container {
                display: flex;
            }

            .navigation {
                width: 200px;
                min-height: 100vh;
                padding: 20px;
                background: rgba(0, 0, 0, 0.5);
            }

            .navigation h2 {
                color: #cc0000;
                margin-bottom: 20px;
                border-bottom: 2px solid #cc0000;
                padding-bottom: 10px; 
            }

            .navigation a.nav {
                display: block;
                color: #ccc;
                text-decoration: none;
                margin-top: 30px;
                margin-bottom: 10px;
                font-size: 1.1em;
            }

            .navigation a.nav:hover {
                transform: scale(1.05);
                transition: transform ease .4s;
            }

            .container .navigation .sep {
                border-bottom: 2px solid #777;
                margin-bottom: 5px;
            }

            .content {
                flex: 1;
                padding: 20px;
            }

            .logout-btn {
                background-color: #80000d;
                color: #ddd;
                border: none;
                padding: 10px 20px;
                border-radius: 4px;
                cursor: pointer;
                font-size: 1em;
            }

            .logout-btn:hover {
                background-color: #500000;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <div class="navigation">
                <h2>Welcome, <br> {{ auth()->user()->name }}</h2>
                <a class="nav" href="#">Customers</a>
                <div class="sep"></div>
                <a class="nav" href="#">Trainers</a>
                <div class="sep"></div>
                <a class="nav" href="#">Plans</a>
                <div class="sep"></div>
                <a class="nav" href="#">Sessions</a>
                <div class="sep"></div>
                <a class="nav" href="#">Transactions</a>
                <div class="sep"></div>
                <a class="nav" href="#">Equipments</a>
                <div class="sep"></div>
                <br>    
                <a class="logout" href="{{route('logout')}}">
                    <button class="logout-btn">Logout</button>
                </a>
            </div>
            <div class="content">
       
            </div>
        </div>
    </body>
</html>