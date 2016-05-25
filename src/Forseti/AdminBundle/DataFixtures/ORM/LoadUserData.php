<?php
namespace Forseti\AdminBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Forseti\AdminBundle\Entity\Group;
use Forseti\AdminBundle\Entity\User;

class LoadUserData implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
        // load Groups
        
        $groupSuperAdmin = new Group();
        $groupSuperAdmin->setName('SuperAdmin');
        $groupSuperAdmin->setStyle('danger');
        $groupSuperAdmin->setRoles(['ROLE_SUPER_ADMIN', 'ROLE_USER_ALL', 'ROLE_GROUP_ALL']);
        $manager->persist($groupSuperAdmin);

        $groupVisitor = new Group();
        $groupVisitor->setName('Visitor');
        $groupVisitor->setStyle('info');
        $groupVisitor->setRoles(['ROLE_USER_SEE', 'ROLE_GROUP_SEE']);
        $manager->persist($groupVisitor);
    
        // load Users
        
        $userSuperAdmin = new User();
        $userSuperAdmin->setUsername('root');
        $userSuperAdmin->setPassword('daikomio');
        $userSuperAdmin->addGroup($groupSuperAdmin);
        $manager->persist($userSuperAdmin);

        $userCmsAdmin = new User();
        $userCmsAdmin->setUsername('admin');
        $userCmsAdmin->setPassword('daikomio');
        // Groups added later - in other bundles
        $manager->persist($userCmsAdmin);

        $userVisitor = new User();
        $userVisitor->setUsername('visitor');
        $userVisitor->setPassword('password');
        $userVisitor->addGroup($groupVisitor);
        $manager->persist($userVisitor);

        $manager->flush();
    }
}
