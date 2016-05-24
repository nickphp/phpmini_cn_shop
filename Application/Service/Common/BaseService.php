<?php
namespace MShop\Service\Common;
use Phalcon\DI;
class BaseService {
    protected $di;
    public $modelInstace = [];//服务实例
    public function __construct()
    {
        $this->di = DI::getDefault();
    }
    /**
     * 获取服务实例
     * @param type $serviceGroupName 服务组名称
     * @param type $serviceName 服务名称
     * @param type $flag 标记 为真 每次都获取新的实例
     * @return type
     */
    public function getModel($modelGroupName, $modelName, $flag = false)
    {
        $name = "\MShop\Model\\{$modelGroupName}\\".$modelName;
        $md5Name = md5($name);
        if ($flag == false) {
           if(isset($this->modelInstace[$md5Name])) {
               return $this->modelInstace[$md5Name];
           } 
           return $this->modelInstace[$md5Name] = new $name();
        }
        return $this->modelInstace[$md5Name] = new $name();
    }
    
    /**
     * 获取find对象
     * @param type $modelGroupName
     * @param type $modelName
     * @param type $params
     * @return type
     */
    public static function find($modelGroupName, $modelName, $params)
    {
        $name = "\MShop\Model\\{$modelGroupName}\\".$modelName;
        return $name::find($params);
    }
    
     /**
     * 获取findFirst对象
     * @param type $modelGroupName
     * @param type $modelName
     * @param type $params
     * @return type
     */
    public static function findFirst($modelGroupName, $modelName, $params)
    {
        $name = "\MShop\Model\\{$modelGroupName}\\".$modelName;
        return $name::findFirst($params);
    }
}