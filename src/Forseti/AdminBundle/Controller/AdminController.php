<?php
namespace Forseti\AdminBundle\Controller;

use JavierEguiluz\Bundle\EasyAdminBundle\Controller\AdminController as BaseAdminController;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
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

    public function hasNeededRole($entity = null, $action = null)
    {
        if ($entity === null) $entity = $this->request->query->get('entity');
        if ($action === null) $action = $this->request->query->get('action');
        return $this->get('security')->hasRole(strtoupper("ROLE_{$entity}_{$action}"));
    }
}