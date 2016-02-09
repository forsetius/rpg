<?php
namespace AppBundle\Entity\Pages;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\Translatable\Translatable;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 * @ORM\Table(name="pages_page")
 */
class Page implements Translatable 
{       
    const SHOW_PAGE = 1;
    const SHOW_SECTION = 2;
    const SHOW_CHAPTER = 4;
    const SHOW_SITE = 128;
    
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    
    /**
     * TODO custom transliterator
     * TODO translated
     * @Gedmo\Slug(fields={"title"})
     * @ORM\Column(type="string", length=50, unique=true)
     */
    protected $name;
    
    /**
     * @Gedmo\Translatable
     * @ORM\Column(type="string", length=255)
     */
    protected $title;
    
    /**
     * @Gedmo\Translatable
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $lead;
    
    /**
     * @Gedmo\Translatable
     * @ORM\Column(type="text")
     */
    protected $content;
    
    /**
     * @ORM\ManyToOne(targetEntity="Page", inversedBy="children")
     * @ORM\JoinColumn(name="parent_id", referencedColumnName="id")
     * @ORM\Column(type="integer", nullable=true)
     */
    protected $parent;
    
    /**
     * @ORM\OneToMany(targetEntity="Page", mappedBy="parent")
     * @ORM\Column(type="integer", nullable=true)
     */
    protected $children;
    
    /**
     * @ORM\OneToOne(targetEntity="Page")
     * @ORM\JoinColumn(name="previous_id", referencedColumnName="id")
     * @ORM\Column(type="integer", nullable=true)
     */
    protected $previous;
    
    /**
     * @ORM\OneToOne(targetEntity="Page")
     * @ORM\JoinColumn(name="next_id", referencedColumnName="id")
     * @ORM\Column(type="integer", nullable=true)
     */
    protected $next;
    
    /**
     * @ORM\Column(type="smallint")
     */
    protected $level;
    
    /**
     * @ORM\Column(type="smallint")
     */
    protected $pageOrder;
    
    /**
     * @ORM\Column(type="string", length=255)
     */
    protected $breadcrumbs;
    
    /**
     * @ORM\Column(type="string", length=30)
     */
    protected $template = 'article.twig';
    
    /**
     * @ORM\Column(type="string", length=30, nullable=true)
     */
    protected $cssClass;
    
    /**
     * @Gedmo\Translatable
     * @ORM\Column(type="string", length=255)
     */
    protected $metaTitle;
    
    /**
     * @Gedmo\Translatable
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $metaDesc;
    
    /**
     * @Gedmo\Translatable
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $metaKeywords;
    
    /**
     * @ORM\Column(type="smallint")
     */
    protected $shown = 0;
    
    /**
     * @ORM\ManyToMany(targetEntity="Attachment")
     * @ORM\JoinTable(name="pages_attachments_join",
     *      joinColumns={@ORM\JoinColumn(name="attachment_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="page_id", referencedColumnName="id")}
     *      )
     */
    protected $attachments;
    
    /**
     * @ORM\ManyToMany(targetEntity="Image")
     * @ORM\JoinTable(name="pages_images_join",
     *      joinColumns={@ORM\JoinColumn(name="image_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="page_id", referencedColumnName="id")}
     *      )
     */
    protected $images;


