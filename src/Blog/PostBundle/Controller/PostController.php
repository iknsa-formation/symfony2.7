<?php

namespace Blog\PostBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Blog\PostBundle\Entity\Post;
use Symfony\Component\HttpFoundation\Request;

class PostController extends Controller
{
    public function indexAction()
    {
        return $this->render('BlogPostBundle:post:index.html.twig');
    }

    public function createAction(Request $request)
    {
        $entity = new Post;

        $form = $this->createCreateForm($entity);

        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('blog_post_new'));
        }

        return $this->render('BlogPostBundle:post:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    public function createCreateForm($entity)
    {
        $form = $this->createFormBuilder($entity)

            ->setAction($this->generateUrl('blog_post_create'))
            ->setMethod('POST')
            ->add('title')
            ->add('summary')
            ->add('content')
            ->add('image')
            ->add('created_at')
            ->add('user')
            ->add('submit', 'submit', array('label' => 'Create'))

            ->getForm();

            return $form;
    }

    public function newAction()
    {
        $entity = new Post;

        $form = $this->createCreateForm($entity);

        return $this->render('BlogPostBundle:post:new.html.twig', array(
            'form'   => $form->createView(),
        ));
    }
}
