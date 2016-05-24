<?php
namespace MShop\Controller\Order;
use MShop\Controller\Common\OrderBaseController;
/**
 * 订单控制器
 * 处理对订单的操作
 */
class OrderController extends OrderBaseController {
    public $os = null;//订单服务实例对象
    public function initialize() 
    {
        parent::initialize();
        $this->os = $this->getService('Order', 'Order');//初始化实例对象
    }
    
    /**
     * 添加订单
     */
    public function addOrderAction()
    {

    }
    
    /**
     * 删除订单
     */
    public function removeOrderAction()
    {
        
    }
    
    /**
     * 修改订单
     */
    public function editOrderAction()
    {
        
    }
    
    /**
     * 变更订单状态
     */
    public function changeOrderStatusAction()
    {
        
    }
    
    /**
     * 检查订单状态
     */
    public function checkOrderStatusAction()
    {
        
    }
    
    /**
     * 按照订单主键ID查询订单
     */
    public function getOrderOneByID()
    {
        
    }
    
    /**
     * 按照订单编号查询订单
     */
    public function getOrderOneBySn()
    {
        
    }
    
    /**
     * 获取订单列表
     */
    public function getOrderList()
    {
        
    }
    
    /**
     * 根据订单号获取订单详情
     */
    public function getOrdreDetailsById()
    {
        
    }
    
    /**
     * 根据订单编号获取订单详情
     */
    public function getOrderDetailsBySn()
    {
        
    }
}
