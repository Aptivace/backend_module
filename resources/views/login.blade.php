<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Панель администратора</title>
    <link rel="stylesheet" href="{{asset('bootstrap/css/bootstrap.css')}}">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .login-container {
            max-width: 400px;
            margin: 100px auto;
            padding: 30px;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body>
<div id="loginForm" class="login-container">
    <div class="text-center mb-4">
        <h2 class="fw-bold text-primary">Авторизация администратора</h2>
        <p class="text-muted">Введите ваши учетные данные для доступа к панели управления</p>
    </div>
    <form method="post" action="/admin/login">
        @csrf
        <div class="mb-3">
            <label for="email" class="form-label">Email адрес</label>
            <input type="email" class="form-control" id="email" name="email" placeholder="Введите почту">
            @error('email')
            <span class="text-danger"> {{$message}} </span>
            @enderror
        </div>
        <div class="mb-4">
            <label for="password" class="form-label">Пароль</label>
            <input type="password" class="form-control" id="password" name="password" placeholder="Введите пароль">
            @error('password')
            <span class="text-danger"> {{$message}} </span>
            @enderror
        </div>
        <button type="submit" class="btn btn-primary w-100 py-2 fw-semibold">Войти в систему</button>
        @error('error')
        <span class="text-danger">{{$message}}}</span>
        @enderror
    </form>
</div>
<script src="{{"bootstrap/js/bootstrap.bundle.min.js"}}"></script>
</body>
</html>
