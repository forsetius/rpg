<?php

namespace Forseti\AdminBundle\DependencyInjection;

use JavierEguiluz\Bundle\EasyAdminBundle\Configuration\ConfigManager as BaseCM;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Forseti\AdminBundle\Controller\AdminController;

class ConfigManager extends BaseCM
{
    /** @var ContainerInterface */
    protected $container;

    public function isActionEnabled($entityName, $view, $action)
    {
//        if (! AdminController::serviceContainer->get('security')->hasRole(strtoupper("ROLE_{$entityName}_{$action}"))) return false;
        return parent::isActionEnabled($entityName, $view, $action);
    }
}