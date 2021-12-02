<?php 

// ***************
//   ClassLoader
// ***************

class ClassLoader {
    private static $dirs;

    public static function loadClass($class) {
        $classPath = ltrim($class, '\\');
        $classPath = str_replace('\\', DIRECTORY_SEPARATOR, $classPath);
        foreach (self::directories() as $directory) {
            $file_name = $directory . DIRECTORY_SEPARATOR . $classPath . ".php";

            if (is_file($file_name) && is_readable($file_name)) {
                require_once $file_name;

                return true;
            }
        }

        return false;
    }

    public static function regLibrary($dir) {
        self::$dirs[] = $dir;
    }
    public static function regLibraries($dirs) {
        self::$dirs[] = $dirs;
    }

    private static function directories() {
        if (empty(self::$dirs)) {
            $base = __DIR__;
            self::$dirs = array(
                $base . "/modules",
                $base . "/classes",
                $base . "/library",
            );

            if (defined("CLASS_DIR")) {
                self::$dirs[] = CLASS_DIR;
            }
        }

        return self::$dirs;
    }
}

