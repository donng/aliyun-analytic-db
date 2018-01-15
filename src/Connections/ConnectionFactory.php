<?php
/**
 * Created by PhpStorm.
 * User: donng
 * Date: 2018/1/11
 * Time: 下午6:02
 */

namespace Donng\AliyunDB\Connections;

use Illuminate\Support\Arr;
use InvalidArgumentException;
use Illuminate\Database\Connectors\Connector;

use Donng\AliyunDB\Connectors;
use Donng\AliyunDB\Connections;

class ConnectionFactory
{
    /**
     * 按照配置文件建立PDO连接
     * @param array $config
     * @param $name
     * @return mixed
     */
    public function make(array $config, $name = null)
    {
        $config = $this->parseConfig($config, $name);

        return $this->createSingleConnection($config);
    }

    /**
     * 解析配置信息
     * @param array $config
     * @param $name
     * @return mixed
     */
    public function parseConfig(array $config, $name)
    {
        return Arr::add(Arr::add($config, 'prefix', ''), 'name', $name);
    }


    protected function createSingleConnection(array $config)
    {

        return new MySqlConnection($config);
    }

    /**
     * 创建单例的数据库连接实例
     * @param array $config
     * @return MySqlConnection
     */
//    protected function createSingleConnection(array $config)
//    {
//        $pdo = $this->createPdoResolver($config);
//
//        return $this->createConnection(
//            $config['driver'], $pdo, $config['database'], $config['prefix'], $config
//        );
//    }

    /**
     * @param array $config
     * @return mixed
     */
    protected function createPdoResolver(array $config)
    {
        return array_key_exists('host', $config)
            ? $this->createPdoResolverWithHosts($config)
            : $this->createPdoResolverWithoutHosts($config);
    }

    protected function createPdoResolverWithHosts($config)
    {
        return function () use ($config) {
            foreach (Arr::shuffle($hosts = $this->parseHosts($config)) as $key => $host) {
                $config['host'] = $host;

                try {
                    return $this->createConnector($config)->connect($config);
                } catch (PDOException $e) {
                    if (count($hosts) - 1 === $key && $this->container->bound(ExceptionHandler::class)) {
                        $this->container->make(ExceptionHandler::class)->report($e);
                    }
                }
            }

            throw $e;
        };
    }

    /**
     * 将主机的配置项放入数组中
     * @param array $config
     * @return mixed
     */
    protected function parseHosts(array $config)
    {
        $hosts = Arr::wrap($config['host']);

        if (empty($hosts)) {
            throw new InvalidArgumentException('Database hosts array is empty.');
        }

        return $hosts;
    }

    /**
     * 创建一个解析无配置主机的pdo实例的闭包
     * @param $config
     * @return \Closure
     */
    protected function createPdoResolverWithoutHosts($config)
    {
        return function () use ($config) {
            return $this->createConnector($config)->connect($config);
        };
    }

    public function createConnector(array $config)
    {
        if (! isset($config['driver'])) {
            throw new InvalidArgumentException('A driver must be specified.');
        }

//        if ($this->container->bound($key = "db.connector.{$config['driver']}")) {
//            return $this->container->make($key);
//        }

        switch ($config['driver']) {
            case 'mysql':
                return new MySqlConnector;
            case 'pgsql':
                return new PostgresConnector;
            case 'sqlite':
                return new SQLiteConnector;
            case 'sqlsrv':
                return new SqlServerConnector;
        }

        throw new InvalidArgumentException("Unsupported driver [{$config['driver']}]");
    }

    protected function createConnection($driver, $connection, $database, $prefix = '', array $config = [])
    {
        switch ($driver) {
            case 'mysql':
                return new MySqlConnection($connection, $database, $prefix, $config);
        }

        throw new InvalidArgumentException("Unsupported driver [$driver]");
    }
}