<?php
    //转换名字空间转换为小写,用于兼容匹配路由分组大小写识别问题
    if (isset($_GET['_url'])) {
        $preg = "^\/[a-zA-Z0-9]+\/?";
        preg_match("#{$preg}#i",$_GET['_url'],$arra);
        $_GET['_url'] = preg_replace("#{$preg}#i", strtolower($arra[0]), $_GET['_url']);
        $_SERVER['REQUEST_URI'] = $_GET['_url'];
        //$router->setUriSource(Phalcon\Mvc\Router::URI_SOURCE_GET_URL); //Use $_GET['_url'] (default)
        //$router->setUriSource(Phalcon\Mvc\Router::URI_SOURCE_SERVER_REQUEST_URI); //Use $_SERVER['REQUEST_URI'] (default)
    }

    $router = new \Phalcon\Mvc\Router(); 
    $router->removeExtraSlashes(true);  //去除路由地址结尾的斜杠

    //定义访问home分组的规则
    $router->add("/home\/?([a-zA-Z0-9_-]*)\/?([a-zA-Z0-9_]*)/:params", array(
        "namespace" => 'MShop\Controller\Home',
        'controller' => 1,
        'action'     => 2,
        "params"    => 3,
    ));
    
     //定义访问Order分组的规则
    $router->add("/order\/?([a-zA-Z0-9_-]*)\/?([a-zA-Z0-9_]*)/:params", array(
        "namespace" => 'MShop\Controller\Order',
        'controller' => 1,
        'action'     => 2,
        "params"    => 3,
    ));
    
    //  $router->add("/shop\/?([a-zA-Z0-9_-]*)\/?([a-zA-Z0-9_]*)/:params", array(
    //     "namespace" => 'PhpMini\Controller\Shop',
    //     'controller' => 1,
    //     'action'     => 2,
    //     "params"    => 3,
    // ));

    // 例子转换
    // $router
    // ->add('/index/{slug:[a-z\-]+}/:params', array(
    //     "namespace" => 'Blog\Controller\Home',
    //     'controller' => 'index',
    //     'action'     => 1,
    //     "params"    => 2,
    // ))
    // ->convert('slug', function ($slug) {
    //     return str_replace('-', '', $slug);
    // });


    //定义默认访问控制器
    $router->setDefaults(array(
            "namespace" => 'MShop\Controller',
            "controller" => "Index",
            "action" => "index"
    ));

//    //定义404错误页面
//    $router->add("/404", array(
//        "namespace" => 'Blog\Controller\Home',
//        'controller' => "index",
//        'action'     => "error404",
//    ));

    $router->handle();

    return $router;