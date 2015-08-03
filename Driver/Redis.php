<?php
/**
 * redis驱动类
 * @author enychen
 */
namespace Driver;

class Redis extends Driver
{
    /**
     * 当前的redis对象
     * @var \Redis
     */
    private $redis;
    
    /**
     * 
     * @param array $driver
     * @throws \RedisException
     */
    protected function __construct($driver)
    {
        // 创建redis对象
        $this->redis = new \Redis();
        // 连接redis
        if($this->redis->connect($driver['host'], $driver['port'], $driver['timeout']))
        {
            // 是否需要验证密码
            $driver['auth'] and $this->redis->auth($driver['auth']);
            // 是否需要选择数据库
            $driver['db'] and $this->redis->select($driver['db']);
        }
        else
        {
            // 连接失败抛出错误
            throw new \RedisException("Redis Connection Error: {$driver['ip']}:{$driver['port']}");
        }
    }

    /**
     * 静态调用方式
     * @param string 方法名
     * @param array 参数
     */
    public function __call($method, $args)
    {
        // 执行回调函数
        return call_user_func_array(array($this->redis, $method), $args);
    }
}