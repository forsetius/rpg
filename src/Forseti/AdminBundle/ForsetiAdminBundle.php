<?php

namespace Forseti\AdminBundle;

use JavierEguiluz\Bundle\EasyAdminBundle\EasyAdminBundle;

class ForsetiAdminBundle extends EasyAdminBundle
{
    public function getParent()
    {
        return 'EasyAdminBundle';
    }
}
