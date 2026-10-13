<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title><?= esc($title ?? 'Karaoke Player') ?></title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

<!--    для кроссплатформенности-->
    <link rel="manifest" href="/manifest.json">
    <meta name="theme-color" content="#000000">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="apple-mobile-web-app-title" content="Karaoke">

    <style>
        #lyrics {
            padding: 220px 0;
        }
        :root {
            --color-bg: #000000;
            --color-panel: #141414;
            --color-panel-raised: #222222;
            --color-panel-hover: #2A2A2A;
            --color-panel-active: #1A1A1A;
            --color-border: #222222;
            --color-border-strong: #333333;

            --color-text: #FFFFFF;
            --color-text-secondary: #AAAAAA;
            --color-text-muted: #777777;

            --color-primary: #FFCC00;
            --color-primary-hover: #F0B200;
            --color-primary-soft: rgba(255, 204, 0, 0.1);

            --font-family: 'Inter', system-ui, -apple-system, sans-serif;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: var(--font-family);
            background: var(--color-bg);
            color: var(--color-text);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            overflow-x: hidden;
        }

        /* --- HEADER --- */
        .app-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            height: 72px;
            padding: 0 32px;
            background: var(--color-panel);
            border-bottom: 1px solid var(--color-border);
            flex-wrap: wrap;
        }

        .header-left {
            display: flex;
            align-items: center;
            min-width: auto;
        }

        .logo {
            display: flex;
            align-items: center;
            gap: 12px;
            font-weight: 700;
            font-size: 20px;
            color: var(--color-text);
            text-decoration: none;
            letter-spacing: -0.5px;
        }

        .header-center {
            flex: 1;
            display: flex;
            justify-content: center;
            padding: 0 20px;
        }

        .search-bar {
            position: relative;
            display: flex;
            align-items: center;
            width: 100%;
            max-width: 600px;
        }

        .search-bar input {
            width: 100%;
            height: 44px;
            background: var(--color-panel-raised);
            border: 1px solid transparent;
            border-radius: 22px;
            padding: 0 20px 0 44px;
            color: var(--color-text);
            font-family: inherit;
            font-size: 14px;
            outline: none;
            transition: all 0.2s;
        }

        .search-bar input:focus {
            background: var(--color-panel-hover);
            border-color: var(--color-primary);
        }

        .search-icon {
            position: absolute;
            left: 16px;
            color: var(--color-text-muted);
            width: 18px;
            height: 18px;
        }

        .header-right {
            display: flex;
            align-items: center;
            justify-content: flex-end;
            gap: 20px;
            min-width: auto;
        }

        .user-greeting {
            font-size: 14px;
            color: var(--color-text-secondary);
            white-space: nowrap;
        }

        .btn {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            height: 40px;
            padding: 0 16px;
            border-radius: 20px;
            font-size: 14px;
            font-weight: 500;
            text-decoration: none;
            cursor: pointer;
            transition: all 0.2s;
            border: 1px solid transparent;
        }

        .btn-danger {
            background: var(--color-panel-raised);
            color: var(--color-text);
        }

        .btn-danger:hover {
            background: #E66A7A;
            color: #fff;
        }

        /* --- MAIN LAYOUT --- */
        .main-content {
            flex: 1;
            display: grid;
            grid-template-columns: minmax(0, 2.15fr) minmax(320px, 0.95fr);
            gap: 24px;
            max-width: 1600px;
            width: 100%;
            margin: 0 auto;
            padding: 32px;
        }

        /* --- PANELS --- */
        .panel {
            background: var(--color-panel);
            border: 1px solid var(--color-border);
            border-radius: 16px;
            padding: 24px;
        }

        /* --- PLAYER --- */
        .player-panel {
            display: flex;
            flex-direction: column;
            gap: 24px;
            margin-bottom: 24px;
        }

        .player-info {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .cover-art {
            width: 136px;
            height: 136px;
            border-radius: 12px;
            background: var(--color-panel-raised);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--color-text-muted);
            flex-shrink: 0;
            box-shadow: 0 8px 24px rgba(0,0,0,0.5);
        }

        .track-details {
            flex: 1;
        }

        .track-title {
            font-size: 28px;
            font-weight: 700;
            margin-bottom: 8px;
            letter-spacing: -0.5px;
        }

        .track-artist {
            font-size: 16px;
            color: var(--color-text-secondary);
            margin-bottom: 12px;
            font-weight: 500;
        }

        .track-tags {
            display: flex;
            gap: 8px;
        }

        .tag {
            background: var(--color-panel-raised);
            color: var(--color-text);
            padding: 4px 12px;
            border-radius: 16px;
            font-size: 12px;
            font-weight: 500;
        }

        .progress-container {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .time {
            font-size: 12px;
            color: var(--color-text-muted);
            font-variant-numeric: tabular-nums;
            font-weight: 500;
        }

        .progress-bar-wrapper {
            flex: 1;
            height: 24px;
            display: flex;
            align-items: center;
            cursor: pointer;
        }

        .progress-bar {
            width: 100%;
            height: 4px;
            background: var(--color-panel-raised);
            border-radius: 2px;
            position: relative;
        }

        .progress-fill {
            position: absolute;
            left: 0;
            top: 0;
            height: 100%;
            background: var(--color-primary);
            border-radius: 2px;
            width: 0%;
        }

        .progress-thumb {
            position: absolute;
            right: -6px;
            top: -4px;
            width: 12px;
            height: 12px;
            background: var(--color-primary);
            border-radius: 50%;
            opacity: 0;
            transition: opacity 0.2s, transform 0.2s;
        }

        .progress-bar-wrapper:hover .progress-thumb {
            opacity: 1;
            transform: scale(1.2);
        }

        .controls-container {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .main-controls {
            display: flex;
            align-items: center;
            gap: 20px;
            flex: 1;
            justify-content: center;
        }

        .control-btn {
            background: none;
            border: none;
            color: var(--color-text-secondary);
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: color 0.2s;
        }

        .control-btn:hover {
            color: var(--color-text);
        }

        .play-btn {
            width: 56px;
            height: 56px;
            border-radius: 50%;
            background: var(--color-primary);
            color: #000;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: transform 0.2s, background 0.2s;
        }

        .play-btn:hover {
            background: var(--color-primary-hover);
            transform: scale(1.05);
        }

        .play-btn svg {
            fill: #000;
            stroke: #000;
        }

        .volume-control {
            display: flex;
            align-items: center;
            gap: 12px;
            width: 140px;
        }

        .volume-slider {
            width: 100%;
            height: 4px;
            background: var(--color-panel-raised);
            border-radius: 2px;
            appearance: none;
            outline: none;
        }

        .volume-slider::-webkit-slider-thumb {
            appearance: none;
            width: 12px;
            height: 12px;
            border-radius: 50%;
            background: var(--color-text);
            cursor: pointer;
        }

        /* --- KARAOKE --- */


        .karaoke-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 24px;
        }

        .karaoke-title {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 16px;
            font-weight: 600;
        }

        .karaoke-panel {
            height: 500px; /* Жестко ограничиваем высоту всей панели */
            display: flex;
            flex-direction: column;
        }

        .lyrics-container {
            flex: 1;
            overflow-y: hidden; /* Полностью скрываем ручной скролл, крутит только JS */
            position: relative;
            text-align: center;
            mask-image: linear-gradient(to bottom, transparent, black 15%, black 85%, transparent);
            -webkit-mask-image: linear-gradient(to bottom, transparent, black 15%, black 85%, transparent);
        }

        .lyrics-container::-webkit-scrollbar {
            display: none;
        }

        .lyric-line {
            font-size: 32px; /* Увеличили базовый размер */
            color: var(--color-text-muted);
            margin: 24px 0; /* Раздвинули строки */
            line-height: 1.5;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            opacity: 0.3;
            font-weight: 600;
        }

        .lyric-line.active {
            color: var(--color-text);
            font-size: 46px; /* Крупная активная строка */
            font-weight: 800;
            opacity: 1;
            text-shadow: 0 0 24px rgba(255, 204, 0, 0.4); /* Мягкое желтое свечение под стиль кнопок */
        }

        /* --- PLAYLIST --- */
        .playlist-panel {
            display: flex;
            flex-direction: column;
            height: 100%;
        }

        .playlist-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .playlist-title {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 18px;
            font-weight: 700;
        }

        .song-list {
            flex: 1;
            overflow-y: auto;
            display: flex;
            flex-direction: column;
            gap: 4px;
        }

        .song-list::-webkit-scrollbar {
            width: 6px;
        }

        .song-list::-webkit-scrollbar-thumb {
            background: var(--color-panel-raised);
            border-radius: 3px;
        }

        .song-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 10px 16px;
            border-radius: 8px;
            background: transparent;
            text-decoration: none;
            transition: background 0.2s;
            border: 1px solid transparent;
        }

        .song-item:hover {
            background: var(--color-panel-hover);
        }

        .song-item.active {
            background: var(--color-primary-soft);
        }

        .song-item-info {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .song-icon {
            color: var(--color-text-muted);
        }

        .song-item.active .song-icon {
            color: var(--color-primary);
        }

        .song-name {
            color: var(--color-text);
            font-size: 14px;
            font-weight: 600;
            margin-bottom: 4px;
        }

        .song-item.active .song-name {
            color: var(--color-primary);
        }

        .song-artist {
            color: var(--color-text-secondary);
            font-size: 12px;
        }

        .btn-add-song {
            margin-top: 16px;
            background: var(--color-panel-raised);
            color: var(--color-text);
            transition: all 0.2s;
        }

        .btn-add-song:hover {
            background: var(--color-panel-hover);
            color: var(--color-primary);
        }

        /* --- FOOTER --- */
        .app-footer {
            height: 70px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 32px;
            background: var(--color-panel);
            font-size: 14px;
            border-top: 1px solid var(--color-border);
        }

        .footer-link {
            color: var(--color-text-muted);
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 8px;
            transition: color 0.2s;
            font-weight: 500;
        }

        .footer-link:hover {
            color: var(--color-primary);
        }

        .hidden { display: none; }

        /* =========================================
           АДАПТИВНОСТЬ (Планшеты и Мобильные)
           ========================================= */
        @media (max-width: 1024px) {
            .main-content {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 768px) {
            /* Шапка */
            .app-header { padding: 12px 16px; height: auto; gap: 12px; }
            .header-center { order: 3; width: 100%; padding: 0; }
            .header-right { gap: 12px; }
            .user-greeting { display: none; }
            .btn-danger span { display: none; }
            .btn-danger { padding: 0; width: 40px; height: 40px; border-radius: 50%; }

            .main-content { padding: 12px; gap: 16px; }
            .panel { padding: 16px; }

            /* Компактный плеер (горизонтальный) */
            .player-info { flex-direction: row; text-align: left; gap: 12px; }
            .cover-art { width: 56px; height: 56px; border-radius: 8px; }
            .track-details { flex: 1; display: flex; flex-direction: column; justify-content: center; }
            .track-title { font-size: 16px; margin-bottom: 2px; }
            .track-artist { font-size: 13px; margin-bottom: 0; }
            .track-tags { display: none; } /* Скрываем тег для экономии места */

            /* Контролы плеера */
            .controls-container { flex-direction: column; gap: 16px; }
            .controls-container > div:first-child { display: none; }
            .main-controls { width: 100%; justify-content: space-between; }
            .play-btn { width: 48px; height: 48px; }
            .volume-control { display: none; }

            /* Панель караоке (отдаем 50% высоты экрана) */
            .karaoke-panel { height: 50vh; min-height: 350px; }
            #lyrics { padding: 25vh 0; } /* Динамический отступ для центрирования на телефонах */

            /* Уменьшаем шрифты для мобилок, чтобы строки не ломались */
            .lyric-line { font-size: 18px; margin: 16px 0; }
            .lyric-line.active { font-size: 22px; text-shadow: 0 0 12px rgba(255, 204, 0, 0.4); }

            /* Подвал */
            .app-footer { flex-direction: column; height: auto; padding: 20px 16px; gap: 16px; text-align: center; }
        }
    </style>
</head>
<body>

<!-- SVG Icons -->
<svg style="display: none;">
    <symbol id="icon-search" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></symbol>
    <symbol id="icon-music" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 18V5l12-2v13"></path><circle cx="6" cy="18" r="3"></circle><circle cx="18" cy="16" r="3"></circle></symbol>
    <symbol id="icon-logout" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path><polyline points="16 17 21 12 16 7"></polyline><line x1="21" y1="12" x2="9" y2="12"></line></symbol>
    <symbol id="icon-play" viewBox="0 0 24 24" fill="currentColor" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="5 3 19 12 5 21 5 3"></polygon></symbol>
    <symbol id="icon-pause" viewBox="0 0 24 24" fill="currentColor" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="6" y="4" width="4" height="16"></rect><rect x="14" y="4" width="4" height="16"></rect></symbol>
    <symbol id="icon-skip-back" viewBox="0 0 24 24" fill="currentColor" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="19 20 9 12 19 4 19 20"></polygon><line x1="5" y1="19" x2="5" y2="5"></line></symbol>
    <symbol id="icon-skip-forward" viewBox="0 0 24 24" fill="currentColor" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="5 4 15 12 5 20 5 4"></polygon><line x1="19" y1="5" x2="19" y2="19"></line></symbol>
    <symbol id="icon-shuffle" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="16 3 21 3 21 8"></polyline><line x1="4" y1="20" x2="21" y2="3"></line><polyline points="21 16 21 21 16 21"></polyline><line x1="15" y1="15" x2="21" y2="21"></line><line x1="4" y1="4" x2="9" y2="9"></line></symbol>
    <symbol id="icon-repeat" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="17 1 21 5 17 9"></polyline><path d="M3 11V9a4 4 0 0 1 4-4h14"></path><polyline points="7 23 3 19 7 15"></polyline><path d="M21 13v2a4 4 0 0 1-4 4H3"></path></symbol>
    <symbol id="icon-volume" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="11 5 6 9 2 9 2 15 6 15 11 19 11 5"></polygon><path d="M19.07 4.93a10 10 0 0 1 0 14.14M15.54 8.46a5 5 0 0 1 0 7.07"></path></symbol>
    <symbol id="icon-mic" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 2a3 3 0 0 0-3 3v7a3 3 0 0 0 6 0V5a3 3 0 0 0-3-3Z"></path><path d="M19 10v2a7 7 0 0 1-14 0v-2"></path><line x1="12" y1="19" x2="12" y2="22"></line></symbol>
    <symbol id="icon-code" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="16 18 22 12 16 6"></polyline><polyline points="8 6 2 12 8 18"></polyline></symbol>
    <symbol id="icon-mail" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path><polyline points="22,6 12,13 2,6"></polyline></symbol>
    <symbol id="icon-plus" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></symbol>
</svg>

<!-- Header -->
<header class="app-header">
    <div class="header-left">
        <a href="/" class="logo">
            Яндекс Максим Музыка
        </a>
    </div>
    <div class="header-center">
        <div class="search-bar">
            <svg class="search-icon"><use href="#icon-search"></use></svg>
            <input type="text" placeholder="Поиск песен...">
        </div>
    </div>
    <div class="header-right">
        <span class="user-greeting">
            Привет, <b style="color: var(--color-text);"><?= esc(session()->get('username') ?? 'Гость') ?></b>!
        </span>
        <a href="<?= base_url('logout') ?>" class="btn btn-danger" title="Выйти">
            <svg width="16" height="16"><use href="#icon-logout"></use></svg> <span>Выйти</span>
        </a>
    </div>
</header>

<main class="main-content">
    <!-- Левая колонка -->
    <div class="left-col">
        <!-- Плеер -->
        <div class="panel player-panel">
            <div class="player-info">
                <div class="cover-art">
                    <svg width="48" height="48"><use href="#icon-music"></use></svg>
                </div>
                <div class="track-details">
                    <h2 class="track-title" id="track-title"><?= $song ? esc($song['title']) : 'Выберите песню' ?></h2>
                    <div class="track-artist" id="track-artist"><?= $song ? esc($song['artist']) : 'Артист не выбран' ?></div>
                    <?php if ($song): ?>
                        <div class="track-tags">
                            <span class="tag">Караоке</span>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <div class="progress-container">
                <span class="time" id="time-current">0:00</span>
                <div class="progress-bar-wrapper" id="progress-wrapper">
                    <div class="progress-bar">
                        <div class="progress-fill" id="progress-fill">
                            <div class="progress-thumb"></div>
                        </div>
                    </div>
                </div>
                <span class="time" id="time-total">0:00</span>
            </div>

            <div class="controls-container">
                <div style="width: 140px;"> <!-- Placeholder for balance --> </div>

                <div class="main-controls">
                    <button class="control-btn"><svg width="20" height="20"><use href="#icon-shuffle"></use></svg></button>
                    <button class="control-btn"><svg width="24" height="24"><use href="#icon-skip-back"></use></svg></button>
                    <button class="play-btn" id="play-pause-btn">
                        <svg width="24" height="24" id="play-icon"><use href="#icon-play"></use></svg>
                    </button>
                    <button class="control-btn"><svg width="24" height="24"><use href="#icon-skip-forward"></use></svg></button>
                    <button class="control-btn"><svg width="20" height="20"><use href="#icon-repeat"></use></svg></button>
                </div>

                <div class="volume-control">
                    <svg width="18" height="18" style="color: var(--color-text-muted);"><use href="#icon-volume"></use></svg>
                    <input type="range" class="volume-slider" id="volume-slider" min="0" max="1" step="0.01" value="1">
                </div>
            </div>

            <!-- Скрытый нативный плеер -->
            <?php if ($song): ?>
                <audio id="karaoke-player" class="hidden" src="<?= esc($song['audio_path']) ?>"></audio>
            <?php endif; ?>
        </div>

        <!-- Караоке панель -->
        <div class="panel karaoke-panel">
            <div class="karaoke-header">
                <div class="karaoke-title">
                    <svg width="20" height="20" style="color: var(--color-primary)"><use href="#icon-mic"></use></svg>
                    Текст песни
                </div>
            </div>

            <div class="lyrics-container" id="lyrics-wrapper">
                <?php if ($song): ?>
                    <div id="lyrics"></div>
                <?php else: ?>
                    <div style="color: var(--color-text-muted); padding-top: 100px;">Выберите трек для отображения текста</div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Правая колонка -->
    <div class="right-col">
        <div class="panel playlist-panel">
            <div class="playlist-header">
                <div class="playlist-title">
                    Очередь
                </div>
            </div>

            <div class="song-list">
                <?php if (!empty($songs)): ?>
                    <?php foreach ($songs as $s): ?>
                        <a href="/?song_id=<?= $s['id'] ?>" class="song-item <?= ($song && $song['id'] == $s['id']) ? 'active' : '' ?>">
                            <div class="song-item-info">
                                <svg width="20" height="20" class="song-icon"><use href="#icon-music"></use></svg>
                                <div>
                                    <div class="song-name"><?= esc($s['title']) ?></div>
                                    <div class="song-artist"><?= esc($s['artist']) ?></div>
                                </div>
                            </div>
                        </a>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div style="color: var(--color-text-muted); text-align: center; margin-top: 20px;">Список пуст</div>
                <?php endif; ?>
            </div>

            <a href="/add" class="btn btn-add-song">
                <svg width="18" height="18"><use href="#icon-plus"></use></svg> Добавить песню
            </a>
        </div>
    </div>
</main>

<footer class="app-footer">
    <a href=" https://github.com/limoore21/karaoke" target="_blank" class="footer-link">
        <svg width="18" height="18"><use href="#icon-code"></use></svg> GitHub Repository
    </a>
    <a href="mailto:hell.drochila666@gmail.com" class="footer-link">
        <svg width="18" height="18"><use href="#icon-mail"></use></svg> hell.drochila666@gmail.com
    </a>
</footer>

<?php if ($song): ?>
<?php if ($song): ?>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const audio = document.getElementById('karaoke-player');
            const playPauseBtn = document.getElementById('play-pause-btn');
            const playIcon = document.getElementById('play-icon');
            const progressWrapper = document.getElementById('progress-wrapper');
            const progressFill = document.getElementById('progress-fill');
            const timeCurrent = document.getElementById('time-current');
            const timeTotal = document.getElementById('time-total');
            const volumeSlider = document.getElementById('volume-slider');
            const lyricsContainer = document.getElementById('lyrics');
            const lyricsWrapper = document.getElementById('lyrics-wrapper');

            let lyricsData = [];

            const formatTime = (s) => {
                if (isNaN(s)) return "0:00";
                const m = Math.floor(s / 60);
                const sec = Math.floor(s % 60);
                return `${m}:${sec < 10 ? '0' : ''}${sec}`;
            };

            audio.addEventListener('loadedmetadata', () => {
                timeTotal.textContent = formatTime(audio.duration);
            });

            playPauseBtn.addEventListener('click', () => {
                if (audio.paused) {
                    audio.play();
                    playIcon.innerHTML = '<use href="#icon-pause"></use>';
                } else {
                    audio.pause();
                    playIcon.innerHTML = '<use href="#icon-play"></use>';
                }
            });

            audio.addEventListener('timeupdate', () => {
                timeCurrent.textContent = formatTime(audio.currentTime);
                progressFill.style.width = `${(audio.currentTime / audio.duration) * 100}%`;

                if (!lyricsData.length) return;
                const t = audio.currentTime;
                for (let i = 0; i < lyricsData.length; i++) {
                    if (t >= lyricsData[i].time && (!lyricsData[i + 1] || t < lyricsData[i + 1].time)) {
                        const cur = document.querySelector('.lyric-line.active');
                        const next = document.getElementById('line-' + i);
                        if (cur !== next) {
                            if (cur) cur.classList.remove('active');
                            if (next) {
                                next.classList.add('active');
                                lyricsWrapper.scrollTo({
                                    top: next.offsetTop - lyricsWrapper.clientHeight / 2 + next.clientHeight / 2,
                                    behavior: 'smooth'
                                });
                            }
                        }
                        break;
                    }
                }
            });

            progressWrapper.addEventListener('click', (e) => {
                const rect = progressWrapper.getBoundingClientRect();
                audio.currentTime = ((e.clientX - rect.left) / rect.width) * audio.duration;
            });

            volumeSlider.addEventListener('input', (e) => {
                audio.volume = e.target.value;
            });

            function parseLrc(text) {
                const out = [];
                text.split('\n').forEach(line => {
                    const m = line.match(/\[(\d{2}):(\d{2}\.\d{2})\](.*)/);
                    if (m) {
                        const time = parseInt(m[1], 10) * 60 + parseFloat(m[2]);
                        const t = m[3].trim();
                        if (t) out.push({ time, text: t });
                    }
                });
                return out;
            }

            function renderLyrics(data) {
                lyricsContainer.innerHTML = '';
                data.forEach((line, i) => {
                    const p = document.createElement('div');
                    p.id = 'line-' + i;
                    p.className = 'lyric-line';
                    p.innerText = line.text;
                    lyricsContainer.appendChild(p);
                });
            }

            function showStub(msg) {
                lyricsContainer.innerHTML = `<div style="color: var(--color-text-muted); padding-top: 100px;">${msg}</div>`;
            }

            // оставил тут кусок чисто для проверки динамики текста на случай если бд отвалится или яндекс забанит
            // const hardcodedLyrics = {
            //     '20': `[00:15.23] Ты часто проходишь мимо, не видя меня
            // [00:21.45] С кем-то другим, я стою, не дыша
            // [00:29.57] Я знаю, что ты живёшь в соседнем дворе
            // [00:35.05] Ты идёшь, не спеша, не спеша`
            // };
            // if (hardcodedLyrics[currentSongId]) {
            //     lyricsData = parseLrc(hardcodedLyrics[currentSongId]);
            //     renderLyrics(lyricsData);
            // }

            const lyricsPath = "<?= esc($song['lyrics_path'] ?? '') ?>";
            const lyricsText = <?= json_encode($song['lyrics_text'] ?? '', JSON_UNESCAPED_UNICODE) ?>;

            if (lyricsPath && lyricsPath.trim() !== '') {
                fetch(lyricsPath)
                    .then(r => {
                        if (!r.ok) throw new Error('no lrc file');
                        return r.text();
                    })
                    .then(text => {
                        if (text.trim().startsWith('<')) throw new Error('html instead of lrc');
                        lyricsData = parseLrc(text);
                        if (lyricsData.length) renderLyrics(lyricsData);
                        else showStub('Для этой песни есть только обычный текст.');
                    })
                    .catch(() => {
                        if (lyricsText && lyricsText.trim() !== '') {
                            lyricsData = parseLrc(lyricsText);
                            if (lyricsData.length) renderLyrics(lyricsData);
                            else showStub('Текст есть, но он не в LRC-формате.');
                        } else {
                            showStub('Ошибка загрузки текста.');
                        }
                    });
            } else if (lyricsText && lyricsText.trim() !== '') {
                lyricsData = parseLrc(lyricsText);
                if (lyricsData.length) renderLyrics(lyricsData);
                else showStub('Для этой песни есть только обычный текст.');
            } else {
                showStub('Текст песни пока не добавлен.');
            }
        });

        if ('serviceWorker' in navigator) {
            window.addEventListener('load', () => {
                navigator.serviceWorker.register('/sw.js').catch(() => {});
            });
        }
    </script>
<?php endif; ?>

<script>
    if ('serviceWorker' in navigator) {
        window.addEventListener('load', () => {
            navigator.serviceWorker.register('/sw.js').catch(error => {
                console.log('Ошибка регистрации SW:', error);
            });
        });
    }
</script>
</body>
</html><?php endif; ?>