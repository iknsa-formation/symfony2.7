<?php

namespace Blog\PostBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Blog\PostBundle\Entity\Post;
use Symfony\Component\HttpFoundation\Request;
use Blog\PostBundle\Form\PostType;

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
            $entity->setUser($this->getUser());
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('blog_post_homepage'));
        }

        return $this->render('BlogPostBundle:post:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    public function createCreateForm(Post $entity)
    {
        $form = $this->createForm(new PostType, $entity, array(
                'action' => $this->generateUrl('blog_post_create'),
                'method' => 'POST'
            ));

        $form->add('submit', 'submit', array('label' => 'Create'));

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

    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BlogPostBundle:Post')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Post entity.');
        }

        return $this->render('BlogPostBundle:post:show.html.twig', array(
            'entity'      => $entity,
        ));
    }
}
