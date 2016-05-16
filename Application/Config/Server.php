<?php
    //引入主配置文件 该配置文件定义全局配置信息
    $config = new \Phalcon\Config\Adapter\Ini(WEB_ROOT.'/../Application/Config/Config.ini');

    //自动加载器实例化
    $loader = new \Phalcon\Loader();

    //通过命名空间的方式注册应用根目录
    $loader->registerNamespaces(
        array(
            "MShop\Controller" => WEB_ROOT . $config->application->controllerDir, //控制器层
            "MShop\Model"      => WEB_ROOT . $config->application->modelDir,      //模型层
            "MShop\Tools"      => WEB_ROOT . $config->application->toolsDir,      //工具层
        )
    )->register();

    //创建$di服务工厂
    $di = new \Phalcon\DI\FactoryDefault(); 

    //注入$config服务
    $di->set("config",function() use ($config){
        return $config;
    });
    
    //设置路由服务
    $di->set('router', function () use($config) {
        return include WEB_ROOT. $config->include->router;
    });

    //设置调度服务
    include WEB_ROOT. $config->include->dispatcher;

    //设置db服务
    include WEB_ROOT. $config->include->db;

    //设置视图
    include WEB_ROOT. $config->include->view;
    
    //设置URL的根路径 
    $di->set('url', function(){
        $url = new \Phalcon\Mvc\Url();
        $url->setBaseUri('/');
        return $url;
    });
    
    //设置session服务
    $di->setShared('session', function(){
        $session = new \Phalcon\Session\Adapter\Files();
        $session->start();
        return $session;
    });
    
    $di->set('flashSession', function () {
        $flashSession = new \Phalcon\Flash\Session(
            array(
                'error'   => 'alert alert-danger',
                'success' => 'alert alert-success',
                'notice'  => 'alert alert-info',
                'warning' => 'alert alert-warning'
            )
        );
        return $flashSession;
    });

    $di->set('security', function () {
        $security = new \Phalcon\Security();
        $security->setWorkFactor(12);
        return $security;
    }, true);


    $di->set('crypt', function () {
        $crypt = new \Phalcon\Crypt();
        $crypt->setKey('##@$@8398aaDKkse872%$#%!@#!'); // 加密K
        return $crypt;
    });
    
    $di->set('cookies', function () {
        $cookies = new \Phalcon\Http\Response\Cookies();
        $cookies->useEncryption(false);
        return $cookies;
    });


    //实例化应用
    $application = new \Phalcon\Mvc\Application();
    
    //注入$di服务
    $application->setDI($di);
    
   // //获取服务注册服务清单
//    $services = $application->getDI()->getServices();
//    foreach($services as $key => $service) {
//            var_dump($key);
//    }
    
    //获取执行结果内容
    echo $application->handle()->getContent();