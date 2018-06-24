<?php
exec('make init');
define('DS', '/');
$pieces = scandir('.');
$pieces = array_diff($pieces, array('.', '..', '.idea', 'Makefile', 'README.txt', 'pack.php'));
foreach ($pieces as $_key => $_piece) {
    if (!preg_match("/^2016/i", $_piece) || !preg_match("/^[0-9]{4}/i", $_piece)) {
        unset($pieces[$_key]);
    }
}
try {
    $a = new PharData('archive.tar');

    foreach ($pieces as $_piece) {
        if (is_dir($_piece)) {
            $a->addEmptyDir($_piece);
        }
    }

    $a->compress(Phar::GZ);
    unlink('archive.tar');
    exec('make rm');
} catch (Exception $e) {
    echo "Exception : " . $e;
}
