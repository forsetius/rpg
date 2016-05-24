<?php
namespace Forseti\PagesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\SoftDeleteable\Traits\SoftDeleteableEntity;
use Gedmo\Translatable\Translatable;
use \Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 * @ORM\Table(name="pages_categories")
 */
class Category extends Page implements Translatable
{
    const ENTITY_ACTIONS = ['list', 'show', 'new', 'edit', 'delete', 'softdelete', 'flag'];

    use SoftDeleteableEntity;
    
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



    /**
     * Set breadcrumbs
     *
     * @param array $breadcrumbs
     *
     * @return Category
     */
    public function setBreadcrumbs($breadcrumbs)
    {
        $this->breadcrumbs = $breadcrumbs;

        return $this;
    }

    /**
     * Get breadcrumbs
     *
     * @return array
     */
    public function getBreadcrumbs()
    {
        return $this->breadcrumbs;
    }

    /**
     * Set parent
     *
     * @param \Forseti\PagesBundle\Entity\Category $parent
     *
     * @return Category
     */
    public function setParent(\Forseti\PagesBundle\Entity\Category $parent = null)
    {
        $this->parent = $parent;

        return $this;
    }

    /**
     * Get parent
     *
     * @return \Forseti\PagesBundle\Entity\Category
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * Add child
     *
     * @param \Forseti\PagesBundle\Entity\Category $child
     *
     * @return Category
     */
    public function addChild(\Forseti\PagesBundle\Entity\Category $child)
    {
        $this->children[] = $child;

        return $this;
    }

    /**
     * Remove child
     *
     * @param \Forseti\PagesBundle\Entity\Category $child
     */
    public function removeChild(\Forseti\PagesBundle\Entity\Category $child)
    {
        $this->children->removeElement($child);
    }

    /**
     * Get children
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getChildren()
    {
        return $this->children;
    }

    /**
     * Set frontImage
     *
     * @param \Forseti\PagesBundle\Entity\Image $frontImage
     *
     * @return Category
     */
    public function setFrontImage(\Forseti\PagesBundle\Entity\Image $frontImage = null)
    {
        $this->frontImage = $frontImage;

        return $this;
    }

    /**
     * Get frontImage
     *
     * @return \Forseti\PagesBundle\Entity\Image
     */
    public function getFrontImage()
    {
        return $this->frontImage;
    }

    /**
     * Add article
     *
     * @param \Forseti\PagesBundle\Entity\Article $article
     *
     * @return Category
     */
    public function addArticle(\Forseti\PagesBundle\Entity\Article $article)
    {
        $this->articles[] = $article;

        return $this;
    }

    /**
     * Remove article
     *
     * @param \Forseti\PagesBundle\Entity\Article $article
     */
    public function removeArticle(\Forseti\PagesBundle\Entity\Article $article)
    {
        $this->articles->removeElement($article);
    }

    /**
     * Get articles
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getArticles()
    {
        return $this->articles;
    }
}
