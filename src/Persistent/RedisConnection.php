<?php

namespace Mix\Redis\Persistent;

use Mix\Redis\Base\AbstractRedisConnection;

/**
 * Class RedisConnection
 * @package Mix\Redis\Persistent
 * @author liu,jian <coder.keda@gmail.com>
 */
class RedisConnection extends AbstractRedisConnection
{

    /**
     * 析构事件
     */
    public function onDestruct()
    {
        parent::onDestruct();
        // 关闭连接
        $this->disconnect();
    }

    /**
     * 重新连接
     * @throws \RedisException
     */
    protected function reconnect()
    {
        $this->disconnect();
        $this->connect();
    }

    /**
     * 执行命令
     * @param $name
     * @param $arguments
     * @return mixed
     * @throws \RedisException
     * @throws \Throwable
     */
    public function __call($name, $arguments)
    {
        try {
            // 执行父类命令
            return parent::__call($name, $arguments);
        } catch (\Throwable $e) {
            if (static::isDisconnectException($e)) {
                // 断开连接异常处理
                $this->reconnect();
                // 重新执行命令
                return $this->__call($name, $arguments);
            } else {
                // 抛出其他异常
                throw $e;
            }
        }
    }

    /**
     * 判断是否为断开连接异常
     * @param \Throwable $e
     * @return bool
     */
    protected static function isDisconnectException(\Throwable $e)
    {
        $disconnectMessages = [
            'failed with errno',
            'connection lost',
        ];
        $errorMessage       = $e->getMessage();
        foreach ($disconnectMessages as $message) {
            if (false !== stripos($errorMessage, $message)) {
                return true;
            }
        }
        return false;
    }

}
