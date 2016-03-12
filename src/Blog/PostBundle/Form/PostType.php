<?php

namespace Blog\PostBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class PostType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('summary')
            ->add('content')
            ->add('image')
            ->add('created_at')
            ->add('user')
        ;
    }

    public function getName()
    {
        return 'blog_post';
    }
}