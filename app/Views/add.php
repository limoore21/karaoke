<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Добавить песню</title>
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

        * { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            background: var(--color-bg);
            color: var(--color-text);
            font-family: var(--font-family);
            min-height: 100vh;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 40px 20px;
        }

        .header {
            display: flex;
            align-items: center;
            margin-bottom: 30px;
            gap: 16px;
        }

        .btn-back {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: var(--color-panel-raised);
            color: var(--color-text);
            text-decoration: none;
            transition: all 0.2s;
        }

        .btn-back:hover {
            background: var(--color-panel-hover);
            color: var(--color-primary);
        }

        h2 {
            font-size: 24px;
            font-weight: 700;
            letter-spacing: -0.5px;
        }

        .search-form {
            display: flex;
            gap: 12px;
            margin-bottom: 40px;
        }

        input[type="text"] {
            flex: 1;
            padding: 0 20px;
            height: 48px;
            border-radius: 24px;
            border: 1px solid transparent;
            background: var(--color-panel-raised);
            color: var(--color-text);
            font-family: inherit;
            font-size: 15px;
            transition: all 0.2s;
        }

        input[type="text"]:focus {
            background: var(--color-panel-hover);
            border-color: var(--color-primary);
            outline: none;
        }

        .btn-search {
            padding: 0 24px;
            height: 48px;
            background: var(--color-primary);
            color: #000;
            border: none;
            font-weight: 600;
            font-size: 15px;
            cursor: pointer;
            border-radius: 24px;
            transition: transform 0.2s, background 0.2s;
        }

        .btn-search:hover {
            background: var(--color-primary-hover);
            transform: scale(1.02);
        }

        .results-title {
            font-size: 18px;
            font-weight: 600;
            margin-bottom: 16px;
            color: var(--color-text-secondary);
        }

        .track-list {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .track-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: var(--color-panel);
            padding: 12px 16px;
            border-radius: 12px;
            border: 1px solid var(--color-border);
            transition: background 0.2s;
        }

        .track-item:hover {
            background: var(--color-panel-hover);
        }

        .track-info {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .track-icon {
            width: 40px;
            height: 40px;
            border-radius: 8px;
            background: var(--color-panel-raised);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--color-text-secondary);
        }

        .track-title {
            display: block;
            font-size: 15px;
            font-weight: 600;
            margin-bottom: 4px;
        }

        .track-artist {
            color: var(--color-text-secondary);
            font-size: 13px;
        }

        .btn-download {
            background: var(--color-panel-raised);
            color: var(--color-text);
            border: none;
            padding: 8px 16px;
            border-radius: 16px;
            font-weight: 500;
            font-size: 13px;
            cursor: pointer;
            transition: all 0.2s;
        }

        .btn-download:hover {
            background: var(--color-primary);
            color: #000;
        }

        .empty-state {
            color: var(--color-text-secondary);
            text-align: center;
            padding: 40px;
            background: var(--color-panel);
            border-radius: 16px;
            border: 1px dashed var(--color-border);
        }
    </style>
</head/
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
</script>>
<body>

<div class="container">
    <div class="header">
        <a href="/" class="btn-back" title="Вернуться к плееру">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
        </a>
        <h2>Поиск музыки</h2>
    </div>

    <form action="/search" method="post" class="search-form">
        <input type="text" name="search_query" placeholder="Название трека или исполнитель..." value="<?= esc($query ?? '') ?>" required>
        <button type="submit" class="btn-search">Найти</button>
    </form>

    <?php if (!empty($results)): ?>
        <div class="results-title">Результаты поиска</div>
        <div class="track-list">
            <?php foreach ($results as $track): ?>
                <div class="track-item">
                    <div class="track-info">
                        <div class="track-icon">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 18V5l12-2v13"></path><circle cx="6" cy="18" r="3"></circle><circle cx="18" cy="16" r="3"></circle></svg>
                        </div>
                        <div>
                            <span class="track-title"><?= esc($track['title']) ?></span>
                            <span class="track-artist"><?= esc($track['artist']) ?></span>
                        </div>
                    </div>
                    <form action="/download" method="post" style="margin: 0;">
                        <input type="hidden" name="track_id" value="<?= esc($track['id']) ?>">
                        <button type="submit" class="btn-download">Скачать</button>
                    </form>
                </div>
            <?php endforeach; ?>
        </div>
    <?php elseif(isset($query)): ?>
        <div class="empty-state">
            По запросу «<?= esc($query) ?>» ничего не найдено.<br>Попробуйте изменить поисковую фразу.
        </div>
    <?php endif; ?>
</div>

</body>
</html>