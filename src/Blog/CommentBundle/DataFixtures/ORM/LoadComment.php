<?php

namespace Blog\CommentBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Blog\CommentBundle\Entity\Comment;

class LoadComment extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $commentAdminLorem = new Comment;
        $commentAdminLorem->setContent('My new wonderful comment');
        $commentAdminLorem->setUser($this->getReference('admin-admin'));
        $commentAdminLorem->setCreatedAt(new \Datetime);
        $commentAdminLorem->setPost($this->getReference('post-admin-lorem'));
        $manager->persist($commentAdminLorem);

        $commentAdminAgain = new Comment;
        $commentAdminAgain->setContent('I commented this post again as it was too wonderful');
        $commentAdminAgain->setUser($this->getReference('admin-admin'));
        $commentAdminAgain->setCreatedAt(new \Datetime);
        $commentAdminAgain->setPost($this->getReference('post-admin-lorem'));
        $manager->persist($commentAdminAgain);

        $commentAdminWow = new Comment;
        $commentAdminWow->setContent('Wow this post is just too great.');
        $commentAdminWow->setUser($this->getReference('admin-admin'));
        $commentAdminWow->setCreatedAt(new \Datetime);
        $commentAdminWow->setPost($this->getReference('post-admin-lorem'));
        $manager->persist($commentAdminWow);

        $commentUserFirst = new Comment;
        $commentUserFirst->setContent('<b>This post is just bad</b>');
        $commentUserFirst->setUser($this->getReference('user-user'));
        $commentUserFirst->setCreatedAt(new \Datetime);
        $commentUserFirst->setPost($this->getReference('post-admin-lorem'));
        $manager->persist($commentUserFirst);

        $manager->flush();

        $this->addReference('comment-admin-lorem', $commentAdminLorem);
        $this->addReference('comment-admin-again', $commentAdminAgain);
        $this->addReference('comment-admin-wow', $commentAdminWow);
        $this->addReference('comment-user-other', $commentUserFirst);
    }

    /**
     * {@inheritDoc}
     */
    public function getOrder()
    {
        return 300;
    }
}