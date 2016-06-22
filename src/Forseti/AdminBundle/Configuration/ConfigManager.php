<?php
namespace Forseti\AdminBundle\Configuration;

use JavierEguiluz\Bundle\EasyAdminBundle\Configuration\ActionConfigPass;
use JavierEguiluz\Bundle\EasyAdminBundle\Configuration\ConfigManager as BaseCM;
use JavierEguiluz\Bundle\EasyAdminBundle\Configuration\DefaultConfigPass;
use JavierEguiluz\Bundle\EasyAdminBundle\Configuration\DesignConfigPass;
use JavierEguiluz\Bundle\EasyAdminBundle\Configuration\MetadataConfigPass;
use JavierEguiluz\Bundle\EasyAdminBundle\Configuration\NormalizerConfigPass;
use JavierEguiluz\Bundle\EasyAdminBundle\Configuration\PropertyConfigPass;
use JavierEguiluz\Bundle\EasyAdminBundle\Configuration\TemplateConfigPass;
use JavierEguiluz\Bundle\EasyAdminBundle\Configuration\ViewConfigPass;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class ConfigManager
 * @author Javier Eguiluz <javier.eguiluz@gmail.com>
 * @author Marcin Paździora <forseti.pl@gmail.com>
 */
class ConfigManager extends BaseCM
{
    protected $backendConfig;
    /** @var ContainerInterface */
    protected $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function isActionEnabled($entityName, $view, $action)
    {
        if (! $this->container->get('security')->hasRole(strtoupper("ROLE_{$entityName}_{$action}"))) return false;
        return parent::isActionEnabled($entityName, $view, $action);
    }

    public function getBackendConfig($propertyPath = null)
    {
        if (null === $this->backendConfig) {
            $this->backendConfig = $this->processConfig();
        }

        if (empty($propertyPath)) {
            return $this->backendConfig;
        }

        // turns 'design.menu' into '[design][menu]', the format required by PropertyAccess
        $propertyPath = '['.str_replace('.', '][', $propertyPath).']';

        return $this->container->get('property_accessor')->getValue($this->backendConfig, $propertyPath);
    }

    /**
     * It processes the original backend configuration defined by the end-users
     * to generate the full configuration used by the application. Depending on
     * the environment, the configuration is processed every time or once and
     * the result cached for later reuse.
     *
     * @return array
     */
    protected function processConfig()
    {
        $originalBackendConfig = $this->container->getParameter('easyadmin.config');

        if (true === $this->container->getParameter('kernel.debug')) {
            return $this->doProcessConfig($originalBackendConfig);
        }

        $cache = $this->container->get('easyadmin.cache.manager');
        if ($cache->hasItem('processed_config')) {
            return $cache->getItem('processed_config');
        }

        $backendConfig = $this->doProcessConfig($originalBackendConfig);
        $cache->save('processed_config', $backendConfig);

        return $backendConfig;
    }

    /**
     * It processes the given backend configuration to generate the fully
     * processed configuration used in the application.
     *
     * @param string $backendConfig
     *
     * @return array
     */
    protected function doProcessConfig($backendConfig)
    {
        $configPasses = array(
            new NormalizerConfigPass($this->container),
            new DesignConfigPass($this->container->get('twig'), $this->container->getParameter('kernel.debug')),
            new MenuConfigPass($this->container->get('security')),
            new ActionConfigPass(),
            new MetadataConfigPass($this->container->get('doctrine')),
            new PropertyConfigPass(),
            new ViewConfigPass(),
            new TemplateConfigPass($this->container->getParameter('kernel.root_dir').'/Resources/views'),
            new DefaultConfigPass(),
        );

        foreach ($configPasses as $configPass) {
//            \dump($backendConfig['design']['menu']);
            $backendConfig = $configPass->process($backendConfig);
        }

        return $backendConfig;
    }
}

