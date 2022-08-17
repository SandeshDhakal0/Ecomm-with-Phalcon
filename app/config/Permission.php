<?php 

use Phalcon\Mvc\Dispatcher,
    Phalcon\Events\Event;

class Permission extends \Phalcon\Mvc\User\Plugin
{
    protected $_publicResources = [
        'index' => '*',
        'signin' => '*'
    ];
    protected $_userResources = [ 
        'dashboard' => ['*']
    ];
    protected $_adminResources = [
        'admin' => ['*']
    ];

    protected function _getAcl()
    {
        if(!isset($this->persistent->acl))
        {
            $acl = new \Phalcon\Acl\Adapter\Memory();
            $acl->setDefaultAction(Phalcon\Acl::DENY);

            $roles = [
                'guest'=> new \Phalcon\Acl\Role('guest'),
                'user' => new \Phalcon\Acl\Role('user'),
                'admin' => new \Phalcon\Acl\Role('admin'),
            ];
            foreach($roles as $role){
                $acl->addRole($role);
            }
            //Public Resource 
            foreach($this->_publicResources as $resource => $action){
                $acl->addResource(new \Phalcon\Acl\Resource($resource),$action);
            }
            //User Resource
            foreach($this->_userResources as $resource => $action){
                $acl->addResource(new \Phalcon\Acl\Resource($resource),$action);
            }
            //Admin Resource
            foreach($this->_adminResources as $resource => $action){
                $acl->addResource(new \Phalcon\Acl\Resource($resource),$action);
            }
            //Allow all roles to access the Public Resources
            foreach($roles as $role){
                foreach($this->_publicResources as $resource => $action){
                    $acl->allow($role->getName(), $resource, '*');
                }
            }
            // Allow User and Admin to access the UserResources
            foreach($this->_userResources as $resource => $actions){
                foreach($actions as $action){
                    $acl->allow('user',$resource, $action);
                    $acl->allow('admin',$resource, $action);
                }
            }
            // Allow admin to access Admin resources
            foreach($this->_adminResources as $resource => $actions){
                foreach($actions as $action){
                    $acl->allow('admin',$resource, $action);
                }
            }
                $this->persistent->acl = $acl;
        }
        return $this->persistent->acl;
    }

    public function beforeExecuteRoute(Event $event, Dispatcher $dispatcher)
    {
        $role = $this->session->get('role');
        if(!$role){
            $role = 'guest';
        }

        // Get the current controller/action from the dispatcher
        $controller = $dispatcher->getControllerName();
        $action     = $dispatcher->getActionName();
        // Get the ACL Rule List
        $acl = $this->_getAcl();

        //See if they have the permission
        $allowed = $acl->allowed($role, $controller, $action);
        if ($allowed != Phalcon\Acl::ALLOW)
        {
            // Allowed
            $dispatcher->forward([
                'controller' => 'index',
                'action' => 'index'
            ]);
            //Stops the dispatcher at the current operations
            return false;
        }
    }
}