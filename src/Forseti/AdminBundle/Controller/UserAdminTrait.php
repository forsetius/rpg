<?php
namespace Forseti\AdminBundle\Controller;

use Symfony\Component\HttpFoundation\Request;

trait UserAdminTrait {
    protected function doUserSecurity(Request $request)
    {
    }
    
    protected function createNewUserEntity()
    {
        //echo '<pre>';echo \get_class($this->get('fos_user.user_manager'));echo '</pre>';
        return $this->get('fos_user.user_manager')->createUser()->setPlainPassword($this->config['entities']['User']['initialPassword']);
    }

    protected function prePersistUserEntity($user)
    {
        $this->get('fos_user.user_manager')->updateUser($user, false);
    }
    
    protected function preUpdateUserEntity($user)
    {
        $this->get('fos_user.user_manager')->updateUser($user, false);
    }
}