<?php
/**
 * Created by PhpStorm.
 * User: forseti
 * Date: 24.05.16
 * Time: 18:24
 */

namespace Forseti\PagesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Forseti\PagesBundle\Entity\Traits\Author;
use Gedmo\Timestampable\Traits\TimestampableEntity;

/**
 * @ORM\Entity
 * @ORM\Table(name="pages_comment")
 */
class Comment
{
    use TimestampableEntity;
    use Author;

    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="Forseti\PagesBundle\Entity\Article", inversedBy="comments")
     */
    protected $article;

    /**
     * @ORM\Column(type="string")
     */
    protected $title;

    /**
     * @ORM\Column(type="text")
     */
    protected $content;

    /**
     * @ORM\Column(type="boolean")
     */
    protected $accepted;

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
     * Set title
     *
     * @param string $title
     *
     * @return Comment
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
     * @return Comment
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
     * Set accepted
     *
     * @param boolean $accepted
     *
     * @return Comment
     */
    public function setAccepted($accepted)
    {
        $this->accepted = $accepted;

        return $this;
    }

    /**
     * Get accepted
     *
     * @return boolean
     */
    public function getAccepted()
    {
        return $this->accepted;
    }

    /**
     * Set article
     *
     * @param \Forseti\PagesBundle\Entity\Article $article
     *
     * @return Comment
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
}
