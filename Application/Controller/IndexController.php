<?php
namespace MShop\Controller;
use Phalcon\Mvc\Controller as Controller;
use MShop\Tools\Paginator\Adapter\DiyPaginator; //分页组件
class IndexController extends Controller {
    
    public function indexAction()
    {
        $currentPage = (int)$this->dispatcher->getParam('page');

        $oPage = new DiyPaginator(array(
            'count' => 20,
            'limit' => 1,
            'page' => $currentPage,
        ));
        $page = $oPage->current;
        $array = [];
        $tmp = ($page - 1) * 20;
        for ($i = $tmp; $i < ($tmp+20); $i++) {
            $n = $i +1;
            $array[] = array('id'=>$n,'name'=>'list'.$n);
        }
        $this->view->list = $array;
        $this->view->page = $oPage;
        $this->view->pick("index/index");
    }
   
    
    public function testAction()
    {
        $remark = $this->request->getPost('remark');
       echo json_encode(array('remark'=>'审核成功','id'=>100));
    }
}