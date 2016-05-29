<?php
namespace Forseti\PagesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Forseti\PagesBundle\Entity\Traits\Licenced;
use Gedmo\Translatable\Translatable;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 * @ORM\Table(name="pages_images")
 */
class Image extends Page implements Translatable
{
    use Licenced;

    /**
     * @ORM\Column(type="string", length=255)
     */
    protected $filenameMain;

    /**
     * @ORM\Column(type="string", length=255)
     */
    protected $filenameThumb;

    /**
     * @ORM\Column(type="integer")
     */
    protected $size;

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
     * Set filenameMain
     *
     * @param string $filenameMain
     *
     * @return Image
     */
    public function setFilenameMain($filenameMain)
    {
        $this->filenameMain = $filenameMain;

        return $this;
    }

    /**
     * Get filenameMain
     *
     * @return string
     */
    public function getFilenameMain()
    {
        return $this->filenameMain;
    }

    /**
     * Set filenameThumb
     *
     * @param string $filenameThumb
     *
     * @return Image
     */
    public function setFilenameThumb($filenameThumb)
    {
        $this->filenameThumb = $filenameThumb;

        return $this;
    }

    /**
     * Get filenameThumb
     *
     * @return string
     */
    public function getFilenameThumb()
    {
        return $this->filenameThumb;
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


    /**
     * Set size
     *
     * @param integer $size
     *
     * @return Image
     */
    public function setSize($size)
    {
        $this->size = $size;

        return $this;
    }

    /**
     * Get size
     *
     * @return integer
     */
    public function getSize()
    {
        return $this->size;
    }
}
