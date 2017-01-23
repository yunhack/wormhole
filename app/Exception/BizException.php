<?php

namespace App\Exception;

use App\Utils\LogUtil;

class BizException extends \Exception
{
    const BizTip = "服务异常！请查看日志";

    const Error = 1;

    public function __construct($msg = self::BizTip, $code = self::Error)
    {
        parent::__construct($msg, $code);
    }

    public function log()
    {
        LogUtil::error($this->getMessage() . "【{$this->getFile()}:{$this->getLine()}】");
    }
}
