<?php

// path if you use it in src dir (of course usually wrong)
if (file_exists($file = __DIR__.'/../../../../vendor/autoload.php')) {
   $autoload = require_once $file;
} else {
   throw new RuntimeException('Autoload was not found. You must certainly change the path in the test autoload file.');
}

spl_autoload_register(function($class) {
    if (0 === strpos($class, 'Soloist\\Bundle\\CoreBundle\\')) {
        $path = __DIR__.'/../'.implode('/', array_slice(explode('\\', $class), 3)).'.php';
        if (!stream_resolve_include_path($path)) {
            return false;
        }
        require_once $path;
        return true;
    }
});
