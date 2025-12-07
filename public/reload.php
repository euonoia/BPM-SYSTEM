<?php
header('Content-Type: text/event-stream');
header('Cache-Control: no-cache');
set_time_limit(0);

$watchFolder = '/var/www/src'; // path inside Docker container

function getTimestamps($dir) {
    $timestamps = [];
    $files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($dir));
    foreach ($files as $file) {
        if ($file->isFile()) {
            $timestamps[$file->getRealPath()] = $file->getMTime();
        }
    }
    return $timestamps;
}

$lastModified = getTimestamps($watchFolder);

while (true) {
    clearstatcache();
    $currentModified = getTimestamps($watchFolder);
    $reload = false;

    foreach ($currentModified as $file => $mtime) {
        if (!isset($lastModified[$file]) || $mtime > $lastModified[$file]) {
            $reload = true;
            break;
        }
    }

    if ($reload) {
        echo "data: reload\n\n";
        ob_flush();
        flush();
        $lastModified = $currentModified;
    }

    usleep(500000); // 0.5s interval
}
