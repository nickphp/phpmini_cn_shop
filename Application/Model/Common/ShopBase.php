<?php
namespace MShop\Model\Common;
use MShop\Model\Common\Base;
/**
 * shop库基础类
 */
class ShopBase extends Base {
    /**
     * 初始化数据库连接
     * 自定义链接方式 不使用主从
     * 主从的连接方式可以通过 多主多从算法
     * 获取一个配置出来 这里使用默认单库连接
     * db数据库是默认的连接
     * 和单库运行
     */
    public function initialize()
    {
        //$this->setReadConnectionService('shopdb_slave'); //从库
        //$this->setWriteConnectionService('shopdb_master');//主库
        $this->setConnectionService('db'); //定义shop数据库连接 
    }
}