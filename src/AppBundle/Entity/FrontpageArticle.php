<?php
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="app_frontpage_articles")
 */
class FrontpageArticle
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\OneToOne(targetEntity="Forseti\PagesBundle\Entity\Article")
     */
    protected $article;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    protected $showFrom;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    protected $showTo;

    /**
     * @ORM\ManyToOne(targetEntity="Forseti\PagesBundle\Entity\Image")
     */
    protected $image;

    /**
     * @ORM\Column(type="string")
     */
    protected $title;

    /**
     * @ORM\Column(type="text")
     */
    protected $content;

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
     * Set showFrom
     *
     * @param \DateTime $showFrom
     *
     * @return FrontpageArticle
     */
    public function setShowFrom($showFrom)
    {
        $this->showFrom = $showFrom;

        return $this;
    }

    /**
     * Get showFrom
     *
     * @return \DateTime
     */
    public function getShowFrom()
    {
        return $this->showFrom;
    }

    /**
     * Set showTo
     *
     * @param \DateTime $showTo
     *
     * @return FrontpageArticle
     */
    public function setShowTo($showTo)
    {
        $this->showTo = $showTo;

        return $this;
    }

    /**
     * Get showTo
     *
     * @return \DateTime
     */
    public function getShowTo()
    {
        return $this->showTo;
    }

    /**
     * Set title
     *
     * @param string $title
     *
     * @return FrontpageArticle
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
     * @return FrontpageArticle
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
     * Set article
     *
     * @param \Forseti\PagesBundle\Entity\Article $article
     *
     * @return FrontpageArticle
     */
    public function setArticle(\Forseti\PagesBundle\Entity\Article $article = null)
    {
        $this->article = $article;

        return $this;
    }

    /**
     * Get article
     *
     * @return \Forseti\PagesBundle\Entity\Article
     */
    public function getArticle()
    {
        return $this->article;
    }

    /**
     * Set image
     *
     * @param \Forseti\PagesBundle\Entity\Image $image
     *
     * @return FrontpageArticle
     */
    public function setImage(\Forseti\PagesBundle\Entity\Image $image = null)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get image
     *
     * @return \Forseti\PagesBundle\Entity\Image
     */
    public function getImage()
    {
        return $this->image;
    }
}
