<?php

namespace Blog\PostBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="post")
 */
class Post
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(name="title", type="string", length=255)
     */
    protected $title;

    /**
     * @ORM\Column(name="summary", type="string", length=255)
     */
    protected $summary;

    /**
     * @ORM\Column(name="content", type="text")
     */
    protected $content;

    /**
     * @ORM\Column(name="created_at", type="datetime")
     */
    protected $created_at;

    /**
     * @ORM\Column(name="image", type="string", length=255)
     */
    protected $image;

    /**
     * @ORM\Column(name="user", type="string", length=255)
     */
    protected $user;
}
