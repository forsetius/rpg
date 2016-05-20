<?php
namespace Forseti\PagesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\Translatable\Translatable;
use \Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 * @ORM\Table(name="pages_tags")
 */
class Tag extends Page implements Translatable
{
    const ENTITY_ACTIONS = ['list', 'show', 'new', 'edit', 'delete', 'softdelete', 'flag', 'comment'];

    /**
     * @ORM\Column(type="string", length=30, nullable=true)
     */
    protected $faIcon;
    
    /**
     * @ORM\Column(type="string", length=7, nullable=true)
     */
    protected $color;
    
    /**
     * @ORM\OneToMany(targetEntity="Article", mappedBy="category")
     */
    protected $articles;
    
    public function __construct()
    {
        $this->articles = new ArrayCollection();
    }
    

    /**
     * Set faIcon
     *
     * @param string $faIcon
     *
     * @return Tag
     */
    public function setFaIcon($faIcon)
    {
        $this->faIcon = $faIcon;

        return $this;
    }

    /**
     * Get faIcon
     *
     * @return string
     */
    public function getFaIcon()
    {
        return $this->faIcon;
    }

    /**
     * Set color
     *
     * @param string $color
     *
     * @return Tag
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
     * Add article
     *
     * @param \Forseti\PagesBundle\Entity\Article $article
     *
     * @return Tag
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
