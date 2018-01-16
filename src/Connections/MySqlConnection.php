<?php
/**
 * Created by PhpStorm.
 * User: donng
 * Date: 2018/1/12
 * Time: 下午3:14
 */

namespace Donng\AnalyticDB\Connections;

use Illuminate\Support\Facades\DB;
use Donng\AnalyticDB\Connections\Connection;

class MySqlConnection extends Connection
{
    /**
     * sql查询的配置信息
     * @var
     */
    protected $config;

    /**
     * 记录sql的配置信息
     * @var
     */
    protected $record;

    /**
     * 当前执行的sql
     * @var
     */
    protected $sql;

    public function __construct($config, $record)
    {
        $this->config = $config;
        $this->record = $record;

        $this->init();
    }

    /**
     * 初始化pdo连接
     */
    protected function init()
    {
        extract($this->config);

        $this->pdo = new \PDO("mysql:host={$host};port={$port};dbname={$database}", $username, $password);
    }

    /**
     * 保存执行的sql
     * @param $sql
     * @return $this
     */
    public function select($sql)
    {
        $this->sql = $sql;

        return $this;
    }


    public function disableRecord()
    {
        $this->record = false;

        return $this;
    }

    public function get()
    {
        return $this->fetchData('fetchAll');
    }

    public function first()
    {
        return $this->fetchData('fetch');
    }

    /**
     * 执行查询和日志记录
     * @param $method
     * @return mixed
     */
    protected function fetchData($method)
    {
        $startTime = time();

        $query = $this->getQuery($this->sql);

        $result = call_user_func_array([$query, $method], [\PDO::FETCH_ASSOC]);

        $time = time() - $startTime;

        if ($result && true == $this->record['record']) {
            $this->record($time);
        }

        return $result;
    }


    /**
     * @param $sql
     * @return mixed
     */
    public function getQuery($sql)
    {
        return $this->pdo->query($sql);
    }

    /**
     * 记录当前sql和执行时间
     * @param $time
     */
    protected function record($time)
    {
        DB::connection($this->record['record_connection'])->insert('insert into sql_records (`sql`, `time`) values (?, ?)', [$this->sql, $time]);
    }
}