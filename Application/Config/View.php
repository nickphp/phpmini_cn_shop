<?php
//注册一个视图服务
$di->set('view',function() use($config, $di) {
    $viewsPath = WEB_ROOT . $config->application->viewDir; //获取视图存储路径
    $compiledPath = WEB_ROOT . $config->application->voltCompiled; //获取编译后的模板存储路径
    $view = new \Phalcon\Mvc\View(); //获取视图对象
    $view->setViewsDir($viewsPath);  //设置视图路径
    //注册模板引擎 volt 后缀采用.html
    $view->registerEngines(array(
        //通过匿名函数加载的方式自定义设置模板编译路径和文件名
        ".html" => function ($view, $di) use ($viewsPath, $compiledPath){
            $volt = new \Phalcon\Mvc\View\Engine\Volt($view, $di);//使用volt模板引擎
            //设置模板选项
            $volt->setOptions(array(
                //自定义文件生成方式
                'compiledPath' => function ($templatePath) use ($viewsPath, $compiledPath) {
                    //定位替换模板编译目录 和 views目录层级保持统一
                    $templateNewPath = str_replace($viewsPath, $compiledPath, $templatePath);
                    $rpos = strrpos($templateNewPath, '/'); //查找路径 搜索斜杠在路径中最右边的位置
                    $templateDir = substr($templateNewPath,0,$rpos);//获取新的字符串到最右边斜杠处
                    //根据新的目录路径，检查目录是否存在，目录不存在就创建，存在则跳过忽略
                    if(!file_exists($templateDir)) {
                        @mkdir($templateDir,0777,true); //递归的创建目录
                    }
                    return $templateNewPath . '.compiled'; //返回最终编译文件名
                }
            ));

            //转化时间戳为日期对象 向模板添加一个格式化时间的方法
            $compiler = $volt->getCompiler();
            $compiler->addFilter('formatDate', function ($resolvedArgs, $exprArgs) {
                if (empty($exprArgs)) {
                    return "date('Y-m-d H:i:s',{$resolvedArgs})";
                }
                return "date('{$exprArgs[1]['expr']['value']}',{$exprArgs[0]['expr']['value']})";
            });

            return $volt; //返回模板对象
        } 
    ));
   return $view; //返回视图对象
});


// 视图缓存
//$di->set('viewCache', function () {
//    // Cache data for one day by default
//    $frontCache = new \Phalcon\Cache\Frontend\Output(
//        array(
//            "lifetime" => 86400
//        )
//    );
//
//    // Memcached connection settings
//    $cache = new Phalcon\Cache\Backend\Redis($frontCache, array(
//        'host' => '127.0.0.1',
//        'port' => 6379,
//        //'auth' => 'foobared',
//        'persistent' => false
//    ));
//    return $cache;
//});
