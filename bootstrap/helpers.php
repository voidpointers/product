<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;

if (!function_exists('get_last_sql')) {
    /**
     * 获取最近一次执行的指令
     *
     * @return string
     * @access public
     */
    function get_last_sql()
    {
        // Register a database query listener with the connection.
        DB::listen(function ($sql) {
            $query = $sql->sql;
            if ($sql->bindings) {
                foreach ($sql->bindings as $replace) {
                    $value = is_numeric($replace) ? $replace : "'" . $replace . "'";
                    $query = preg_replace('/\?/', $value, $query, 1);
                }
            }
            dump($query);
        });
    }
}

if (!function_exists('custom_log')) {
    /**
     * 自定义日志
     *
     * @param string $level
     * @param string $path
     * @param $msg
     */
    function custom_log(string $level, string $path, $msg)
    {
        $log = new Logger('');
        try {
            $log->pushHandler(new StreamHandler(storage_path('logs/' . $path)));
        } catch (Exception $e) {

        }

        $msg = is_array($msg) ? json_encode($msg) : $msg;
        $log->log($level, $msg);
    }
}
