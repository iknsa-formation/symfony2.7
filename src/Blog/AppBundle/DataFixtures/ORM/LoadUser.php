<?php

namespace Blog\AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class LoadUser extends AbstractFixture implements FixtureInterface, ContainerAwareInterface, OrderedFixtureInterface
{
    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * {@inheritDoc}
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->getContainer = $container;
    }

    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $userManager = $this->getContainer->get('fos_user.user_manager');

        $user = $userManager->createUser();
        $user->setUsername('user');
        $user->setEmail('user@iknsa.com');
        $user->setPlainPassword('user');
        $user->setEnabled(true);
        $user->setLastLogin(new \Datetime('NOW'));
        $user->setRoles(array('ROLE_USER'));
        $manager->persist($user);
        
        $admin = $userManager->createUser();
        $admin->setUsername('admin');
        $admin->setEmail('admin@iknsa.com');
        $admin->setPlainPassword('admin');
        $admin->setEnabled(true);
        $admin->setLastLogin(new \Datetime('NOW'));
        $admin->setRoles(array('ROLE_ADMIN', 'ROLE_USER'));
        $manager->persist($admin);

        $superAdmin = $userManager->createUser();
        $superAdmin->setUsername('superadmin');
        $superAdmin->setEmail('superadmin@iknsa.com');
        $superAdmin->setPlainPassword('superadmin');
        $superAdmin->setEnabled(true);
        $superAdmin->setLastLogin(new \Datetime('NOW'));
        $superAdmin->setRoles(array('ROLE_SUPER_ADMIN'));
        $manager->persist($superAdmin);

        $manager->flush();

        $this->addReference('admin-admin', $admin);
        $this->addReference('user-user', $user);
        $this->addReference('super_admin-super_admin', $superAdmin);
    }

    /**
     * {@inheritDoc}
     */
    public function getOrder()
    {
        return 100;
    }
}