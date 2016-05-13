<?php
namespace Forseti\PagesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\Translatable\Translatable;

/** @ORM\MappedSuperclass */
abstract class Page implements Translatable
{
    const ENTITY_ACTIONS = ['list', 'show', 'new', 'edit', 'delete', 'flag'];
    
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
     * @Gedmo\Translatable
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
     * @ORM\Column(type="text")
     */
    protected $content;
    
    /**
     * @ORM\Column(type="smallint")
     */
    protected $pageOrder;
    
    /**
     * @ORM\Column(type="string", length=30)
     */
    protected $template;
    
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
     *
     * @var unknown
     */
    protected $author; //FIXME
    
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
    
    public function __toString()
    {
        return (string) $this->getName();
    }
}
