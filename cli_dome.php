<?php
/**
 * Created by PhpStorm.
 * User: zhns_
 * Date: 2017/9/25
 * Time: 9:34
 */

$count = 0;
while ($count < 10){
    $count ++;
    #   此处写代码逻辑
    #   require __DIR__.'/send.php';  #引入
    #   $send = new Send();   #实例
    #   $send->run();      #调用
    file_put_contents(__DIR__.'/cli_log.txt',"【正在执行PHP cli扩展，现在是第".$count."次】 \r\n",FILE_APPEND);
    sleep(3);
    echo "【正在执行PHP cli扩展，现在是第".$count."次】";
}
echo 'done';