<?php
namespace Forseti\AdminBundle\Entity\Traits;

use Doctrine\ORM\Mapping as ORM;

trait ColorTrait
{
    /**
     * @ORM\Column(type="string", length=7)
     */
    protected $color = '#ffffff';
    
    /**
     * Set color
     *
     * @param string $color
     *
     * @return City
     */
    public function setColor($color)
    {
        $this->color = $color;
    
        return $this;
    }
    
    /**
     * Get color
     *
     * @return string
     */
    public function getColor()
    {
        return $this->color;
    }
}