<?php
namespace MShop\Service\Order;
use MShop\Service\Common\OrderBaseService;
class OrderService  extends OrderBaseService {
    
    /**
     * 添加订单服务
     * @param type $data
     * @return type 
     * @throws \Exception
     */
    public function addOrder($data)
    {
        try{
            //事物支持
            $manager = new \Phalcon\Mvc\Model\Transaction\Manager();
            $transaction = $manager->get();
            
            $order = $this->getModel('Shop','Orders');//订单实例
            $order->setTransaction($transaction); //设置事物
            $od['uid']             = $data['uid'];                  //用户id
            $od['order_sn']        = $data['order_sn'];             //订单流水号
            $od['total_amount']    = $data['total_amount'];         //订单总金额
            $od['total_num']       = $data['total_num'];       //订单总数量
            $od['discount_amount'] = $data['discount_amount']; //折扣总金额
            $od['discount_rate']   = $data['discount_rate'];   //订单折扣率
            $od['add_time']        = $data['add_time'];        //添加时间
            $od['update_time']     = $data['update_time'];     //修改时间
            if ($order->create($od) == false) {
                $transaction->rollback("Can't save orders");
            }
            
            $orderDetails = $this->getModel('Shop','OrdersDetails');//明细实例
            $orderDetails->setTransaction($transaction);//设置事物
            $odd['gid']           = $data['gid'];           //商品ID
            $odd['oid']           = $order->id;             //订单ID(关联外键)
            $odd['uid']           = $data['uid'];           //用户ID
            $odd['buy_num']       = $data['buy_num'];       //购买数量
            $odd['buy_price']     = $data['buy_price'];     //购买价格
            $odd['market_price']  = $data['market_price'];  //市场价格
            $odd['total_price']   = $data['total_price'];   //总价
            $odd['discount_rate'] = $data['discount_rate']; //折扣率
            $odd['add_time']      = $data['add_time'];      //添加时间
            $odd['update_time']   = $data['update_time'];   //修改时间
            if ($orderDetails->create($odd) == false) {
                $transaction->rollback("Can't save order details");
            }
            $transaction->commit();//提交
            return $order->id;//返回订单ID
            
        } catch (Exception $e) {
            throw new \Exception($e);
        }
    }
}