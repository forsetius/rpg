<?php
namespace Forseti\PagesBundle\Entity\Traits;

use Doctrine\ORM\Mapping as ORM;

trait Licenced
{
    /**
     * @ORM\ManyToOne(targetEntity="Licence")
     */
    protected $licence;
    
    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $attribution;
    

    /**
     * Set licence
     *
     * @param string $licence
     *
     * @return mixed
     */
    public function setLicence($licence)
    {
        $this->licence = $licence;
    
        return $this;
    }
    
    /**
     * Get licence
     *
     * @return string
     */
    public function getLicence()
    {
        return $this->licence;
    }
    
    /**
     * Set attribution
     *
     * @param string $attribution
     *
     * @return mixed
     */
    public function setAttribution($attribution)
    {
        $this->attribution = $attribution;
    
        return $this;
    }
    
    /**
     * Get attribution
     *
     * @return string
     */
    public function getAttribution()
    {
        return $this->attribution;
    }
}
