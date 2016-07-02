<?php
namespace Forseti\AdminBundle\Entity;

use FOS\UserBundle\Model\Group as BaseGroup;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 * @ORM\Table(name="user_groups")
 */
class Group extends BaseGroup
{
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
    
    /**
     *
     * @ORM\Column(type="string", length=7)
     */
    protected $color;
    
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
     * Set color
     *
     * @param string $color
     *
     * @return Group
     */
    public function setColor($color)
    {
        $this->color = $color;

        return $this;
    }

    /**
     * Get color
     *
     * @return string
     */
    public function getColor()
    {
        return $this->color;
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