    public function __construct()
    {
        $this->attachments = new ArrayCollection();
        $this->images = new ArrayCollection();
        $this->children = new ArrayCollection();
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
     * @return Page
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
     * Set title
     *
     * @param string $title
     *
     * @return Page
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set lead
     *
     * @param string $lead
     *
     * @return Page
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
     * Set content
     *
     * @param string $content
     *
     * @return Page
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Get content
     *
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Set parent
     *
     * @param integer $parent
     *
     * @return Page
     */
    public function setParent($parent)
    {
        $this->parent = $parent;

        return $this;
    }

    /**
     * Get parent
     *
     * @return integer
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * Set children
     *
     * @param integer $children
     *
     * @return Page
     */
    public function setChildren($children)
    {
        $this->children = $children;

        return $this;
    }

    /**
     * Get children
     *
     * @return integer
     */
    public function getChildren()
    {
        return $this->children;
    }

    /**
     * Set previous
     *
     * @param integer $previous
     *
     * @return Page
     */
    public function setPrevious($previous)
    {
        $this->previous = $previous;

        return $this;
    }

    /**
     * Get previous
     *
     * @return integer
     */
    public function getPrevious()
    {
        return $this->previous;
    }

    /**
     * Set next
     *
     * @param integer $next
     *
     * @return Page
     */
    public function setNext($next)
    {
        $this->next = $next;

        return $this;
    }

    /**
     * Get next
     *
     * @return integer
     */
    public function getNext()
    {
        return $this->next;
    }

    /**
     * Set level
     *
     * @param integer $level
     *
     * @return Page
     */
    public function setLevel($level)
    {
        $this->level = $level;

        return $this;
    }

    /**
     * Get level
     *
     * @return integer
     */
    public function getLevel()
    {
        return $this->level;
    }

    /**
     * Set pageOrder
     *
     * @param integer $pageOrder
     *
     * @return Page
     */
    public function setPageOrder($pageOrder)
    {
        $this->pageOrder = $pageOrder;

        return $this;
    }

    /**
     * Get pageOrder
     *
     * @return integer
     */
    public function getPageOrder()
    {
        return $this->pageOrder;
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

    /**
     * Set template
     *
     * @param string $template
     *
     * @return Page
     */
    public function setTemplate($template)
    {
        $this->template = $template;

        return $this;
    }

    /**
     * Get template
     *
     * @return string
     */
    public function getTemplate()
    {
        return $this->template;
    }

    /**
     * Set cssClass
     *
     * @param string $cssClass
     *
     * @return Page
     */
    public function setCssClass($cssClass)
    {
        $this->cssClass = $cssClass;

        return $this;
    }

    /**
     * Get cssClass
     *
     * @return string
     */
    public function getCssClass()
    {
        return $this->cssClass;
    }

    /**
     * Set metaTitle
     *
     * @param string $metaTitle
     *
     * @return Page
     */
    public function setMetaTitle($metaTitle)
    {
        $this->metaTitle = $metaTitle;

        return $this;
    }

    /**
     * Get metaTitle
     *
     * @return string
     */
    public function getMetaTitle()
    {
        return $this->metaTitle;
    }

    /**
     * Set metaDesc
     *
     * @param string $metaDesc
     *
     * @return Page
     */
    public function setMetaDesc($metaDesc)
    {
        $this->metaDesc = $metaDesc;

        return $this;
    }

    /**
     * Get metaDesc
     *
     * @return string
     */
    public function getMetaDesc()
    {
        return $this->metaDesc;
    }

    /**
     * Set metaKeywords
     *
     * @param string $metaKeywords
     *
     * @return Page
     */
    public function setMetaKeywords($metaKeywords)
    {
        $this->metaKeywords = $metaKeywords;

        return $this;
    }

    /**
     * Get metaKeywords
     *
     * @return string
     */
    public function getMetaKeywords()
    {
        return $this->metaKeywords;
    }

    /**
     * Set shown
     *
     * @param integer $shown
     *
     * @return Page
     */
    public function setShown($shown)
    {
        $this->shown = $shown;

        return $this;
    }

    /**
     * Get shown
     *
     * @return integer
     */
    public function getShown()
    {
        return $this->shown;
    }

    /**
     * Add attachment
     *
     * @param \AppBundle\Entity\Pages\Attachment $attachment
     *
     * @return Page
     */
    public function addAttachment(\AppBundle\Entity\Pages\Attachment $attachment)
    {
        $this->attachments[] = $attachment;

        return $this;
    }

    /**
     * Remove attachment
     *
     * @param \AppBundle\Entity\Pages\Attachment $attachment
     */
    public function removeAttachment(\AppBundle\Entity\Pages\Attachment $attachment)
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
     * @param \AppBundle\Entity\Pages\Image $image
     *
     * @return Page
     */
    public function addImage(\AppBundle\Entity\Pages\Image $image)
    {
        $this->images[] = $image;

        return $this;
    }

    /**
     * Remove image
     *
     * @param \AppBundle\Entity\Pages\Image $image
     */
    public function removeImage(\AppBundle\Entity\Pages\Image $image)
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
}
