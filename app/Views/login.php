<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Вход - Караоке</title>
    <style>
        body { background-color: #1a1e29; color: #fff; font-family: sans-serif; display: flex; justify-content: center; align-items: center; height: 100vh; margin: 0; }
        .login-card { background-color: #242938; padding: 30px; border-radius: 10px; width: 100%; max-width: 400px; text-align: center; box-shadow: 0 4px 15px rgba(0,0,0,0.3); }
        .login-card h2 { margin-top: 0; margin-bottom: 20px; }
        .btn-oauth { display: block; background-color: #ffcc00; color: #000; text-decoration: none; padding: 10px; border-radius: 5px; margin-bottom: 20px; font-weight: bold; }
        input { width: 100%; padding: 12px; margin-bottom: 15px; background: #151821; border: 1px solid #333a4f; color: white; border-radius: 5px; box-sizing: border-box; }
        .btn-submit { width: 100%; padding: 12px; background: #ff4757; color: white; border: none; border-radius: 5px; font-weight: bold; cursor: pointer; font-size: 16px; }
        .btn-submit:hover { background: #ff6b81; }
        .instruction { font-size: 12px; color: #8892b0; margin-bottom: 20px; text-align: left; }
    </style>
</head>
<body>
<div class="login-card">
    <h2>Вход в Караоке</h2>

    <a href="https://oauth.yandex.ru/authorize?response_type=token&client_id=23cabbbdc6cd418abb4b39c32c41195d" target="_blank" class="btn-oauth">
        1. Получить токен Яндекса
    </a>

    <div class="instruction">
        Нажми на кнопку выше, авторизуйся, и скопируй длинный токен (начинается с <b>y0_...</b>) из адресной строки пустой страницы.
    </div>

    <form action="<?= base_url('login') ?>" method="post">
        <input type="text" name="username" placeholder="Твое имя (никнейм)" required>
        <input type="text" name="token" placeholder="Вставь токен сюда" required>
        <button type="submit" class="btn-submit">Войти и петь</button>
    </form>
</div>
</body>
</html>