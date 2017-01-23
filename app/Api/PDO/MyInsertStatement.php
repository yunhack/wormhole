<?php

namespace App\Api\PDO;

use Slim\PDO\Statement\InsertStatement;

class MyInsertStatement extends InsertStatement
{
    public function whereEqual($column, $value)
    {
        return parent::where($column, "=", $value);
    }

    public function table($from)
    {
        return parent::into($from);
    }
}
