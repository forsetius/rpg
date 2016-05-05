<?php
namespace Forseti\AdminBundle\Security;

use Symfony\Component\Security\Core\Authorization\Voter\VoterInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\DependencyInjection\Container;

/**
 *
 * @author forseti
 *
 */
class GetQueryAccessVoter implements VoterInterface
{
    protected $request;
    protected $entity = null;
    protected $accessMap;
    
    public function __construct(RequestStack $request, Container $container)
    {
        
        $this->request = $request->getCurrentRequest();
        $this->accessMap = new AccessMap($container->getParameter('permissions'), $container->getParameter('role_hierarchy'));
        $entity = $this->request->query->get('entity', $container->getParameter('startingPage'));
        $this->entity = ['name'=>$entity, 'class'=>$container->getParameter('easyadmin.config')['entities'][$entity]['class']];
    }

    /**
     *
     * {@inheritDoc}
     *
     * @see \Symfony\Component\Security\Core\Authorization\Voter\VoterInterface::vote()
     */
    public function vote(TokenInterface $token, $object, array $attributes)
    {
        if ($this->request->attributes->get('_route') != 'admin')
            return VoterInterface::ACCESS_ABSTAIN;
        
        if ($token->getUsername() == 'anon.')
            return VoterInterface::ACCESS_DENIED;
        
        $rights = $this->accessMap->hasRights($token->getRoles(), $this->entity, $attributes[0]);
        switch ($rights) {
            case AccessMap::ACCESS_YES: return VoterInterface::ACCESS_GRANTED;
            case AccessMap::ACCESS_OWN:
                return VoterInterface::ACCESS_GRANTED;
            default: return VoterInterface::ACCESS_DENIED;
        }
    }
    
}
