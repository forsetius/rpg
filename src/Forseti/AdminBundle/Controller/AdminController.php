<?php
namespace Forseti\AdminBundle\Controller;

use JavierEguiluz\Bundle\EasyAdminBundle\Controller\AdminController as BaseAdminController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Forseti\AdminBundle\Security\AccessMap;

class AdminController extends BaseAdminController
{
    use Traits\UserAdminTrait;
//    use GroupAdminTrait;
    

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
        foreach (['site_icon'] as $twigGlobal)
            $this->container->get('twig')->addGlobal("_$twigGlobal", $this->container->getParameter($twigGlobal));

        $r = $request->query;
        $entity = (count($r)>0) ? $r->get('entity') : $this->container->getParameter('startingPage');
        $action = (count($r)>0) ? $r->get('action') : 'list';
    
        $this->denyAccessUnlessGranted($action, $entity);
        $this->container->get('twig')->addGlobal("_rights", AccessMap::getAccessMap());
    
        return parent::indexAction($request);
    }
    
    protected function getMenuRights($menu)
    {
        $result = [];
        foreach ($menu as $menuItem) {
            if (\array_key_exists('children', $menuItem)) {
                $items = $this->getMenuRights($menuItem['children']);
                if (\count($items) > 0) {
                    $menuItem['children'] = $items;
                    $result[] = $menuItem;
                }
            } else if (\array_key_exists('entity', $menuItem)) {
                if ($this->isGranted('list', $menuItem['entity']))
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
}