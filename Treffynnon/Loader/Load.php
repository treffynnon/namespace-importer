<?php
namespace Treffynnon\Loader;

use \Treffynnon\Tokenizer\Traversing as T,
    \Treffynnon\Tokenizer\Parse as P,
    \Functional as F;

function load($calling_file) {
    F\each(T\get_use_tokens(read_calling_file($calling_file)), function($token) {
        $path = get_path_from_namespace($token);
        if(is_dir($path)) {
            require_directory($path);
        } else if(!empty($path)) {
            require_file($path . '.php');
        }
    });
}

function read_calling_file($calling_file) {
    $string = file_get_contents($calling_file, false, null, -1, 8000);
    return P\src(
        substr($string, 0,
            strpos($string, 'Treffynnon\Loader\Load(__FILE__);')
        )
    );
}

function require_directory($path) {
    F\each(glob($path . DIRECTORY_SEPARATOR . '*.php'), function($file) {
        require_file($file);
    });
}

function require_file($path) {
    if(is_file($path)) {
        require_once $path;
    } else {
        throw new \InvalidArgumentException('Incorrect file path supplied: ' . $path);
    }
}

function get_path_from_namespace($namespace) {
    return str_replace('\\', DIRECTORY_SEPARATOR, $namespace);
}
