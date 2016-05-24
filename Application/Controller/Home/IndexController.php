<?php
namespace MShop\Controller\Home;
use MShop\Controller\Common\HomeBaseController;
class IndexController extends HomeBaseController {
    
    public function indexAction()
    {
        $this->view->pick('Home/Index/index');
    }
    
    public function testAction()
    {
        echo 'home test';
    }
    
    public function abcAction()
    {
        echo 'home abc';
    }
}
