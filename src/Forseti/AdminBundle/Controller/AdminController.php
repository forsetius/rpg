<?php
namespace Forseti\AdminBundle\Controller;

use JavierEguiluz\Bundle\EasyAdminBundle\Controller\AdminController as BaseAdminController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

class AdminController extends BaseAdminController
{
    use Traits\UserAdminTrait;
    use Traits\GroupAdminTrait;

    /**
     * @Route("/", name="admin")
     * @Route("/", name="easyadmin")
     *
     * @param Request $request
     *
     * @return RedirectResponse|Response
     */
    public function indexAction(Request $request)
    {
        $this->request = $request;
        $r = $this->request->query;
        if (count($r)==0) {
            $this->request->query->set('entity', $this->container->getParameter('startingPage'));
            $this->request->query->set('action', 'list');
        }

        if (! $this->hasNeededRole() )
            throw $this->createAccessDeniedException();

        foreach (['site_icon'] as $twigGlobal)
            $this->container->get('twig')->addGlobal("_$twigGlobal", $this->container->getParameter($twigGlobal));

        return parent::indexAction($request);
    }
    
    protected function getMenuForUser($menu)
    {
        // TODO
        $result = [];
        foreach ($menu as $menuItem) {
            if (\array_key_exists('children', $menuItem)) {
                $items = $this->getMenuForUser($menuItem['children']);
                if (\count($items) > 0) {
                    $menuItem['children'] = $items;
                    $result[] = $menuItem;
                }
            } else if (\array_key_exists('entity', $menuItem)) {
                if ($this->hasNeededRole($menuItem, 'list'))
                    $result[] = $menuItem;
            } else if (\array_key_exists('url', $menuItem)) {
                $result[] = $menuItem;
            } else {
                $menuItem['divider'] = null;
                if (\array_key_exists('divider', \array_pop($result))) {
                    \array_splice($result, -1, 1, $menuItem);
                } else {
                    $result[] = $menuItem;
                }
            }
        }
        
        
        return (\array_key_exists('divider', \array_pop($result))) ? \array_splice($result, -1) : $result;
    }

    public function hasNeededRole($entity = null, $action = null)
    {
        if ($entity === null) $entity = $this->request->query->get('entity');
        if ($action === null) $action = $this->request->query->get('action');
        return $this->get('security')->hasRole(strtoupper("ROLE_{$entity}_{$action}"));
    }
}