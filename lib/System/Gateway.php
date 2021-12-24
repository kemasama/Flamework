<?php

namespace System;

class Gateway
{
    public const ALLOW_TYPE = ["GET"];
    public static function Guard()
    {
        $type = strtoupper($_SERVER["REQUEST_METHOD"]);

        if (!in_array($type, self::ALLOW_TYPE))
        {
            return false;
        }

        return true;
    }

    public static function Check()
    {
        if (!self::Guard())
        {
            return false;
        }

        $path = dirname($_SERVER["DOCUMENT_ROOT"] . $_SERVER["SCRIPT_NAME"]) . '/gateway.php';
        return file_exists($path);
    }

    public static function Show()
    {
        $path = dirname($_SERVER["DOCUMENT_ROOT"] . $_SERVER["SCRIPT_NAME"]) . '/gateway.php';
        @include $path;
    }
}
