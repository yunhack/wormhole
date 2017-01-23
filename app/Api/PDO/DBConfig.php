<?php

namespace App\Api\PDO;

class DBConfig
{
    private static $config = [];

    public static function getConfig($connect_name)
    {
        if (! isset(self::$config[$connect_name])) {
            self::setConfig($connect_name);
        }

        return self::$config[$connect_name];
    }

    private static function setConfig($connect_name)
    {
        $conf_arr = config("database.connections.{$connect_name}");
        if (! is_array($conf_arr)) {
            throw new \Exception("服务器配置错误：数据库连接'{$connect_name}'必须是数组");
        }

        $keys = ['driver', 'host', 'database', 'charset', 'username', 'password'];
        foreach ($keys as $key) {
            if (! isset($conf_arr[$key]) || ! is_string($conf_arr[$key])) {
                throw new \Exception("服务器配置错误：数据库连接'{$connect_name}'的每一项配置必须是字符串");
            }
        }

        self::$config[$connect_name] = $conf_arr;
    }

}
