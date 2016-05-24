<?php
/**
 * Created by PhpStorm.
 * User: forseti
 * Date: 24.05.16
 * Time: 16:53
 */

namespace Forseti\PagesBundle\Entity\Traits;


use Doctrine\ORM\Mapping as ORM;

trait Author
{
    /**
     * @ORM\ManyToOne(targetEntity="Forseti\AdminBundle\Entity\User")
     */
    protected $author;

    /**
     * Set author
     *
     * @param \Forseti\AdminBundle\Entity\User $author
     *
     * @return mixed
     */
    public function setAuthor(\Forseti\AdminBundle\Entity\User $author = null)
    {
        $this->author = $author;

        return $this;
    }

    /**
     * Get author
     *
     * @return \Forseti\AdminBundle\Entity\User
     */
    public function getAuthor()
    {
        return $this->author;
    }

}