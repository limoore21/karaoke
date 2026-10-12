<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title><?= esc($title) ?></title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #121212;
            color: #ffffff;
            text-align: center;
            margin: 0;
            padding: 20px;
        }
        .header-controls {
            max-width: 600px;
            margin: 0 auto 15px auto;
            text-align: right;
        }
        .btn-add {
            background: transparent;
            color: #888;
            border: 1px solid #333;
            text-decoration: none;
            padding: 8px 16px;
            border-radius: 20px;
            font-size: 13px;
            letter-spacing: 0.5px;
            transition: all 0.3s ease;
        }
        .btn-add:hover {
            color: #fff;
            border-color: #ffd700;
            box-shadow: 0 0 10px rgba(255, 215, 0, 0.2);
        }
        .player-container {
            background: #1e1e1e;
            padding: 20px;
            border-radius: 15px;
            max-width: 600px;
            margin: 0 auto 30px auto;
            box-shadow: 0 4px 15px rgba(0,0,0,0.5);
            position: relative;
        }
        #karaoke-player {
            width: 100%;
            margin-top: 15px;
            outline: none;
        }
        #lyrics-wrapper {
            height: 50vh;
            overflow-y: hidden;
            position: relative;
            max-width: 800px;
            margin: 0 auto;
            mask-image: linear-gradient(to bottom, transparent, black 15%, black 85%, transparent);
            -webkit-mask-image: linear-gradient(to bottom, transparent, black 15%, black 85%, transparent);
        }
        #lyrics {
            padding: 25vh 0;
        }
        .lyric-line {
            font-size: 26px;
            color: #666;
            margin: 15px 0;
            transition: all 0.3s ease;
        }
        .lyric-line.active {
            color: #ffd700;
            font-size: 34px;
            font-weight: bold;
            text-shadow: 0 0 15px rgba(255, 215, 0, 0.4);
        }
        .no-lyrics {
            color: #888;
            font-size: 20px;
            margin-top: 50px;
        }
    </style>
</head>
<body>
<div class="header-controls">
    <a href="/add" class="btn-add">Добавить песню</a>
</div>
<div style="text-align: right; padding: 15px;">
    <span style="color: #8892b0; margin-right: 15px;">
        Привет, <b><?= esc(session()->get('username')) ?></b>!
    </span>
    <a href="<?= base_url('logout') ?>" style="background: #a900ff; color: white; text-decoration: none; padding: 8px 16px; border-radius: 5px; font-weight: bold;">
        Выйти
    </a>
</div>

<div class="player-container">
    <h1>Караоке-плеер</h1>
    <?php if ($song): ?>
        <h2 id="track-artist" style="margin-bottom: 5px;"><?= esc($song['artist']) ?></h2>
        <h3 id="track-title" style="margin-top: 0; color: #888;"><?= esc($song['title']) ?></h3>
        <audio id="karaoke-player" controls>
            <source src="<?= esc($song['audio_path']) ?>" type="audio/mpeg">
        </audio>
    <?php else: ?>
        <p>В базе нет ни одной песни!</p>
    <?php endif; ?>
</div>

<?php if ($song): ?>
    <div id="lyrics-wrapper">
        <div id="lyrics"></div>
    </div>

    <script>
        const audio = document.getElementById('karaoke-player');
        const lyricsContainer = document.getElementById('lyrics');
        let lyricsData = [];

        fetch('<?= esc($song['lyrics_path']) ?>')
            .then(response => response.text())
            .then(text => {
                lyricsData = parseLrc(text);

                if (lyricsData.length > 0) {
                    renderLyrics(lyricsData);
                } else {
                    // Если массив пустой, значит таймкодов в файле нет
                    lyricsContainer.innerHTML = text.trim() === ''
                        ? '<div class="no-lyrics">Текст песни отсутствует в базе Яндекса.</div>'
                        : '<div class="no-lyrics">Для этой песни есть только обычный текст (без синхронизации караоке).</div>';
                }
            })
            .catch(err => console.error('Ошибка загрузки текста:', err));

        function parseLrc(lrcText) {
            const lines = lrcText.split('\n');
            const result = [];
            const timeRegex = /\[(\d{2}):(\d{2}\.\d{2})\](.*)/;
            const metaRegex = /\[(ti|au):(.*)\]/;

            lines.forEach(line => {
                const timeMatch = line.match(timeRegex);
                if (timeMatch) {
                    const time = parseInt(timeMatch[1], 10) * 60 + parseFloat(timeMatch[2]);
                    const text = timeMatch[3].trim();
                    if (text) result.push({ time, text });
                    return;
                }

                const metaMatch = line.match(metaRegex);
                if (metaMatch) {
                    const type = metaMatch[1];
                    const value = metaMatch[2].trim();

                    if (type === 'ti') document.getElementById('track-title').innerText = value;
                    if (type === 'au') document.getElementById('track-artist').innerText = value;
                }
            });
            return result;
        }

        function renderLyrics(data) {
            lyricsContainer.innerHTML = '';
            data.forEach((line, index) => {
                const p = document.createElement('div');
                p.id = 'line-' + index;
                p.className = 'lyric-line';
                p.innerText = line.text;
                lyricsContainer.appendChild(p);
            });
        }

        audio.addEventListener('timeupdate', () => {
            if (lyricsData.length === 0) return;

            const currentTime = audio.currentTime;

            for (let i = 0; i < lyricsData.length; i++) {
                if (currentTime >= lyricsData[i].time && (!lyricsData[i+1] || currentTime < lyricsData[i+1].time)) {

                    const currentActive = document.querySelector('.lyric-line.active');
                    const newActive = document.getElementById('line-' + i);

                    if (currentActive !== newActive) {
                        if (currentActive) {
                            currentActive.classList.remove('active');
                        }
                        if (newActive) {
                            newActive.classList.add('active');
                            newActive.scrollIntoView({ behavior: 'smooth', block: 'center' });
                        }
                    }
                    break;
                }
            }
        });
    </script>
<?php endif; ?>
</body>
</html>