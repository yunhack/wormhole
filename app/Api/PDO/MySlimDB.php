<?php

namespace App\Api\PDO;

use Slim\PDO\Database;

class MySlimDB extends Database
{
    public function select($raw = "")
    {
        if (is_array($raw)) {
            return new MySelectStatement($this, $raw);
        }

        if (! is_string($raw)) {
            throw new \InvalidArgumentException("Argument 1 passed to " . __CLASS__ ."::" . __FUNCTION__ . " must be of the type string");
        }

        if ($raw == "") {
            $columns = ["*"];
        } else {
            $columns = [];
            $arr = explode(',', $raw);
            $columns = $arr;
        }

        return new MySelectStatement($this, $columns);
    }

    public function insert(array $columnsOrPairs = [])
    {
        return new MyInsertStatement($this, $columnsOrPairs);
    }

    public function update(array $pairs = [])
    {
        return new MyUpdateStatement($this, $pairs);
    }

    public function delete($table = null)
    {
        return new MyDeleteStatement($this, $table);
    }
}
