<?php

namespace System;

/**
 * ErrorHandle class
 * 
 * ErrorHandle
 */
class ErrorHandle
{
    public static function showException()
    {
        self::Header();
    }
    public static function showGateway()
    {
        self::Header();
        
        echo json_encode([
            "error" => true,
            "message" => "Gateway Error",
        ]);
    }

    public static function showNoResponse()
    {
        self::Header();
        
        echo json_encode([
            "error" => true,
            "message" => "No response",
        ]);
    }
    public static function showNull()
    {
        self::Header();

        echo json_encode([
            "error" => true,
            "message" => "No response",
        ]);
    }
    public static function Header()
    {
        if (!headers_sent())
        {
            header("Content-Type: application/json; charset=utf-8");
        }
    }

}

