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
    /**
     * @ORM\Column(type="smallint")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    
    /**
     * @Gedmo\Translatable
     * @ORM\Column(type="string", length=50, unique=true)
     */
    protected $name;

    /**
     * @Gedmo\Translatable
     * @ORM\Column(type="string", length=255)
     */
    protected $longname;

    /**
     * @ORM\Column(type="string", length=255)
     */
    protected $url;
    
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
     * Set longname
     *
     * @param string $longname
     *
     * @return Licence
     */
    public function setLongname($longname)
    {
        $this->longname = $longname;

        return $this;
    }

    /**
     * Get longname
     *
     * @return string
     */
    public function getLongname()
    {
        return $this->longname;
    }
}
