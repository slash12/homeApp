<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ asset('css/main.css') }}">
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/iziToast.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/jquery-confirm.min.css') }}">
    @yield('header')
</head>
<body>
        <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
                <a class="navbar-brand" href="/">Home App</a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarColor01" aria-controls="navbarColor01" aria-expanded="false" aria-label="Toggle navigation">
                  <span class="navbar-toggler-icon"></span>
                </button>
              
                <div class="collapse navbar-collapse" id="navbarColor01">
                  <ul class="navbar-nav mr-auto">
                    <li class="nav-item">
                      <a class="nav-link" href="/temp">Temperature</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" href="#">Expenses</a>
                    </li>
                  </ul>
                </div>
              </nav>

              <div class="container">
                @yield('content')
              </div>
    

    <script src="{{ asset('js/jquery.slim.js') }}"></script>
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('js/iziToast.min.js') }}"></script>
    <script src="{{ asset('js/jquery-confirm.min.js') }}"></script>
    @yield('script')
</body>
</html>