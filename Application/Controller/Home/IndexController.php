<?php
namespace MShop\Controller\Home;
use MShop\Controller\Common\HomeBaseController;
class IndexController extends HomeBaseController {
    
    public function indexAction()
    {
        $hs = $this->getService('Home', 'Home');
        $hs->abc();


        exit;
        $this->view->pick('Home/Index/index');
    }
    
    /**
     * 创建权限
     */
    public function authCreateAction()
    {
        $controllerName = $this->request->getPost('controller_name');
        $groupName = $this->request->getPost('group_name');
        $baseDir = WEB_ROOT . $this->config->application->controllerDir;
        $file = $groupName.'/'.$controllerName.'Controller.php';
        $fileName = $baseDir.$file;
        $fileStr = @file_get_contents($fileName);
        if(!$fileStr) {
            echo 'error';exit;
        }
        preg_match_all("/public.+?function\s+?(.+?)Action/i",$fileStr,$arr);
        preg_match_all("/class\s*?(.*?)Controller/i",$fileStr,$arr2);
        preg_match_all("/namespace\s*?(.*?);/i",$fileStr,$arr3);   
        $auth = array();
        $auth['auth_list'] = $arr[1];
        $auth['controller_name'] = $arr2[1];
        $auth['space_name'] = $arr3[1];
        
        $data = [
            'controller_name'=> trim($auth['controller_name'][0]),
            'space_name'=>trim($auth['space_name'][0]),
        ];
        
        $hs = $this->getService('Home', 'Home');
        $controllerAuthList = $hs->getControllerAuthList($data);
        
        $diffAuth  = [];
        foreach($auth['auth_list'] as $k => $v) {
            $diffAuth[$v] = 0;
            foreach($controllerAuthList as $k1 => $v1) {
                if ($v == $v1['action_name']) {
                    $diffAuth[$v] = 1;
                    break;
                }
            }
        } 
        $this->view->auth = $auth;
        $this->view->diffAuth = $diffAuth;
        $this->view->pick("/Home/Index/auth_create");
    }
    
    /**
     * 添加权限
     */
    public function addAuthAction()
    {
        $this->view->pick("/Home/Index/add_auth");
    }
    
    /**
     * 导入权限
     */
    public function addAuthPostAction()
    {
        $data = [];
        $data['controller_name'] = trim($this->request->getPost("controller_name"));
        $data['space_name']      = trim($this->request->getPost("space_name"));
        $data['action_name']     = trim($this->request->getPost('auth_action'));
        $hs = $this->getService('Home', 'Home');
        if ($hs->checkOneAuth($data)) {
            $returnData['status'] = 0;
            $returnData['message'] = '导入的权限已存在';
            echo json_encode($returnData);exit;
        }
        
        $res = $hs->addAuth($data);
        $returnData = []; 
        if ($res) {
            $returnData['status'] = 1;
            $returnData['message'] = '导入权限成功';
        } else {
            $returnData['status'] = 0;
            $returnData['message'] = '导入权限失败';
        }
        echo json_encode($returnData);exit;
    }
    
    /**
     * 删除权限
     */
    public function removeAuthPostAction()
    {
        $data = [];
        $data['controller_name'] = trim($this->request->getPost("controller_name"));
        $data['space_name']      = trim($this->request->getPost("space_name"));
        $data['action_name']     = trim($this->request->getPost('auth_action'));
        $hs = $this->getService('Home', 'Home');
        $res = $hs->removeAuth($data);
        $returnData = []; 
        if ($res) {
            $returnData['status'] = 1;
            $returnData['message'] = '删除权限成功';
        } else {
            $returnData['status'] = 0;
            $returnData['message'] = '删除权限失败';
        }

        echo json_encode($returnData);exit;
    }
}
