<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Добавить песню</title>
    <style>
        body { background: #121212; color: #fff; font-family: sans-serif; padding: 50px; max-width: 600px; margin: 0 auto;}
        input[type="text"] { width: 70%; padding: 10px; border-radius: 5px; border: none; }
        button { padding: 10px 15px; background: #ffd700; border: none; font-weight: bold; cursor: pointer; border-radius: 5px; }
        .track-item { display: flex; justify-content: space-between; align-items: center; background: #1e1e1e; padding: 15px; margin-top: 10px; border-radius: 5px; }
        .track-info strong { display: block; font-size: 18px; }
        .track-info span { color: #888; font-size: 14px; }
    </style>
</head>
<body>
<h2>Поиск в Яндексе</h2>

<form action="/search" method="post" style="margin-bottom: 30px;">
    <input type="text" name="search_query" placeholder="Название или автор" value="<?= esc($query ?? '') ?>" required>
    <button type="submit">Найти</button>
</form>

<?php if (!empty($results)): ?>
    <h3>Результаты:</h3>
    <?php foreach ($results as $track): ?>
        <div class="track-item">
            <div class="track-info">
                <strong><?= esc($track['title']) ?></strong>
                <span><?= esc($track['artist']) ?></span>
            </div>
            <form action="/download" method="post">
                <input type="hidden" name="track_id" value="<?= esc($track['id']) ?>">
                <button type="submit">Скачать</button>
            </form>
        </div>
    <?php endforeach; ?>
<?php elseif(isset($query)): ?>
    <p>Ничего не найдено.</p>
<?php endif; ?>
</body>
</html>