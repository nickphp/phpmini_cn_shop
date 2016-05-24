<?php
namespace MShop\Service\Common;
use MShop\Service\Common\BaseService;
class HomeBaseService extends BaseService{
    
    /**
     * 测试管理器
     */
    public function testModelsManager()
    {
        $manager = $this->di->get("modelsManager");
    }
    
    public function abc()
    {
        $query = $this->di->get("modelsManager")->createBuilder();
        $a = $query->from('\MShop\Model\Shop\Orders')->getQuery()->execute();
        //$a = $manager->executeQuery("select * from \MShop\Model\Shop\Orders");
        var_dump($a->toArray());
    }
}