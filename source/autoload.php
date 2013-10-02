<?php

spl_autoload_register(function ($name) {
    if (preg_match('/^ptf\b/', $name)) {
        $file = __DIR__.str_replace('\\', '/', $name).'.php';
        require $file;
    }
    
});

require __DIR__.'/vendor/autoload.php';
