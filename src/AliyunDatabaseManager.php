<?php
/**
 * Created by PhpStorm.
 * User: donng
 * Date: 2018/1/11
 * Time: 下午4:53
 */

namespace Donng\AliyunDB;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use InvalidArgumentException;

class AliyunDatabaseManager
{
    /**服务容器
     * @var
     */
    protected $app;

    /**
     * 数据里连接的工厂实例
     * @var ConnectionFactory
     */
    protected $factory;

    /**
     * 激活的连接实例数组
     * @var array
     */
    protected $connections = [];

    public function __construct($app, $factory)
    {
        $this->app = $app;
        $this->factory = $factory;
    }

    /**
     * 获得数据库连接的实例
     * @param string $name
     * @return mixed
     */
    public function connection($name = '')
    {
        $connection = $this->getDefaultConnection();

        $name = $name ?: $connection;

        if (!isset($this->connections[$name])) {
            $this->connections[$name] = $this->makeConnection($connection);
        }

        return $this->connections[$name];
    }

    /**
     * 制造一个数据库连接
     * @param $name
     * @return \Illuminate\Database\Connection
     */
    public function makeConnection($name)
    {
        // 依据连接名获得连接信息
        $config = $this->configuration($name);
        // 连接工厂生成连接实例
        return $this->factory->make($config, $name);
    }

    /**
     * 获得数据库的配置信息
     * @param null $name
     * @return mixed
     */
    public function configuration($name = null)
    {
        $name = $name ?: $this->getDefaultConnection();

        $connections = $this->app['config']['database.connections'];

        if (is_null($config = Arr::get($connections, $name))) {
            throw new InvalidArgumentException("Database [$name] not configured.");
        }

        return $config;
    }


    /**
     * 获得默认的数据库连接名
     * @return mixed
     */
    public function getDefaultConnection()
    {
        $defaultConnection = $this->app['config']['aliyun_db.default_connection'];

        if (is_null($defaultConnection)) {
            throw new InvalidArgumentException("default_connection is not found!");
        }

        return $defaultConnection;
    }

    /**
     *
     * @param $method
     * @param $parameters
     * @return mixed
     */
    public function __call($method, $parameters)
    {
        return $this->connection()->$method(...$parameters);
    }

    public static function __callStatic($method, $parameters)
    {
        return (new static)->$method(...$parameters);
    }

}