<?php

namespace Blog\PostBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Blog\PostBundle\Entity\Post;

class PostController extends Controller
{
    public function indexAction()
    {
        return $this->render('BlogPostBundle:post:index.html.twig');
    }

    public function newAction()
    {
        $entity = new Post;
        $form = $this->createFormBuilder($entity)

            ->add('title')
            ->add('summary')
            ->add('content')
            ->add('image')
            ->add('created_at')
            ->add('user')
            ->add('submit', 'submit', array('label' => 'Create'))

            ->getForm()
            ->createView();

        return $this->render('BlogPostBundle:post:new.html.twig', array(
            'form'   => $form,
        ));
    }
}
