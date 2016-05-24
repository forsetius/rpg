<?php

namespace Forseti\AdminBundle\DependencyInjection;

use JavierEguiluz\Bundle\EasyAdminBundle\Configuration\ConfigManager as BaseCM;
use Symfony\Component\DependencyInjection\ContainerInterface;

class ConfigManager extends BaseCM
{
    /** @var ContainerInterface */
    protected $container;

    public function isActionEnabled($entityName, $view, $action)
    {
        dump(true);die();
        if (! $this->container->get('security')->hasRole(strtoupper("ROLE_{$entityName}_{$action}"))) return false;
        return parent::isActionEnabled($entityName, $view, $action);
    }
}