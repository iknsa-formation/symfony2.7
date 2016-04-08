<?php

namespace Blog\PostBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Blog\PostBundle\Entity\Post;
use Symfony\Component\HttpFoundation\Request;
use Blog\PostBundle\Form\PostType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Blog\CommentBundle\Entity\Comment;
use Blog\CommentBundle\Form\CommentType;

class PostController extends Controller
{
    public function indexApiAction()
    {
        $em = $this->getDoctrine()->getManager();

        $posts = $em->getRepository('BlogPostBundle:Post')->findLastThree();

        return new JsonResponse(array('posts' => $posts));
    }

    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $posts = $em->getRepository('BlogPostBundle:Post')->findLastThree();

        return $this->render('BlogPostBundle:post:index.html.twig', array(
            'posts' => $posts
        ));
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

        $comments = $em->getRepository('BlogCommentBundle:Comment')->findByPost($entity);

        $comment = new Comment;
        $commentForm = $this->createCommentCreateForm($comment, $id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Post entity.');
        }

        return $this->render('BlogPostBundle:post:show.html.twig', array(
            'entity'      => $entity,
            'comments'      => $comments,
            'commentForm' => $commentForm->createView()
        ));
    }

    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository("BlogPostBundle:Post")->find($id);

        if(!$entity) {
            throw $this->createNotFoundException('Unable to find Post Entity');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render("BlogPostBundle:post:edit.html.twig", array(
                'entity' => $entity,
                'edit_form' => $editForm->createView(),
                'delete_form' => $deleteForm->createView()
            ));
    }

    public function createEditForm(Post $entity)
    {
        $editForm = $this->createForm(new PostType(), $entity, array(
            'action' => $this->generateUrl('blog_post_update', array(
                'id' => $entity->getId()
            )),
            'method' => 'PUT'
        ));

        $editForm->add('submit', 'submit', array('label' => 'Update'));

        return $editForm;
    }

    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BlogPostBundle:Post')->find($id);

        if(!$entity) {
            throw $this->createNotFoundException('Unable to find Post entity');
        }

        $editForm = $this->createEditForm($entity);

        $editForm->handleRequest($request);

        if($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('blog_post_show', array('id' => $id)));
        }

        return $this->render('BlogPostBundle:post:edit.html.twig', array(
            'entity' => $entity,
            'edit_form' => $editForm->createView()
        ));
    }

    public function deleteAction(Request $request, $id)
    {
        $deleteForm = $this->createDeleteForm($id);
        
        $deleteForm->handleRequest($request);

        if($deleteForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('BlogPostBundle:Post')->find($id);

            if(!$entity) {
                throw $this->createNotFoundException('Unable to find post entity.');
            }

            $em->remove($entity);
            $em->flush();
    
        }
        return $this->redirect($this->generateUrl('blog_post_homepage'));
    }

    public function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('blog_post_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm();
    }

    public function createCommentCreateForm(Comment $entity, $id)
    {
        $form = $this->createForm(new CommentType, $entity, array(
                'action' => $this->generateUrl('blog_post_create_comment', array('id' => $id)),
                'method' => 'POST'
            ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    public function createCommentAction(Request $request, $id)
    {
        $entity = new Comment;

        $form = $this->createCommentCreateForm($entity, $id);

        $form->handleRequest($request);

        if ($form->isValid() && $this->getUser() !== null) {
            $em = $this->getDoctrine()->getManager();

            $entity->setPost($em->getRepository('BlogPostBundle:Post')->find($id));
            $entity->setUser($this->getUser());

            $em->persist($entity);
            $em->flush();
        }

        return $this->redirect($request->headers->get('referer'));
    }
}
