<?php
    return [

        /**
         * 默认的阿里云数据库连接
         * ---------------------------------------------------------
         * 阿里云数据库依旧需要配置到config.database的配置文件中
         * 将阿里云数据库的键值配置到env文件中，默认读取config.database的配置文件
         */
        'default_connection' => env('ALIYUN_DEFAULT_CONNECTION', config('database.default')),
    ];