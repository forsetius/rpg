<?php
namespace Forseti\PagesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\Translatable\Translatable;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 * @ORM\Table(name="pages_licences")
 */
class Licence implements Translatable
{
    const ENTITY_ACTIONS = ['list', 'show', 'new', 'edit', 'delete'];
    
    /**
     * @ORM\Column(type="smallint")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    
    /**
     * @Gedmo\Translatable
     * @ORM\Column(type="string", length=255, unique=true)
     */
    protected $name;
    
    /**
     * @ORM\Column(type="string", length=255)
     */
    protected $url;
    
    /**
     * @ORM\OneToMany(targetEntity="Image", mappedBy="licence")
     */
    protected $images;
    
    /**
     * @ORM\OneToMany(targetEntity="Attachment", mappedBy="licence")
     */
    protected $attachments;
    
    public function __construct() {
        $this->attachments = new ArrayCollection();
        $this->images = new ArrayCollection();
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->name;
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
     * @return Licence
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
     * Set url
     *
     * @param string $url
     *
     * @return Licence
     */
    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * Get url
     *
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Add image
     *
     * @param \Forseti\PagesBundle\Entity\Image $image
     *
     * @return Licence
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
     * Add attachment
     *
     * @param \Forseti\PagesBundle\Entity\Attachment $attachment
     *
     * @return Licence
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
}
