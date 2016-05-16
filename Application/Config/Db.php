<?php
//注册一个数据库连接服务 使用pdo驱动数据库
$di->set('db',function() use ($config, $di) {
    $connection =  new \Phalcon\Db\Adapter\Pdo\Mysql(array(
       'host'     => $config->database->host, //设置数据库地址
       'username' => $config->database->username, //设置数据库用户名
       'password' => $config->database->password, //设置密码
       'dbname'   => $config->database->dbname,   //设置数据库
       'charset'  => $config->database->charset,//设置编码
       "options"  => array(PDO::ATTR_CASE => PDO::CASE_LOWER),
    ));
    
    $eventsManager  = $di->get("eventsManager");
    $logger = new \Phalcon\Logger\Adapter\File(WEB_ROOT.$config->logs->MShopDblog); 

    $eventsManager->attach('db', function($event, $connection) use ($logger) {
        if ($event->getType() == 'afterQuery') { 
                $logger->log($connection->getSQLStatement(), \Phalcon\Logger::INFO); 
        } 
    }); 
    $connection->setEventsManager($eventsManager); 

    return $connection; 

});

