<?php
namespace Forseti\PagesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Forseti\PagesBundle\Entity\Traits\Author;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\SoftDeleteable\Traits\SoftDeleteableEntity;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Gedmo\Translatable\Translatable;
use \Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 * @ORM\Table(name="pages_articles")
 */
class Article extends Page implements Translatable
{
    const ENTITY_ACTIONS = ['list', 'show', 'new', 'edit', 'delete', 'softdelete', 'flag', 'comment'];

    use Author;
    use SoftDeleteableEntity;
    use TimestampableEntity;

    /**
     * @Gedmo\Translatable
     * @ORM\Column(type="text", nullable=true)
     */
    protected $lead;

    /**
     * @ORM\ManyToMany(targetEntity="Attachment", inversedBy="articles")
     * @ORM\JoinTable(name="pages_articles_attachments_join")
     */
    protected $attachments;
    
    /**
     * @ORM\ManyToMany(targetEntity="Image", inversedBy="articles")
     * @ORM\JoinTable(name="pages_articles_images_join")
     */
    protected $images;
    
    /**
     * @ORM\ManyToOne(targetEntity="Category", inversedBy="articles")
     */
    protected $category;
    
    /**
     * @ORM\ManyToMany(targetEntity="Tag", inversedBy="articles")
     * @ORM\JoinTable(name="pages_articles_tags_join")
     */
    protected $tags;

    /**
     * @ORM\OneToMany(targetEntity="Comment", mappedBy="article")
     */
    protected $comments;
    
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->attachments = new ArrayCollection();
        $this->images = new ArrayCollection();
        $this->tags = new ArrayCollection();
        $this->comments = new ArrayCollection();
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
     * Set category
     *
     * @param \Forseti\PagesBundle\Entity\Category $category
     *
     * @return Article
     */
    public function setCategory(\Forseti\PagesBundle\Entity\Category $category = null)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * Get category
     *
     * @return \Forseti\PagesBundle\Entity\Category
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * Add tag
     *
     * @param \Forseti\PagesBundle\Entity\Tag $tag
     *
     * @return Article
     */
    public function addTag(\Forseti\PagesBundle\Entity\Tag $tag)
    {
        $this->tags[] = $tag;

        return $this;
    }

    /**
     * Remove tag
     *
     * @param \Forseti\PagesBundle\Entity\Tag $tag
     */
    public function removeTag(\Forseti\PagesBundle\Entity\Tag $tag)
    {
        $this->tags->removeElement($tag);
    }

    /**
     * Get tags
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getTags()
    {
        return $this->tags;
    }

    /**
     * Add comment
     *
     * @param \Forseti\PagesBundle\Entity\Comment $comment
     *
     * @return Article
     */
    public function addComment(\Forseti\PagesBundle\Entity\Comment $comment)
    {
        $this->comments[] = $comment;

        return $this;
    }

    /**
     * Remove comment
     *
     * @param \Forseti\PagesBundle\Entity\Comment $comment
     */
    public function removeComment(\Forseti\PagesBundle\Entity\Comment $comment)
    {
        $this->comments->removeElement($comment);
    }

    /**
     * Get comments
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getComments()
    {
        return $this->comments;
    }
}
