<?php
namespace Forseti\PagesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\Translatable\Translatable;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 * @ORM\Table(name="pages_attachments")
 */
class Attachment extends Page implements Translatable
{
    /**
     * @ORM\Column(type="string", length=255, unique=true)
     */
    protected $filename;
    
    /**
     * @ORM\Column(type="integer")
     */
    protected $size;
    
    /**
     * @ORM\ManyToOne(targetEntity="Filetype")
     */
    protected $type;
    
    /**
     * @ORM\ManyToOne(targetEntity="Licence", inversedBy="attachments")
     * @ORM\Column(nullable=true)
     */
    protected $licence;
    
    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $attribution;
    
    /**
     * @ORM\ManyToMany(targetEntity="Article", inversedBy="attachments")
     * @ORM\JoinTable(name="articles_attachments_join")
     */
    protected $articles;
    
  
    public function __construct() {
        $this->articles = new ArrayCollection();
    }

    /**
     * Set filename
     *
     * @param string $filename
     *
     * @return Attachment
     */
    public function setFilename($filename)
    {
        $this->filename = $filename;

        return $this;
    }

    /**
     * Get filename
     *
     * @return string
     */
    public function getFilename()
    {
        return $this->filename;
    }

    /**
     * Set size
     *
     * @param integer $size
     *
     * @return Attachment
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

    /**
     * Set licence
     *
     * @param string $licence
     *
     * @return Attachment
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
     * @return Attachment
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
     * @return Attachment
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
     * @return Attachment
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
