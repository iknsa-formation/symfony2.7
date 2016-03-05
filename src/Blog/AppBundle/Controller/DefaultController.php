<?php

namespace Blog\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('BlogAppBundle:Default:index.html.twig', array('name' => $name));
    }
}
