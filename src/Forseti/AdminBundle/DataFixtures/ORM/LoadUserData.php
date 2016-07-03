<?php
namespace Forseti\AdminBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Forseti\AdminBundle\Entity\Group;
use Forseti\AdminBundle\Entity\User;

class LoadUserData extends AbstractLoadAccessData implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
        // load Groups
        
        $groupSuperAdmin = $this->register(new Group());
        $groupSuperAdmin->setName('SuperAdmin');
        $groupSuperAdmin->setColor('#ff0000');
        $groupSuperAdmin->setRoles(['ROLE_SUPER_ADMIN', 'ROLE_USER_ALL', 'ROLE_GROUP_ALL']);

        $groupVisitor = $this->register(new Group());
        $groupVisitor->setName('Visitor');
        $groupVisitor->setColor('#999999');
        $groupVisitor->setRoles(['ROLE_USER_SEE', 'ROLE_GROUP_SEE']);
    
        // load Users
        
        $userSuperAdmin = $this->register(new User());
        $userSuperAdmin->setUsername('root');
        $userSuperAdmin->setPlainPassword('daikomio');
        $userSuperAdmin->setEmail('forseti.pl@gmail.com');
        $userSuperAdmin->setColor('#ff0000');
        $userSuperAdmin->addGroup($groupSuperAdmin);

        $userVisitor = $this->register(new User());
        $userVisitor->setUsername('visitor');
        $userVisitor->setPlainPassword('password');
        $userVisitor->setEmail('example@gmail.com');
        $userVisitor->setColor('#992299');
        $userVisitor->addGroup($groupVisitor);

        $this->flush($manager);
    }
    
    public function getOrder()
    {
        return 1;
    }
}
