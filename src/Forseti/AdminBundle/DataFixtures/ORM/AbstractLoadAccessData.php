<?php
namespace Forseti\AdminBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

abstract class AbstractLoadAccessData implements FixtureInterface
{
    protected $entities = [];
    
    abstract public function load(ObjectManager $manager);
    abstract public function getOrder();
    

    protected function register($obj)
    {
        $this->entities[] = $obj;
        return $obj;
    }
    
    protected function flush($manager)
    {
        foreach ($this->entities as $entity)
            $manager->persist($entity);
    
            $manager->flush();
    }
}