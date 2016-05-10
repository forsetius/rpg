<?php
namespace Forseti\AdminBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 * @ORM\Table(name="user_users")
 */
class User extends BaseUser
{
    const ENTITY_ACTIONS =  ['list', 'show', 'new', 'edit', 'adminEdit', 'softDelete', 'disable', 'flag', 'message'];


    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     *
     */
    protected $id;
    
    /**
     * @ORM\ManyToMany(targetEntity="Forseti\AdminBundle\Entity\Group", inversedBy="users")
     * @ORM\JoinTable(name="user_group_join")
     */
    protected $groups;
    
    /**
     * @var \DateTime
     *
     * @Gedmo\Timestampable(on="update")
     *
     * @ORM\Column(name="updated_at", type="datetime")
     */
    protected $updatedAt;
    
    /**
     * @var \DateTime
     *
     * @Gedmo\Timestampable(on="create")
     *
     * @ORM\Column(name="created_at", type="datetime")
     */
    protected $createdAt;
    
    public function __construct()
    {
        parent::__construct();
        $this->roles = ['ROLE_USER'];
//         $this->credentialsExpired = true;
        $this->enabled = true;
        $this->groups = new ArrayCollection();
    }
    
    public function __toString()
    {
        return (string) $this->getName();
    }

    /**
     * Get id
     *
     * @return integer $id
     */
    public function getId()
    {
        return $this->id;
    }
    
    
    public function getExpiresAt()
    {
        return $this->expiresAt;
    }
    
    /**
     * Get credentials_expire_at
     *
     * @return \DateTime
     */
    public function getCredentialsExpireAt()
    {
        return $this->credentialsExpireAt;
    }

    /**
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     *
     * @return User
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;
    
        return $this;
    }
    
    /**
     * Get updatedAt
     *
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }
    
    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return User
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
    
        return $this;
    }
    
    /**
     * Get createdAt
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }
    
    
    public function setPlainPassword($password)
    {
        $this->plainPassword = $password;
        $this->updatedAt = new \DateTime();
    
        return $this;
    }
}
