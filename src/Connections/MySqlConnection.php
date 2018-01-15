<?php
/**
 * Created by PhpStorm.
 * User: donng
 * Date: 2018/1/12
 * Time: 下午3:14
 */

namespace Donng\AliyunDB\Connections;

use Donng\AliyunDB\Connections\Connection;

class MySqlConnection extends Connection
{
    protected $config;

    public function __construct($config)
    {
        $this->config = $config;

        $pdo = new \PDO("mysql:host={$config['host']};port={$config['port']};dbname={$config['database']}",
            $config['username'], $config['password']);

        $this->pdo = $pdo;
    }


}