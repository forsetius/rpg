<?php
namespace AppBundle\Controller;

use JavierEguiluz\Bundle\EasyAdminBundle\Controller\AdminController as BaseAdminController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Controller\Admin;

class AdminController extends BaseAdminController
{
    use UserAdminTrait;
    use GroupAdminTrait;
    
    use ArticleAdminTrait;
    use AttachmentAdminTrait;
    use ImageAdminTrait;
    use FiletypeAdminTrait;
    
    /**
     * @Route("/", name="easyadmin")
     * @Route("/", name="admin")
     *
     * The 'admin' route is deprecated since version 1.8.0 and it will be removed in 2.0.
     *
     * @param Request $request
     *
     * @return RedirectResponse|Response
     */
    public function indexAction(Request $request)
    {
        $entity = $request->query->get('entity');
        $action = $request->query->get('action');

        if (! empty($entity)) {
            $this->denyAccessUnlessGranted($action, $entity);
//             foreach (['Security'] as $concern)
//                 $this->${"do$entity$concern"}($request);
        }
    }
    
    public function createNewUserEntity()
    {
        return $this->get('fos_user.user_manager')->createUser();
    }

    public function prePersistUserEntity($user)
    {
        $this->get('fos_user.user_manager')->updateUser($user, false);
    }
    
    public function preUpdateUserEntity($user)
    {
        $this->get('fos_user.user_manager')->updateUser($user, false);
    }
}