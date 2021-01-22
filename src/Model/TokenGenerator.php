<?php

namespace App\Model;

trait TokenGenerator
{
    public static function generateRandomString($base)
    {
        $string = crc32(microtime()) . crc32(rand(100, 999));

        return sha1(crc32($base . $string));
    }
}