<?php
namespace MShop\Tools\Plugin;
use Phalcon\Events\Event;
use Phalcon\Mvc\User\Plugin;
use Phalcon\Mvc\Dispatcher;
use Phalcon\Acl;
use Phalcon\Acl\Adapter\Memory as AclMemory;
/**
 * acl权限验证插件
 */
class SecurityPlugin extends Plugin
{
    public function __construct($dependencyInjector)
    {
        $this->_dependencyInjector = $dependencyInjector;
    }
 
    private function getAcl()
    {
        if (isset($this->persistent->acl))
        {
            //实例化ACL
            $acl = new AclMemory();
            
            //设置默认权限(禁止)
            //$acl->setDefaultAction(\Phalcon\Acl::DENY);
            $acl->setDefaultAction(\Phalcon\Acl::ALLOW);
            
            //添加角色
            $roles = array(
                'Guests' => new \Phalcon\Acl\Role('Guests'),
            );
            
            foreach ($roles as $role) {
                $acl->addRole($role);
            }
            
            //角色资源
            $AllResources = array(
                'GuestsResources' => array(
                    'MShop\Controller\Home\index'  => array('index','test'),
                    'MShop\Controller\Order\order'  => array('abc'),
                ),
            );
            //添加资源并授权对应权限给角色
            foreach ($roles as $role) {
                foreach ($AllResources[$role->getName().'Resources'] as $resource => $actions) {
                    $acl->addResource(new \Phalcon\Acl\Resource($resource), $actions);
                    foreach ($actions as $action) {
                        $acl->allow($role->getName(),$resource,$action);
                    }
                }
            }
            $this->persistent->acl = $acl; //权限持久化
        }
        return $this->persistent->acl;
    }
 
    public function beforeExecuteRoute(Event $event, Dispatcher $dispatcher)
    {
        $auth = $this->session->get('auth');
        if (!$auth){
            $role = 'Guests';
        } else {
            $role = $auth['role'];
        }
 
        //获取控制器和动作
        $controller = $dispatcher->getControllerName();
        $action     = $dispatcher->getActionName();
        $namespace = $dispatcher->getNamespaceName();
        $acl        = $this->getAcl();
        $allowed = $acl->isAllowed($role, $namespace.'\\'.$controller, $action);
        if ($allowed != Acl::ALLOW) {
            $this->flash->error('无权限访问！');
            //在View中勿用{{ flash.output() }}输出,否则会抛出异常,在转发的对应View中使用{{ content() }}可正常输出
            //$dispatcher->forward(array('controller'=>'index','action'=>'index'));
            return false;
        }
    }
}
