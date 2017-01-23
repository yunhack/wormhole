<?php

namespace App\Utils;

use Logger;

class LogUtil
{
    private static $logger = null;

    private static $lvl = [
        'TRACE' => 0, 'DEBUG' => 1, 'INFO' => 2,
        'WARN' => 3, 'ERROR' => 4, 'FATAL' => 5
    ];

    public static function trace($msg, $content = "")
    {
        self::log('TRACE', $msg, $content);
    }

    public static function debug($msg, $content = "")
    {
        self::log('DEBUG', $msg, $content);
    }

    public static function info($msg, $content = "")
    {
        self::log('INFO', $msg, $content);
    }

    public static function warn($msg, $content = "")
    {
        self::log('WARN', $msg, $content);
    }

    public static function error($msg, $content = "")
    {
        self::log('ERROR', $msg, $content);
    }

    public static function fatal($msg, $content = "")
    {
        self::log('FATAL', $msg, $content);
    }

    private static function log($log_lvl, $msg, $content)
    {
        $logger = self::getLogger();
        $log_msg = $msg;
        if (is_string($content) || is_numeric($content)) {
            $log_msg .= $content;
        } elseif (is_array($content) || is_object($content)) {
            $log_msg .= json_encode($content);
        } elseif (is_bool($content)) {
            $log_msg .= $content ? "true" : "false";
        } elseif (is_null($content)) {
            $log_msg .= "NULL";
        } else {
            ob_start();
            var_dump($content);
            $log_msg .= ob_get_contents();
            ob_end_clean();
        }

        $d = date('Y-m-d H:i:s');
        $log_msg = "[{$d}] " . $log_msg . "\r\n";

        switch (self::$lvl[$log_lvl]) {
            case 0 : $logger->trace($log_msg); break;
            case 1 : $logger->debug($log_msg); break;
            case 2 : $logger->info($log_msg); break;
            case 3 : $logger->warn($log_msg); break;
            case 4 : $logger->error($log_msg); break;
            case 5 : $logger->fatal($log_msg); break;
            default :
                break;
        }
    }

    private static function getLogger()
    {
        if (self::$logger !== null) {
            return self::$logger;
        }

        Logger::configure(ROOT_PATH . "config/log4php.xml");
        self::$logger = Logger::getLogger(__CLASS__);

        return self::$logger;
    }
}
