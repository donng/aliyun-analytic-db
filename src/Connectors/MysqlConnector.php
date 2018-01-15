<?php
/**
 * Created by PhpStorm.
 * User: donng
 * Date: 2018/1/12
 * Time: 下午3:36
 */

namespace Donng\AliyunDB\Connectors;

use Illuminate\Database\Connectors\Connector;

class MysqlConnector extends Connector
{
    public function connect($config)
    {
        $dsn = $this->getHostDsn($config);

        $connection = $this->createConnection($dsn, $config);

        if (! empty($config['database'])) {
            $connection->exec("use `{$config['database']}`;");
        }

        $this->configureEncoding($connection, $config);

        $this->configureTimezone($connection, $config);

        return $connection;
    }

    /**
     * 获得主机和数据库配置
     * @param array $config
     * @return string
     */
    protected function getHostDsn(array $config)
    {
        extract($config, EXTR_SKIP);

        return isset($port)
            ? "mysql:host={$host};port={$port};dbname={$database}"
            : "mysql:host={$host};dbname={$database}";
    }

    protected function configureEncoding($connection, array $config)
    {
        if (! isset($config['charset'])) {
            return $connection;
        }

        $connection->prepare(
            "set names '{$config['charset']}'".$this->getCollation($config)
        )->execute();
    }

    protected function configureTimezone($connection, array $config)
    {
        if (isset($config['timezone'])) {
            $connection->prepare('set time_zone="'.$config['timezone'].'"')->execute();
        }
    }
}