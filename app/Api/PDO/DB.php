<?php

namespace App\Api\PDO;

class DB
{
    private static $pdo;

    private static $fetch = null;

    /**
     * 获取一个PDO对象
     *
     * @param   string  $connect_name
     * @return  \App\Api\PDO\MySlimDB;
     */
    public static function getConnection($connect_name = 'default')
    {
        if (self::$fetch === null) {
            self::$fetch = intval(config("database.fetch"));
        }

        if (isset(self::$pdo[$connect_name])) {
            return self::$pdo[$connect_name];
        }

        $conf = DBConfig::getConfig($connect_name);
        $dsn = "{$conf['driver']}:host={$conf['host']};dbname={$conf['database']};charset={$conf['charset']}";
        $usr = $conf['username'];
        $pwd = $conf['password'];

        self::$pdo[$connect_name] = new MySlimDB($dsn, $usr, $pwd);

        return self::$pdo[$connect_name];
    }

    public static function getFetch()
    {
        return self::$fetch;
    }
}
