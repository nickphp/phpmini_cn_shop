<?php
namespace MShop\Service\Home;
use MShop\Service\Common\HomeBaseService;
class HomeService  extends HomeBaseService {
    
    /**
     * 导入权限
     */
    public function addAuth($data)
    {
        $authList = $this->getModel('Shop', 'AuthList');
        $mData = [];
        $mData['action_name'] = $data['action_name'];
        $mData['controller_name'] = $data['controller_name'];
        $mData['space_name'] = $data['space_name'];
        $mData['add_time'] = $_SERVER['REQUEST_TIME'];
        $mData['update_time'] = $_SERVER['REQUEST_TIME'];
        if($authList->save($mData) != false){
            return true;
        }
        return false;
    }
    
    /**
     * 导入权限
     */
    public function removeAuth($data)
    {
        $conditions = "action_name = :action_name: AND controller_name = :controller_name: AND space_name=:space_name:";
        $parameters = array(
            "action_name" => $data['action_name'],
            "controller_name" => $data['controller_name'],
            'space_name' =>  $data['space_name'],
        );
        $array = array(
        $conditions,
        "bind" => $parameters,
        );
        $authList = self::find('Shop', 'AuthList', $array);
        if ($authList->delete() != false) {
            return true;
        }
        return false;
    }
}