<?php

namespace tasks\extensions\service;

class Rest {
    
    public static $codes = [
        200 => 'OK',
        302 => 'Found',
        304 => 'Not modified',
        400 => 'Bad request',
        401 => 'Bad credentials',
        403 => 'Access denied',
        404 => 'Not found',
        422 => 'Unprocessable entity'
    ];
    
    public static function status($code = 200) {
        return self::$codes[$code];
    }
}

?>