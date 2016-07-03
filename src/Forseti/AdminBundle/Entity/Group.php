<?php
namespace Forseti\AdminBundle\Entity;

use FOS\UserBundle\Model\Group as BaseGroup;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Forseti\AdminBundle\Entity\Traits\ColorTrait;

/**
 * @ORM\Entity
 * @ORM\Table(name="user_groups")
 */
class Group extends BaseGroup
{
    use ColorTrait;
    
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    
    /**
     * @ORM\ManyToMany(targetEntity="User", mappedBy="groups")
     */
    protected $users;
    
    public function __construct()
    {
        parent::__construct('');
        $this->users = new ArrayCollection();
        
    }
    
    public function __toString()
    {
        return (string) $this->getName();
    }

    /**
     * Add user
     *
     * @param \Forseti\AdminBundle\Entity\User $user
     *
     * @return Group
     */
    public function addUser(User $user)
    {
        $this->users[] = $user;
        $user->addGroup($this);
        return $this;
    }

    /**
     * Remove user
     *
     * @param \Forseti\AdminBundle\Entity\User $user
     */
    public function removeUser(User $user)
    {
        $this->users->removeElement($user);
        $user->removeGroup($this);
    }
    

    /**
     * Get users
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getUsers()
    {
        return $this->users;
    }
    
    /**
     * Add the array of roles
     * @param string[] $roles
     * @return Group
     */
    public function addRoles(array $roles)
    {
        foreach ($roles as $role) {
            $this->addRole($role);
        }
    
        return $this;
    }
}
