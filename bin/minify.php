<?php

require_once __DIR__ . '/../vendor/autoload.php';

if (isset($argv[1]) !== true) {
    $argv[1] = null;
}

if (isset($argv[2]) !== true) {
    $argv[2] = null;
}

(new \Kiryi\Minifyi\Minifier($argv[1], $argv[2]))->minify();
