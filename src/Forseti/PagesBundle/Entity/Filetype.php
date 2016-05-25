<?php
namespace Forseti\PagesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\Translatable\Translatable;

/**
 * @ORM\Entity
 * @ORM\Table(name="pages_filetypes")
 */
class Filetype implements Translatable
{
    const ENTITY_ACTIONS = ['list', 'show', 'new', 'edit', 'delete'];
    
    /**
     * @ORM\Column(type="smallint")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    
    /**
     * @Gedmo\Translatable
     * @ORM\Column(type="string", length=30, unique=true)
     */
    protected $name;
    
    /**
     * @ORM\Column(type="string", length=30)
     */
    protected $icon;
    
    /**
     * @ORM\Column(type="string", length=7)
     */
    protected $color = '#000000';
    
    /**
     * @ORM\Column(type="string", length=30)
     */
    protected $contentType;

    /**
     * @ORM\Column(type="simple_array")
     */
    protected $extensions;

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->name;
    }
    
    /**
     * Get icon|color
     * @return string
     */
    public function getColoredIcon()
    {
        return $this->icon.'|'.$this->color;
    }
 

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Filetype
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set icon
     *
     * @param string $icon
     *
     * @return Filetype
     */
    public function setIcon($icon)
    {
        $this->icon = $icon;

        return $this;
    }

    /**
     * Get icon
     *
     * @return string
     */
    public function getIcon()
    {
        return $this->icon;
    }

    /**
     * Set color
     *
     * @param string $color
     *
     * @return Filetype
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
     * Set contentType
     *
     * @param string $contentType
     *
     * @return Filetype
     */
    public function setContentType($contentType)
    {
        $this->contentType = $contentType;

        return $this;
    }

    /**
     * Get contentType
     *
     * @return string
     */
    public function getContentType()
    {
        return $this->contentType;
    }

    /**
     * Set extensions
     *
     * @param array $extensions
     *
     * @return Filetype
     */
    public function setExtensions($extensions)
    {
        $this->extensions = $extensions;

        return $this;
    }

    /**
     * Get extensions
     *
     * @return array
     */
    public function getExtensions()
    {
        return $this->extensions;
    }
}
