<?php

namespace Forseti\AdminBundle\Controller;
use Forseti\AdminBundle\Entity\User;

class UserAdminController extends AdminController
{
    public function indexAction($name)
    {
        return $this->render('', array('name' => $name));
    }

    protected function createNewEntity()
    {
        return $this->get('fos_user.user_manager')->createUser()->setPlainPassword($this->config['entities']['User']['initialPassword']);
    }

    protected function prePersistEntity(User $user)
    {
        $this->get('fos_user.user_manager')->updateUser($user, false);
    }

    protected function preUpdateEntity(User $user)
    {
        $this->get('fos_user.user_manager')->updateUser($user, false);
    }
}
