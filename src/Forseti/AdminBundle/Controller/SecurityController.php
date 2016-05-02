<?php
namespace Forseti\AdminBundle\Controller;

use FOS\UserBundle\Controller\SecurityController as FOSSecurityController;

class SecurityController extends FOSSecurityController
{
    /**
     * {@inheritDoc}
     * @see \FOS\UserBundle\Controller\SecurityController::renderLogin()
     */
    protected function renderLogin(array $data)
    {
        return $this->render('ForsetiAdminBundle::login.html.twig', $data);
    }
}
