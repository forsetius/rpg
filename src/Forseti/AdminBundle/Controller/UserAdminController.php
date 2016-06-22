<?php

namespace Forseti\AdminBundle\Controller;
use Forseti\AdminBundle\Entity\User;

class UserAdminController extends AdminController
{
    protected function createNewEntity()
    {
        return $this->get('fos_user.user_manager')->createUser()->setPlainPassword($this->config['entities']['User']['initialPassword']);
    }

    protected function prePersistEntity($user)
    {
        $this->get('fos_user.user_manager')->updateUser($user, false);
    }

    protected function preUpdateEntity($user)
    {
        $this->get('fos_user.user_manager')->updateUser($user, false);
    }
}
