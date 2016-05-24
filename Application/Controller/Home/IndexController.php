<?php
namespace MShop\Controller\Home;
use MShop\Controller\Common\HomeBaseController;
class IndexController extends HomeBaseController {
    
    public function indexAction()
    {
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
        $this->view->auth = $auth;
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
