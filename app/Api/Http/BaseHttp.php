<?php

namespace App\Api\Http;

use App\Utils\LogUtil;
use GuzzleHttp\Client;
use GuzzleHttp\Cookie\CookieJar;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Exception\TransferException;
use GuzzleHttp\RequestOptions;

class BaseHttp
{
    public $base_url = "";

    public $header = null;

    public $cookie = null;

    public $timeout = 0;

    public $connect_timeout = 0;

    public $verify = true;

    public function __construct($base_url, $header = null, $cookie = null)
    {
        $this->base_url = $base_url;
        $this->setHeader($header);
        $this->setCookie($cookie);
    }

    public function setHeader($header)
    {
        if ($header !== null && ! is_array($header)) {
            throw new \InvalidArgumentException("BaseHttp构造函数，传入的header不合法");
        }
        $this->header = $header;
    }

    public function setCookie($cookie)
    {
        if ($cookie !== null && ! $cookie instanceof CookieJar) {
            throw new \InvalidArgumentException("BaseHttp构造函数，传入的cookie不合法");
        }
        $this->cookie = $cookie;
    }

    public function setTimeout($timeout)
    {
        $this->timeout = intval($timeout);
    }

    public function setConnectTimeout($connect_timeout)
    {
        $this->connect_timeout = intval($connect_timeout);
    }

    public function setVerify($verify)
    {
        $this->verify = $verify;
    }

    public function get($path, array $input)
    {
        return $this->run("GET", $path, array_merge($this->getCommonOption(), [
            RequestOptions::QUERY => $input,
        ]));
    }

    public function post($path, array $input)
    {
        return $this->run("POST", $path, array_merge($this->getCommonOption(), [
            RequestOptions::FORM_PARAMS => $input,
        ]));
    }

    public function postBody($path, $input)
    {
        return $this->run("POST", $path, array_merge($this->getCommonOption(), [
            RequestOptions::BODY => $input,
        ]));
    }

    private function getCommonOption()
    {
        return [
            'headers' => $this->header,
            'cookies' => $this->cookie,
            'timeout' => $this->timeout,
            'connect_timeout' => $this->connect_timeout,
            'verify' => $this->verify
        ];
    }

    /**
     * 统一处理'GuzzleHttp'请求
     *   如果有错误，则记录日志
     *   如果请求失败或数据传输异常，返回null
     *   如果响应失败，返回Http状态码
     *
     * @param   $method
     * @param   $path
     * @param   array $option
     * @return  int|null|\Psr\Http\Message\ResponseInterface
     */
    private function run($method, $path, array $option)
    {
        $logPrefix = "GuzzleHttp'{$method}'请求失败，base_url:【{$this->base_url}】 path:【{$path}】";
        try {
            $client = new Client(['base_uri' => $this->base_url]);
            return $client->request($method, $path, $option);
        } catch (ClientException $e) {
            LogUtil::error("{$logPrefix}，异常信息：{$e->getMessage()}", [
                'Request-Object' => $e->getRequest(),
                'Response-Object' => $e->getResponse()
            ]);
            return $e->getResponse()->getStatusCode();
        } catch (RequestException $e) {
            $log_msg = "{$logPrefix}，异常信息：{$e->getMessage()}";
            $log_data = [
                'Request-Object' => $e->getRequest(),
            ];
            if ($e->hasResponse()) {
                $log_data['Response-Object'] = $e->getResponse();
                return $e->getResponse()->getStatusCode();
            }
            LogUtil::error($log_msg, $log_data);
        } catch (TransferException $e) {
            LogUtil::error("{$logPrefix}，异常信息：{$e->getMessage()}");
        }

        return null;
    }


}