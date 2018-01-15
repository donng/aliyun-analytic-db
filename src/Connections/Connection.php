<?php
/**
 * Created by PhpStorm.
 * User: donng
 * Date: 2018/1/12
 * Time: 上午10:48
 */

namespace Donng\AliyunDB\Connections;


class Connection
{
    /**
     * pdo实例
     * @var
     */
    protected $pdo;

    protected $sql;

    protected $logByFile = false;

    protected $logByTable = true;

    protected $beginTime;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
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

    public function get()
    {
        $this->beginTime = time();
        $query = $this->getQuery();

        $this->logBegin();

        $result = $query->fetchAll(\PDO::FETCH_ASSOC);
        $time = time() - $this->beginTime;

        $this->logEnd();

        return $result;
    }

    public function first()
    {
        $this->beginTime = time();
        $query = $this->getQuery();



        $result = $query->fetch(\PDO::FETCH_ASSOC);

        $time = time() - $this->beginTime;

        var_dump($time);die;

        return $result;
    }

    public function getQuery()
    {
        return $this->pdo->query($this->sql);
    }

    protected function logBegin()
    {

    }

    protected function logEnd()
    {

    }


    public function logByFile()
    {
        $this->logByFile = true;
    }

    public function logByTable()
    {
        $this->logByTable = true;
    }
}