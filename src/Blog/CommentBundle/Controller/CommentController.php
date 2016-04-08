<?php

namespace Blog\CommentBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Blog\CommentBundle\Entity\Comment;
use Blog\CommentBundle\Form\CommentType;
use Symfony\Component\HttpFoundation\Request;

class CommentController extends Controller
{
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $comments = $em->getRepository('BlogCommentBundle:Comment')->findAll();

        return $this->render('BlogCommentBundle:comment:index.html.twig', array(
            'comments' => $comments
        ));
    }

    public function createAction(Request $request)
    {
        $entity = new Comment;

        $form = $this->createCreateForm($entity);

        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity->setUser($this->getUser());
            $em->persist($entity);
            $em->flush();

            return $this->redirect($request->headers->get('referer'));
        }

        return $this->render('BlogCommentBundle:comment:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    public function createCreateForm(Comment $entity)
    {
        $form = $this->createForm(new CommentType, $entity, array(
                'action' => $this->generateUrl('blog_comment_create'),
                'method' => 'POST'
            ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    public function newAction()
    {
        $entity = new Comment;

        $form = $this->createCreateForm($entity);

        return $this->render('BlogCommentBundle:comment:new.html.twig', array(
            'form'   => $form->createView(),
        ));
    }

    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BlogCommentBundle:Comment')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Comment entity.');
        }

        return $this->render('BlogCommentBundle:comment:show.html.twig', array(
            'entity'      => $entity,
        ));
    }

    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository("BlogCommentBundle:Comment")->find($id);

        if(!$entity) {
            throw $this->createNotFoundException('Unable to find Comment Entity');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render("BlogCommentBundle:comment:edit.html.twig", array(
                'entity' => $entity,
                'edit_form' => $editForm->createView(),
                'delete_form' => $deleteForm->createView()
            ));
    }

    public function createEditForm(Comment $entity)
    {
        $editForm = $this->createForm(new CommentType(), $entity, array(
            'action' => $this->generateUrl('blog_comment_update', array(
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

        $entity = $em->getRepository('BlogCommentBundle:Comment')->find($id);

        if(!$entity) {
            throw $this->createNotFoundException('Unable to find Comment entity');
        }

        $editForm = $this->createEditForm($entity);

        $editForm->handleRequest($request);

        if($editForm->isValid()) {
            $em->flush();

            return $this->render('BlogCommentBundle:comment:show.html.twig', array(
                'comment'      => $entity,
            ));
        }

        return $this->render('BlogCommentBundle:comment:edit.html.twig', array(
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
            $entity = $em->getRepository('BlogCommentBundle:Comment')->find($id);

            if(!$entity) {
                throw $this->createNotFoundException('Unable to find comment entity.');
            }

            $em->remove($entity);
            $em->flush();
    
        }
        return $this->redirect($this->generateUrl('blog_comment_homepage'));
    }

    public function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('blog_comment_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm();
    }
}
