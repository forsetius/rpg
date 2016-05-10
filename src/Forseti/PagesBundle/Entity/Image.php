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
    /**
     * @ORM\Column(type="simple_array")
     */
    protected $filenames;
    
    /**
     * @ORM\ManyToOne(targetEntity="Filetype")
     */
    protected $type;
    
    /**
     * @ORM\ManyToOne(targetEntity="Licence", inversedBy="images")
     * @ORM\Column(nullable=true)
     */
    protected $licence;
    
    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $attribution;
    
    /**
     * @ORM\ManyToMany(targetEntity="Article", inversedBy="images")
     * @ORM\JoinTable(name="articles_images_join")
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
     * Set licence
     *
     * @param string $licence
     *
     * @return Image
     */
    public function setLicence($licence)
    {
        $this->licence = $licence;

        return $this;
    }

    /**
     * Get licence
     *
     * @return string
     */
    public function getLicence()
    {
        return $this->licence;
    }

    /**
     * Set attribution
     *
     * @param string $attribution
     *
     * @return Image
     */
    public function setAttribution($attribution)
    {
        $this->attribution = $attribution;

        return $this;
    }

    /**
     * Get attribution
     *
     * @return string
     */
    public function getAttribution()
    {
        return $this->attribution;
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
