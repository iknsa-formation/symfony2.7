<?php

namespace Blog\PostBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Blog\PostBundle\Entity\Post;

class LoadPost extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $postAdminLorem = new Post;
        $postAdminLorem->setTitle('Lorem');
        $postAdminLorem->setSummary('Ipsum dolor...');
        $postAdminLorem->setContent('Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
                                        tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
                                        quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
                                        consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
                                        cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
                                        proident, sunt in culpa qui officia deserunt mollit anim id est laborum.'
                                    );
        $postAdminLorem->setCreatedAt(new \Datetime);
        $postAdminLorem->setUser($this->getReference('admin-admin'));
        $postAdminLorem->setExtension('jpeg');
        $manager->persist($postAdminLorem);

        $postAdminOther = new Post;
        $postAdminOther->setTitle('Other');
        $postAdminOther->setSummary('Not a lorem text');
        $postAdminOther->setContent('Since its not a lorem, its very short');
        $postAdminOther->setCreatedAt(new \Datetime);
        $postAdminOther->setUser($this->getReference('admin-admin'));
        $postAdminOther->setExtension('jpeg');
        $manager->persist($postAdminOther);

        $postUserLorem = new Post;
        $postUserLorem->setTitle('User\'s Lorem');
        $postUserLorem->setSummary('Lorem ipsum...');
        $postUserLorem->setContent('Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
                                        tempoent, sunt in culpa qui officia deserunt mollit anim id est laborum.'
                                    );
        $postUserLorem->setCreatedAt(new \Datetime);
        $postUserLorem->setUser($this->getReference('admin-admin'));
        $postUserLorem->setExtension('jpeg');
        $manager->persist($postUserLorem);

        $manager->flush();

        $this->addReference('post-admin-lorem', $postAdminLorem);
        $this->addReference('post-admin-other', $postAdminOther);
        $this->addReference('post-user-other', $postUserLorem);
    }

    /**
     * {@inheritDoc}
     */
    public function getOrder()
    {
        return 200;
    }
}