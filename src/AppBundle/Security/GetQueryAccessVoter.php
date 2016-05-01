<?php
namespace AppBundle\Security;

use Symfony\Component\Security\Core\Authorization\Voter\VoterInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use AppBundle\Security\AccessMap;
use Symfony\Component\DependencyInjection\Container;

/**
 *
 * @author forseti
 *
 */
class GetQueryAccessVoter implements VoterInterface
{
    protected $requestStack;
    protected $entityKey;
    protected $actionKey;
    protected $accessMap;
    
    public function __construct(RequestStack $request, Container $container, $entity, $action)
    {
        $this->requestStack = $request;
        $this->entityKey = $entity;
        $this->actionKey = $action;
        $this->accessMap = new AccessMap($container->getParameter('permissions'), $container->getParameter('security.role_hierarchy'));
    }

    /**
     *
     * {@inheritDoc}
     *
     * @see \Symfony\Component\Security\Core\Authorization\Voter\VoterInterface::vote()
     */
    public function vote(TokenInterface $token, $object, array $attributes)
    {
        $entity = (is_object($object)) ? substr($classname = get_class($object), strrpos($classname, '\\') + 1) : $object;
        
        $rights = $this->accessMap->hasRights($token->getRoles(), $entity, $attributes[0]);
        switch ($rights) {
            case AccessMap::ACCESS_YES: return VoterInterface::ACCESS_GRANTED;
            case AccessMap::ACCESS_OWN:
                return VoterInterface::ACCESS_GRANTED;
            default: return VoterInterface::ACCESS_DENIED;
        }
    }
    public function supports($attribute)
    {
        return ($attribute == 'action');
    }
    
    
    public function supportsClass($class)
    {
        return (\method_exists($class, 'getEntityActions'));
    }
}
