<?php
echo '1. Написать аналог «Проводника» в Windows для директорий на сервере при помощи итераторов.<br/>';

echo '<a href="..">..</a><br/>';

$request = $_REQUEST['link'] ?: './';
$dir = new DirectoryIterator($request);

foreach ($dir as $item) {
    if ($item->isDot()) {
        continue;
    }
    if ($item->isDir()) {
        echo '<a href=".?link=' . $item->getFilename() . '">' . $item->getFilename() . '</a><br/>';
    } else {
        echo $item->getFilename() . '<br/>';
    }
}


echo '<hr/>2. Попробовать определить, на каком объеме данных применение итераторов становится выгоднее, чем использование чистого foreach.<br/>';

$arr = [];
for ($i = 0; $i < 1000000; $i++) {
    $arr[$i] = $i;
}

$time = microtime(true);
foreach ($arr as $item) {
    $a = $item;
}
echo 'foreach: ' . round(microtime(true) - $time, 3) . '<br/>';

$time = microtime(true);
$obj = new ArrayObject($arr);
$it = $obj->getIterator();
while ($it->valid()) {
    $a = $it->current();
    $it->next();
}

echo 'spl: ' . round(microtime(true) - $time, 5);

// У меня foreach оказался быстрее на всех объемах данных)