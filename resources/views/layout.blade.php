<!-- FILEPATH: /home/moh/Demo/php/demo_laravel_without_freamwork/resources/views/layout.blade.php -->
<!DOCTYPE html>
<html>
<head>
    <title>My Website</title>
    <style>
        .navbar {
            background-color: #333;
            color: #fff;
            padding: 10px;
        }
        
        .navbar ul {
            list-style-type: none;
            margin: 0;
            padding: 0;
            overflow: hidden;
        }
        
        .navbar li {
            float: left;
        }
        
        .navbar li a {
            display: block;
            color: #fff;
            text-align: center;
            padding: 14px 16px;
            text-decoration: none;
        }
        
        .navbar li a:hover {
            background-color: #111;
        }
    </style>
</head>
<body>
    <div class="navbar">
        <ul>
            <li><a href="/">Home</a></li>
            <li><a href="/about">About</a></li>
            <li><a href="/staticPage">Services</a></li>
        </ul>
    </div>

    <div>
        @yield('staticPage')
        @yield('welcome')
        @yield('about')
    </div>
</body>
</html>
