<?php
namespace Forseti\PagesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Translatable\Translatable;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 * @ORM\Table(name="pages_images")
 */
class Image extends Page implements Translatable
{
    use Traits\Licenced;
    
    /**
     * @ORM\Column(type="simple_array")
     */
    protected $filenames;
    
    /**
     * @ORM\ManyToOne(targetEntity="Filetype")
     */
    protected $type;
    
    /**
     * @ORM\ManyToMany(targetEntity="Article", mappedBy="images")
     */
    protected $articles;
    
    public function __construct() {
        $this->articles = new ArrayCollection();
    }

 

    /**
     * Set filenames
     *
     * @param array $filenames
     *
     * @return Image
     */
    public function setFilenames($filenames)
    {
        $this->filenames = $filenames;

        return $this;
    }

    /**
     * Get filenames
     *
     * @return array
     */
    public function getFilenames()
    {
        return $this->filenames;
    }
    
    /**
     * Set type
     *
     * @param \Forseti\PagesBundle\Entity\Filetype $type
     *
     * @return Image
     */
    public function setType(\Forseti\PagesBundle\Entity\Filetype $type = null)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return \Forseti\PagesBundle\Entity\Filetype
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Add article
     *
     * @param \Forseti\PagesBundle\Entity\Article $article
     *
     * @return Image
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
