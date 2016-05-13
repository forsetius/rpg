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
    const ENTITY_ACTIONS = ['list', 'show', 'new', 'edit', 'delete'];
    
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    
    /**
     * @ORM\ManyToMany(targetEntity="Forseti\AdminBundle\Entity\User", mappedBy="groups")
     */
    protected $users;
    
    /**
     *
     * @ORM\Column(name="style", type="string", length=255)
     */
    protected $style;
    
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
     * Set style
     *
     * @param string $style
     *
     * @return Group
     */
    public function setStyle($style)
    {
        $this->style = $style;

        return $this;
    }

    /**
     * Get style
     *
     * @return string
     */
    public function getStyle()
    {
        return $this->style;
    }

    /**
     * Add user
     *
     * @param \Forseti\AdminBundle\Entity\User $user
     *
     * @return Group
     */
    public function addUser(\Forseti\AdminBundle\Entity\User $user)
    {
        $this->users[] = $user;

        return $this;
    }

    /**
     * Remove user
     *
     * @param \Forseti\AdminBundle\Entity\User $user
     */
    public function removeUser(\Forseti\AdminBundle\Entity\User $user)
    {
        $this->users->removeElement($user);
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
}
