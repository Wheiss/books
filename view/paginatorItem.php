<?php
foreach ($paginator->getPages() as $page) {
    $key = key($page);
    switch ($key) {
        case 'link':
            echo "<a href='" . $page[$key] . $sort .  "'>" . $page['text'] . "</a>";
            break;
        case 'previous':
            echo "<a href='" . $page[$key] . $sort . "'>" . "Предыдущая" . "</a>";
            break;
        case 'next':
            echo "<a href='" . $page[$key] . $sort . "'>" . "Следующая" . "</a>";
            break;
        case 'blank':
            echo $page[$key];
            break;
        case 'current':
            echo "[" . $page[$key] . "]";
            break;
    }
}?>