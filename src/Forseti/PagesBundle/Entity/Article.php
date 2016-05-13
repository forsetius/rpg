<?php
namespace Forseti\PagesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\Translatable\Translatable;
use \Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 * @ORM\Table(name="pages_articles")
 */
class Article extends Page implements Translatable
{
    const ENTITY_ACTIONS = ['list', 'show', 'new', 'edit', 'delete', 'softdelete', 'flag', 'comment'];
    
    /**
     * @Gedmo\Translatable
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $lead;

    /**
     * @ORM\ManyToMany(targetEntity="Attachment", mappedBy="articles")
     */
    protected $attachments;
    
    /**
     * @ORM\ManyToMany(targetEntity="Image", mappedBy="articles")
     * @ORM\JoinTable(name="pages_images_join")
     */
    protected $images;
    
    /**
     * @ORM\OneToMany(targetEntity="Article", mappedBy="children")
     * @ORM\Column(nullable=true)
     */
    protected $parent;
    
    /**
     * @ORM\ManyToOne(targetEntity="Article", inversedBy="parent")
     * @ORM\Column(nullable=true)
     */
    protected $children;
    
    /**
     * @ORM\Column(type="string", length=255)
     */
    protected $breadcrumbs;
    
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->attachments = new ArrayCollection();
        $this->images = new ArrayCollection();
        $this->children = new ArrayCollection();
    }
    


    /**
     * Set lead
     *
     * @param string $lead
     *
     * @return Article
     */
    public function setLead($lead)
    {
        $this->lead = $lead;

        return $this;
    }

    /**
     * Get lead
     *
     * @return string
     */
    public function getLead()
    {
        return $this->lead;
    }

    /**
     * Set parent
     *
     * @param string $parent
     *
     * @return Article
     */
    public function setParent($parent)
    {
        $this->parent = $parent;

        return $this;
    }

    /**
     * Get parent
     *
     * @return string
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * Set children
     *
     * @param string $children
     *
     * @return Article
     */
    public function setChildren($children)
    {
        $this->children = $children;

        return $this;
    }

    /**
     * Get children
     *
     * @return string
     */
    public function getChildren()
    {
        return $this->children;
    }

    /**
     * Add attachment
     *
     * @param \Forseti\PagesBundle\Entity\Attachment $attachment
     *
     * @return Article
     */
    public function addAttachment(\Forseti\PagesBundle\Entity\Attachment $attachment)
    {
        $this->attachments[] = $attachment;

        return $this;
    }

    /**
     * Remove attachment
     *
     * @param \Forseti\PagesBundle\Entity\Attachment $attachment
     */
    public function removeAttachment(\Forseti\PagesBundle\Entity\Attachment $attachment)
    {
        $this->attachments->removeElement($attachment);
    }

    /**
     * Get attachments
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getAttachments()
    {
        return $this->attachments;
    }

    /**
     * Add image
     *
     * @param \Forseti\PagesBundle\Entity\Image $image
     *
     * @return Article
     */
    public function addImage(\Forseti\PagesBundle\Entity\Image $image)
    {
        $this->images[] = $image;

        return $this;
    }

    /**
     * Remove image
     *
     * @param \Forseti\PagesBundle\Entity\Image $image
     */
    public function removeImage(\Forseti\PagesBundle\Entity\Image $image)
    {
        $this->images->removeElement($image);
    }

    /**
     * Get images
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getImages()
    {
        return $this->images;
    }
    
    /**
     * Set breadcrumbs
     *
     * @param string $breadcrumbs
     *
     * @return Page
     */
    public function setBreadcrumbs($breadcrumbs)
    {
        $this->breadcrumbs = $breadcrumbs;
    
        return $this;
    }
    
    /**
     * Get breadcrumbs
     *
     * @return string
     */
    public function getBreadcrumbs()
    {
        return $this->breadcrumbs;
    }
}
