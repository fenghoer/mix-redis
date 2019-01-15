<?php

namespace Mix\Redis\Coroutine;

use Mix\Core\Coroutine;

/**
 * RedisCoroutine组件
 * @author LIUJIAN <coder.keda@gmail.com>
 */
class RedisConnection extends \Mix\Redis\Persistent\BaseRedisConnection
{

    /**
     * 连接池
     * @var \Mix\Pool\ConnectionPoolInterface
     */
    public $connectionPool;

    // 初始化事件
    public function onInitialize()
    {
        parent::onInitialize(); // TODO: Change the autogenerated stub
        // 开启协程
        Coroutine::enable();
    }

    // 析构事件
    public function onDestruct()
    {
        parent::onDestruct(); // TODO: Change the autogenerated stub
        // 释放连接
        if (isset($this->connectionPool)) {
            $this->connectionPool->release($this);
        }
    }

}
