<?php
namespace MShop\Controller\Common;
use Phalcon\Mvc\Controller;
class BaseController extends Controller {
    public $serviceInstace = [];//服务实例
    public function initialize()
    {

    }
    
    /**
     * 获取服务实例
     * @param type $serviceGroupName 服务组名称
     * @param type $serviceName 服务名称
     * @param type $flag 标记 为真 每次都获取新的实例
     * @return type
     */
    public function getService($serviceGroupName, $serviceName, $flag = false)
    {
        $name = "\MShop\Service\\{$serviceGroupName}\\".$serviceName.'Service';
        $md5Name = md5($name);
        if ($flag == false) {
           if(isset($this->serviceInstace[$md5Name])) {
               return $this->serviceInstace[$md5Name];
           } 
           return $this->serviceInstace[$md5Name] = new $name();
        }
        return $this->serviceInstace[$md5Name] = new $name();
    }
}
