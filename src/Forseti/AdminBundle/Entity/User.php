<?php
namespace Forseti\AdminBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\Common\Collections\ArrayCollection;
use Gedmo\SoftDeleteable\Traits\SoftDeleteableEntity;
use Gedmo\Timestampable\Traits\TimestampableEntity;

/**
 * @ORM\Entity
 * @ORM\Table(name="user_users")
 */
class User extends BaseUser
{
    const ENTITY_ACTIONS =  ['list', 'show', 'new', 'edit', 'softDelete', 'enable', 'disable', 'flag'];

    use TimestampableEntity;
    use SoftDeleteableEntity;

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
     * @ORM\Column(type="boolean")
     */
    protected $trustedComments = false;
    
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
        return (string) $this->getUsername();
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

    /**
     * Get credentials_expire_at
     *
     * @return \DateTime
     */
    public function getCredentialsExpireAt()
    {
        return $this->credentialsExpireAt;
    }
    
    public function setPlainPassword($password)
    {
        $this->plainPassword = $password;
        $this->updatedAt = new \DateTime();
    
        return $this;
    }

    /**
     * Set trustedComments
     *
     * @param boolean $trustedComments
     *
     * @return User
     */
    public function setTrustedComments($trustedComments)
    {
        $this->trustedComments = $trustedComments;

        return $this;
    }

    /**
     * Get trustedComments
     *
     * @return boolean
     */
    public function getTrustedComments()
    {
        return $this->trustedComments;
    }
}
