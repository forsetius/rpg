<?php
namespace Forseti\PagesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Forseti\PagesBundle\Entity\Traits\Licenced;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\Translatable\Translatable;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 * @ORM\Table(name="pages_attachments")
 */
class Attachment extends Page implements Translatable
{
    use Licenced;

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
     * @ORM\ManyToMany(targetEntity="Article", mappedBy="attachments")
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
     * Set type
     *
     * @param \Forseti\PagesBundle\Entity\Filetype $type
     *
     * @return Attachment
     */
    public function setType(Filetype $type = null)
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
        $article->addAttachment($this);

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
        $article->removeAttachment($this);
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
