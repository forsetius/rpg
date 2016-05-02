<?php
namespace AppBundle\Entity\Pages;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\Translatable\Translatable;
use AppBundle\Entity\Pages\Page;
use \Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 * @ORM\Table(name="pages_article")
 */
class Article extends Page implements Translatable
{
    const ENTITY_ACTIONS = ['list', 'show', 'new', 'edit', 'delete', 'flag', 'comment'];
    
    /**
     * @Gedmo\Translatable
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $lead;

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
    
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->attachments = new ArrayCollection();
        $this->images = new ArrayCollection();
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
     * @param \AppBundle\Entity\Pages\Attachment $attachment
     *
     * @return Article
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
     * @return Article
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
