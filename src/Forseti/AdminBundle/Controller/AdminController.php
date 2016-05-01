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
        $container = $this->container;
        global $container;
    
        $entity = $request->query->get('entity');
        $action = $request->query->get('action');
    
        if (! empty($entity)) {
            $this->denyAccessUnlessGranted($action, $entity);
            //             foreach (['Security'] as $concern)
                //                 $this->${"do$entity$concern"}($request);
        }
    
        return parent::indexAction($request);
    }
}