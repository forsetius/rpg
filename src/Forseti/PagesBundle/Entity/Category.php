<?php
namespace Forseti\PagesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\Translatable\Translatable;
use \Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 * @ORM\Table(name="pages_categories")
 */
class Category extends Page implements Translatable
{
    const ENTITY_ACTIONS = ['list', 'show', 'new', 'edit', 'delete', 'softdelete', 'flag'];

    /**
     * @ORM\ManyToOne(targetEntity="Category", inversedBy="children")
     * @ORM\JoinColumn(name="parent", referencedColumnName="id")
     *
     */
    protected $parent;
    
    /**
     * @ORM\OneToMany(targetEntity="Category", mappedBy="parent")
     */
    protected $children;
    
    /**
     * @ORM\Column(type="simple_array")
     */
    protected $breadcrumbs;
    
    /**
     * @ORM\ManyToOne(targetEntity="Image")
     */
    protected $frontImage;
    
    /**
     * @ORM\OneToMany(targetEntity="Article", mappedBy="category")
     */
    protected $articles;
    
    public function __construct()
    {
        $this->children = new ArrayCollection();
        $this->articles = new ArrayCollection();
    }


}
