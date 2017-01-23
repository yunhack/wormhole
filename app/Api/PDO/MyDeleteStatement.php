<?php

namespace App\Api\PDO;

use Slim\PDO\Statement\DeleteStatement;

class MyDeleteStatement extends DeleteStatement
{
    public function whereEqual($column, $value)
    {
        return parent::where($column, "=", $value);
    }

    public function table($from)
    {
        return parent::from($from);
    }
}
