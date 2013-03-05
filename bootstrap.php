<?php

$base = 'Treffynnon';
$modules = array('Tokenizer', 'Loader');
array_walk(
    $modules,
    function($module) use ($base) {
        require_once $base . DIRECTORY_SEPARATOR . $module .
                     DIRECTORY_SEPARATOR . '_import.php';
    }
);

require 'vendor/autoload.php';
