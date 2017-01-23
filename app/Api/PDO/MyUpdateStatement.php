<?php

namespace App\Api\PDO;

use Slim\PDO\Statement\UpdateStatement;

class MyUpdateStatement extends UpdateStatement
{
    public function whereEqual($column, $value)
    {
        return parent::where($column, "=", $value);
    }
}
