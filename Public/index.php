<?php
header('Content-type:text/html;charset=utf8');
define("BLOG_DEBUG", true);
define("WEB_ROOT",__DIR__);
try {
    //引入核心服务文件
    include __DIR__.'/../Application/Config/Server.php';

} catch(\Exception $e) {
    //捕获错误信息
    echo 'INFO: ',$e->getMessage(),'<br />';
    echo 'LINE: ',$e->getLine();//
}
