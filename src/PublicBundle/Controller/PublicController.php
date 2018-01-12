<?php

namespace PublicBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class PublicController extends Controller
{
    public function publicAction()
    {
        return $this->render('PublicBundle::public.html.twig');
    }

}
