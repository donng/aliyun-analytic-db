<?php
/**
 * Created by PhpStorm.
 * User: donng
 * Date: 2018/1/12
 * Time: 上午10:48
 */

namespace Donng\AnalyticDB\Connections;

abstract class Connection
{
    /**
     * 获得查询的所有结果
     * @return mixed
     */
    abstract function get();

    /**
     * 获得查询的第一条结果
     * @return mixed
     */
    abstract function first();
}