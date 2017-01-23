<?php

namespace App\Api\PDO;

use Slim\PDO\Statement\SelectStatement;

class MySelectStatement extends SelectStatement
{
    public function whereEqual($column, $value)
    {
        return parent::where($column, "=", $value);
    }

    public function table($from)
    {
        return parent::from($from);
    }

    public function limit($number, $offset = 0)
    {
        return parent::limit($number, $offset);
    }

    public function get()
    {
        return parent::execute()->fetchAll(DB::getFetch());
    }

    public function first()
    {
        return parent::execute()->fetch(DB::getFetch());
    }
}
