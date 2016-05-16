<?php
namespace MShop\Controller;
use Phalcon\Mvc\Controller as Controller;
class IndexController extends Controller {
    
    public function indexAction()
    {
        $array = [];
        for ($i = 0; $i < 20; $i++) {
            $n = $i +1;
            $array[] = array('id'=>$n,'name'=>'list'.$n);
        }
        $this->view->list = $array;
    }
   
}