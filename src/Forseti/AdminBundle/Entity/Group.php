<?php
namespace Forseti\AdminBundle\Entity;

use FOS\UserBundle\Model\Group as BaseGroup;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="user_group")
 */
class Group extends BaseGroup
{
    const ENTITY_ACTIONS = ['list', 'show', 'add', 'edit', 'delete'];
    
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\generatedValue(strategy="AUTO")
     */
    protected $id;
    
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
     *
     * @ORM\Column(name="style", type="string", length=255)
     */
    protected $style;

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
    
    public function __construct()
    {
        parent::__construct('');
    }
}
