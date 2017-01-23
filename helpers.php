<?php

function config($key)
{
    if (! is_string($key)) {
        return null;
    }

    if (! isset($CONFIG)) {
        global $CONFIG;
        $files = scandir(ROOT_PATH . "config");

        $CONFIG = [];
        foreach ($files as $i => $v) {
            if (in_array($v, ['.', '..'])) {
                unset($files[$i]);
                continue;
            }
            $ni = rtrim($v, '.php');
            if ($ni != $v) {
                $data = require ROOT_PATH . "config/" . $v;
                if (is_array($data)) {
                    $CONFIG[$ni] = $data;
                }
            }
        }
    }

    $key_dot = explode('.', $key);
    $v = $CONFIG;
    foreach ($key_dot as $k) {
        if (! isset($v[$k])) {
            return null;
        }
        $v = $v[$k];
    }

    return $v;
}

function dd()
{
    echo "<pre>";

    for ($i = 0; $i < func_num_args(); $i++) {
        var_dump(func_get_arg($i));
    }

    exit;
}
