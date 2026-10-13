<!DOCTYPE html>
<html lang="ru">
<head
<link rel="manifest" href="/manifest.json">
<meta name="theme-color" content="#000000">
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
<meta name="apple-mobile-web-app-title" content="Karaoke">
<link rel="apple-touch-icon" href="/icon-192.png">

<!-- Регистрация Service Worker -->
<script>
    if ('serviceWorker' in navigator) {
        window.addEventListener('load', () => {
            navigator.serviceWorker.register('/sw.js').then(registration => {
                console.log('SW зарегистрирован:', registration.scope);
            }).catch(error => {
                console.log('Ошибка регистрации SW:', error);
            });
        });
    }
</script>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Вход - Караоке</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --color-bg: #000000;
            --color-panel: #141414;
            --color-panel-raised: #222222;
            --color-panel-hover: #2A2A2A;
            --color-border: #222222;
            --color-text: #FFFFFF;
            --color-text-secondary: #AAAAAA;
            --color-primary: #FFCC00;
            --color-primary-hover: #F0B200;
            --font-family: 'Inter', system-ui, -apple-system, sans-serif;
        }

        body {
            background-color: var(--color-bg);
            color: var(--color-text);
            font-family: var(--font-family);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .login-card {
            background-color: var(--color-panel);
            padding: 40px;
            border-radius: 20px;
            width: 100%;
            max-width: 420px;
            text-align: center;
            border: 1px solid var(--color-border);
            box-shadow: 0 10px 30px rgba(0,0,0,0.5);
        }

        .logo {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
            font-weight: 700;
            font-size: 24px;
            margin-bottom: 30px;
            letter-spacing: -0.5px;
        }

        .btn {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 100%;
            padding: 14px;
            border-radius: 24px;
            font-size: 15px;
            font-weight: 600;
            text-decoration: none;
            cursor: pointer;
            transition: all 0.2s;
            border: none;
            box-sizing: border-box;
        }

        .btn-oauth {
            background-color: transparent;
            color: var(--color-primary);
            border: 2px solid var(--color-primary);
            margin-bottom: 20px;
        }

        .btn-oauth:hover {
            background-color: rgba(255, 204, 0, 0.1);
        }

        .btn-submit {
            background: var(--color-primary);
            color: #000;
            margin-top: 10px;
        }

        .btn-submit:hover {
            background: var(--color-primary-hover);
            transform: scale(1.02);
        }

        input {
            width: 100%;
            padding: 14px 20px;
            margin-bottom: 16px;
            background: var(--color-panel-raised);
            border: 1px solid transparent;
            color: var(--color-text);
            border-radius: 12px;
            box-sizing: border-box;
            font-family: inherit;
            font-size: 14px;
            transition: all 0.2s;
        }

        input:focus {
            background: var(--color-panel-hover);
            border-color: var(--color-primary);
            outline: none;
        }

        input::placeholder {
            color: var(--color-text-secondary);
        }

        .instruction {
            font-size: 13px;
            color: var(--color-text-secondary);
            margin-bottom: 24px;
            line-height: 1.5;
            text-align: left;
            background: rgba(255,255,255,0.03);
            padding: 16px;
            border-radius: 12px;
        }

        .instruction b {
            color: var(--color-text);
        }
    </style>
</head>
<body>

<div class="login-card">
    <div class="logo">
        Яндекс Максим Музыка
    </div>

    <a href="https://oauth.yandex.ru/authorize?response_type=token&client_id=23cabbbdc6cd418abb4b39c32c41195d" target="_blank" class="btn btn-oauth">
        Получить токен Яндекса
    </a>

    <div class="instruction">
        Нажми на кнопку выше, авторизуйся, и скопируй длинный токен (начинается с <b>y0_...</b>) из адресной строки пустой страницы.
    </div>

    <form action="<?= base_url('login') ?>" method="post">
        <input type="text" name="username" placeholder="Твое имя (никнейм)" required>
        <input type="text" name="token" placeholder="Вставь токен сюда" required>
        <button type="submit" class="btn btn-submit">Войти и петь</button>
    </form>
</div>

</body>
</html>