<?php
$hostName = gethostname();
$serverIP = $_SERVER['SERVER_ADDR'];
$phpVersion = phpversion();
$date = date('d/m/y(D)H:i:s');
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>/dev/ - DevOps Test</title>
    <style>
        body { background-color: #FFFFEE; color: #000000; font-family: arial,helvetica,sans-serif; font-size: 10pt; margin: 4px; }
        a { color: #0000EE; text-decoration: none; }
        a:hover { color: #DD0000; }
        .boardBanner { text-align: center; clear: both; color: #800000; font-size: 28px; font-weight: bold; font-family: Tahoma,sans-serif; margin-top: 15px; margin-bottom: 15px; }
        .postBlock { background-color: #F0E0D6; border: 1px solid #D9BFB7; padding: 10px; display: table; margin-top: 5px; }
        .postInfo { color: #117743; font-weight: bold; font-size: 0.9em; margin-bottom: 10px; display: block; }
        .quote { color: #789922; }
        hr { border: none; border-top: 1px solid #D9BFB7; height: 0; clear: both; margin: 10px 0; }
        .fileThumb { float: left; margin: 2px 20px 10px 5px; max-width: 250px; border: none; }
        .fileText { font-size: 0.8em; margin-left: 5px; margin-bottom: 5px; display: block; }
        .postText { display: table-cell; vertical-align: top; }
    </style>
</head>
<body>
<div class="boardBanner">
    /dev/ - DevOps Infrastructure
</div>
<hr>

<div class="postBlock">
    <span class="postInfo">Anonymous <?= $date ?> No.1337</span>

    <div class="fileText">File: <a href="photo1.jpg" target="_blank">photo.jpg</a></div>
    <a href="photo1.jpg" target="_blank">
        <img src="photo1.jpg" class="fileThumb" alt="Pic">
    </a>

    <div class="postText">
        <span class="quote">>Контейнер запущен успешно</span><br>
        <span class="quote">>Hostname: <?= $hostName ?></span><br>
        <span class="quote">>IP-адрес Docker: <?= $serverIP ?></span><br>
        <span class="quote">>PHP Version: <?= $phpVersion ?></span><br><br>
        ОП, SFTP-деплой работает отлично.<br>
        Статика (картинки) отдается через Volume без рестарта контейнера.
    </div>
</div>

<hr>
</body>
</html>