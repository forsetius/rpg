<?php
namespace Forseti\AdminBundle\Configuration;

use EasyCorp\Bundle\EasySecurityBundle\Security\Security;
use JavierEguiluz\Bundle\EasyAdminBundle\Configuration\ConfigPassInterface;

/**
 * Class ConfigManager
 * @author Javier Eguiluz <javier.eguiluz@gmail.com>
 * @author Marcin Paździora <forseti.pl@gmail.com>
 */
class MenuConfigPass implements ConfigPassInterface
{
    protected $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    public function process(array $backendConfig)
    {
        // process 1st level menu items
        $menuConfig = $backendConfig['design']['menu'];
        $menuConfig = $this->normalizeMenuConfig($menuConfig, $backendConfig);
        $menuConfig = $this->processMenuConfig($menuConfig, $backendConfig);

        $backendConfig['design']['menu'] = $menuConfig;

        // process 2nd level menu items (i.e. submenus)
        foreach ($backendConfig['design']['menu'] as $i => $itemConfig) {
            if (empty($itemConfig['children'])) {
                continue;
            }

            $submenuConfig = $itemConfig['children'];
            $submenuConfig = $this->normalizeMenuConfig($submenuConfig, $backendConfig, $i);
            $submenuConfig = $this->processMenuConfig($submenuConfig, $backendConfig, $i);

            $backendConfig['design']['menu'][$i]['children'] = $submenuConfig;
        }
        return $backendConfig;
    }

    private function normalizeMenuConfig(array $menuConfig, $backendConfig, $parentItemIndex = -1)
    {
        // if the backend doesn't define the menu configuration: create a default
        // menu configuration to display all its entities
        if (empty($menuConfig)) {
            foreach ($backendConfig['entities'] as $entityName => $entityConfig) {
                $menuConfig[] = array('entity' => $entityName, 'label' => $entityConfig['label']);
            }
        }

        // replaces the short config syntax:
        //   design.menu: ['Product', 'User']
        // by the expanded config syntax:
        //   design.menu: [{ entity: 'Product' }, { entity: 'User' }]
        foreach ($menuConfig as $i => $itemConfig) {
            if (is_string($itemConfig)) {
                $itemConfig = array('entity' => $itemConfig);
            }

            $menuConfig[$i] = $itemConfig;
        }

        foreach ($menuConfig as $i => $itemConfig) {
            // normalize icon configuration
            if (!array_key_exists('icon', $itemConfig)) {
                $itemConfig['icon'] = ($parentItemIndex > -1) ? 'fa-chevron-right' : 'fa-chevron-circle-right';
            } elseif (empty($itemConfig['icon'])) {
                $itemConfig['icon'] = null;
            } else {
                $itemConfig['icon'] = 'fa-' . $itemConfig['icon'];
            }

            // normalize submenu configuration (only for main menu items)
            if (!isset($itemConfig['children']) && $parentItemIndex === -1) {
                $itemConfig['children'] = array();
            }

            // normalize 'default' option, which sets the menu item used as the backend index
            if (!array_key_exists('default', $itemConfig)) {
                $itemConfig['default'] = false;
            } else {
                $itemConfig['default'] = (bool)$itemConfig['default'];
            }

            // normalize 'target' option, which allows to open menu items in different windows or tabs
            if (!array_key_exists('target', $itemConfig)) {
                $itemConfig['target'] = false;
            } else {
                $itemConfig['target'] = (string)$itemConfig['target'];
            }

            $menuConfig[$i] = $itemConfig;
        }

        return $menuConfig;
    }

    private function processMenuConfig(array $menuConfig, $backendConfig, $parentItemIndex = -1)
    {
        foreach ($menuConfig as $i => $itemConfig) {
            // these options are needed to find the active menu/submenu item in the template
            $itemConfig['menu_index'] = ($parentItemIndex === -1) ? $i : $parentItemIndex;
            $itemConfig['submenu_index'] = ($parentItemIndex === -1) ? -1 : $i;

            // 1st level priority: if 'entity' is defined, link to the given entity
            if (isset($itemConfig['entity'])) {
                if (!$this->security->hasRole(strtoupper("ROLE_{$itemConfig['entity']}_LIST"))) {
                    unset($menuConfig[$i]);
                    continue;
                }

                $itemConfig['type'] = 'entity';
                $entityName = $itemConfig['entity'];

                if (!array_key_exists($entityName, $backendConfig['entities'])) {
                    throw new \RuntimeException(sprintf('The "%s" entity included in the "menu" option is not managed by EasyAdmin. The menu can only include any of these entities: %s. NOTE: If your menu worked before, this error may be caused by a change introduced by EasyAdmin 1.12.0 version. Check out https://github.com/javiereguiluz/EasyAdminBundle/releases/tag/v1.12.0 for more details.', $entityName, implode(', ', array_keys($backendConfig['entities']))));
                }

                if (!isset($itemConfig['label'])) {
                    $itemConfig['label'] = $backendConfig['entities'][$entityName]['label'];
                }

                if (!isset($itemConfig['params'])) {
                    $itemConfig['params'] = array();
                }
            } // 2nd level priority: if 'url' is defined, link to the given absolute/relative URL
            elseif (isset($itemConfig['url'])) {
                $itemConfig['type'] = 'link';

                if (!isset($itemConfig['label'])) {
                    throw new \RuntimeException(sprintf('The configuration of the menu item with "url = %s" must define the "label" option.', $itemConfig['url']));
                }
            } // 3rd level priority: if 'route' is defined, link to the path generated with the given route
            elseif (isset($itemConfig['route'])) {
                $itemConfig['type'] = 'route';

                if (!isset($itemConfig['label'])) {
                    throw new \RuntimeException(sprintf('The configuration of the menu item with "route = %s" must define the "label" option.', $itemConfig['route']));
                }

                if (!isset($itemConfig['params'])) {
                    $itemConfig['params'] = array();
                }
            }

            // 4th level priority: if 'label' is defined (and not the previous options),
            // this is a menu divider of a submenu title
            elseif (isset($itemConfig['label'])) {
                if (empty($itemConfig['children'])) {
                    // if the item doesn't define a submenu, this is a menu divider
                    $itemConfig['type'] = 'divider';
                    if ($i > 0 &&
                        array_key_exists('type', $menuConfig[$i - 1]) &&
                        $menuConfig[$i - 1]['type'] == 'divider'
                    )
                        unset($menuConfig[$i - 1]);
                } else {
                    // if the item defines a submenu, this is the title of that submenu
                    $itemConfig['type'] = 'empty';
                }
            } else {
                throw new \RuntimeException(sprintf('The configuration of the menu item in the position %d (being 0 the first item) must define at least one of these options: entity, url, route, label.', $i));
            }
            $menuConfig[$i] = $itemConfig;
        }

        return $menuConfig;
    }
}