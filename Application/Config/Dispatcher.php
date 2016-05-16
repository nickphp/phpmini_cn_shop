<?php
$di->set('dispatcher', function () use($config) {
    $eventsManager = new \Phalcon\Events\Manager();
    //$eventsManager->attach('dispatch', new PhpMini\Tools\Plugin\CacheEnablerPlugin());
    $eventsManager->attach("dispatch:beforeDispatchLoop", function($event, $dispatcher) {
        $keyParams = array();
        $params    = $dispatcher->getParams();
        // foreach ($params as $number => $value) {
        //     if ($number & 1) {
        //         $keyParams[$params[$number - 1]] = $value;
        //     }
        // }
        $tmpParams = array();
        foreach($params as $k => $v) {
            if(is_numeric($k)) {
               $tmpParams[$k] = $v; 
            }
        }
        $params = $tmpParams;
        if(!empty($params)) {
            for ($i = 0,$count=count($params); $i <$count;$i++) {
                if ($i % 2 == 1) {
                    $keyParams[$tmp] = $params[$i];
                } else {
                    $tmp = $params[$i];
                    $keyParams[$tmp] = "";
                }
            }
        }
        $dispatcher->setParams($keyParams);
    });
    $dispatcher = new \Phalcon\Mvc\Dispatcher();
    $dispatcher->setEventsManager($eventsManager);
    return $dispatcher;
});
