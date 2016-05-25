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
     * 导入权限
     */
    public function addAllAuthPostAction()
    {
        $returnData = []; 
        $returnData['status'] = 0;
        $returnData['message'] = "";
        $data = $this->request->getPost("data");
        if (empty($data)) {
            $returnData['message'] = "没有获取到任何权限数据，请刷新页面再试！";
           echo json_encode($returnData);exit;
        }
        $flag = 0;
        foreach ($data as $k => $v) {
            $mData = [];
            $mData['controller_name'] = trim($v['controller_name']);
            $mData['space_name']      = trim($v['space_name']);
            $mData['action_name']     = trim($v['action_name']);
            $hs = $this->getService('Home', 'Home',true);
            if (!$hs->checkOneAuth($mData)) {
                $hs->addAuth($mData);
                $flag = 1;
            }
        }
        if ($flag == 0) {
            $returnData['status'] = 1;
            $returnData['message'] = "全部权限导入失败,没有任何权限数据需要导入"; 
        } else {
            $returnData['status'] = 1;
            $returnData['message'] = "全部权限导入成功"; 
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
    
    
    /**
     * 删除所有权限
     */
    public function removeAllAuthPostAction()
    {
        $returnData = []; 
        $returnData['status'] = 0;
        $returnData['message'] = "";
        $data = $this->request->getPost("data");
        if (empty($data)) {
            $returnData['message'] = "没有获取到任何权限数据，请刷新页面再试！";
           echo json_encode($returnData);exit;
        }
        $flag = 0;
        foreach ($data as $k => $v) {
            $mData = [];
            $mData['controller_name'] = trim($v['controller_name']);
            $mData['space_name']      = trim($v['space_name']);
            $mData['action_name']     = trim($v['action_name']);
            $hs = $this->getService('Home', 'Home',true);
            if ($hs->checkOneAuth($mData)) {
                $hs->removeAuth($mData);
                $flag = 1;
            }
        }
        $returnData['status'] = 1;
        $returnData['message'] = "全部权限删除成功"; 
        if ($flag == 0) {
            $returnData['status'] = 0;
            $returnData['message'] = "没有任何权限需要删除"; 
        }
        echo json_encode($returnData);exit;
    }
}
