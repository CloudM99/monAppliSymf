<?php

use Doctum\Doctum;
use Symfony\Component\Finder\Finder;

$iterator = Finder::create()
    ->files()
    ->name('*.php')
    ->in(__DIR__.'/src');

return new Doctum($iterator, [
    'title'     => 'MonAppliSymf - Documentation',
    'build_dir' => __DIR__.'/docs/build',
    'cache_dir' => __DIR__.'/docs/cache',
]);