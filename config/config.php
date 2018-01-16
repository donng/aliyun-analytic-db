<?php
    return [

        /**
         * 是否开启sql记录功能
         * --------------------------------------------------------
         * 开启日志记录功能需要执行数据库迁移console: php artisan migrate
         * 如果是分库，需要执行配置sql记录的数据库连接
         */
        'record' => true,

        /**
         * 默认的阿里云数据库连接
         * ---------------------------------------------------------
         * 阿里云数据库依旧需要配置到config.database的配置文件中
         * 将阿里云数据库的键值配置到env文件中，默认读取config.database的配置文件
         */
        'default_connection' => env('ANALYTIC_CONNECTION', config('database.default')),

        /**
         * 记录执行sql的数据库连接
         * ----------------------------------------------------------
         */
        'record_connection' => env('RECORD_CONNECTION', config('database.default')),
    ];