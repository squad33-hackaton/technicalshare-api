<?php

define('ROOT', dirname(__DIR__ . "/technicalshare-api"));
define('SLASH', DIRECTORY_SEPARATOR);

spl_autoload_register(
    function (string $className) {
        $fileName = sprintf("%s%s%s%s.php", ROOT, SLASH, SLASH, str_replace("\\", "/", $className));

        if (file_exists($fileName)) {
            require ($fileName);
        } else {
            echo "file not found {$fileName}";
        }
    }
);