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
            $mData = [];
            $mData['uid']             = '100';                  //用户id
            $mData['order_sn']        = '20160524124508998877';   //订单流水号
            $mData['total_amount']    = '1000';         //订单总金额
            $mData['total_num']       = '5';       //订单总数量
            $mData['discount_amount'] = '0'; //折扣总金额
            $mData['discount_rate']   = '0';   //订单折扣率
            $mData['gid']             = '5';           //商品ID
            $mData['buy_num']         = '5';       //购买数量
            $mData['buy_price']       = '200';     //购买价格
            $mData['market_price']    = '200';  //市场价格
            $mData['total_price']     = '1000';   //总价
            $mData['discount_rate']   = '0'; //折扣率
            $mData['add_time']        = $_SERVER['REQUEST_TIME'];      //添加时间
            $mData['update_time']     = $_SERVER['REQUEST_TIME'];   //修改时间
            $orderId = $this->os->addOrder($mData);
            var_dump($orderId);
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
