<?php
/**
 * Created by PhpStorm.
 * User: zhns_
 * Date: 2017/9/25
 * Time: 9:41
 */
$php_exe_path = 'G:\php\wamp64\bin\php\php5.6.25\php.exe';	# php.exe运行文件地址
$php_cli_run_file = 'cli_dome.php';	# 要运行文件地址
exec($php_exe_path." ".$php_cli_run_file);