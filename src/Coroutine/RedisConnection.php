<?php

namespace Mix\Redis\Coroutine;

use Mix\Core\Coroutine\Coroutine;

/**
 * RedisCoroutine组件
 * @author LIUJIAN <coder.keda@gmail.com>
 */
class RedisConnection extends \Mix\Redis\Persistent\BaseRedisConnection
{

    /**
     * 初始化事件
     */
    public function onInitialize()
    {
        parent::onInitialize(); // TODO: Change the autogenerated stub
        // 开启协程
        Coroutine::enable();
    }

}
