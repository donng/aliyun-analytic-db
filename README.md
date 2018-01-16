# aliyun-analytic-db
阿里云分析型数据库的连接层

  基于laravel5.5实现

1. 使用composer安装扩展
``` composer require donng/aliyun-analytic-db ```

2. 生成配置文件
``` php artisan vendor:publish --provider="Donng\AnalyticDB\Providers\AnalyticDBProvider"```
  
3. 生成sql记录的迁移文件
  ```php artisan migrate```
  生成sql_records表，记录执行的表和运行的时间，默认关闭。如果不需要sql记录功能，####可跳过此步骤。
  
