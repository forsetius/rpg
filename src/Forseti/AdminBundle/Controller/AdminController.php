<?php
namespace Forseti\AdminBundle\Controller;

use JavierEguiluz\Bundle\EasyAdminBundle\Controller\AdminController as BaseAdminController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

class AdminController extends BaseAdminController
{
    use UserAdminTrait;
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
//         dump($this->container->getParameter('easyadmin.config')['design']['menu']);die;
         $this->get('twig')->addGlobal('_menu', $this->getMenuRights($this->container->getParameter('easyadmin.config')['design']['menu']));
        
        if ($request->query->count() > 0) {
            $entity = $request->query->get('entity');
            $action = $request->query->get('action');
    
            $this->denyAccessUnlessGranted($action, $entity);
            //             foreach (['Security'] as $concern)
                //                 $this->${"do$entity$concern"}($request);
        }
    
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