<?php

namespace Cinevi\AdminBundle\Controller;

use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class PublicController extends Controller
{
    public function publicAction()
    {
        return $this->render('CineviAdminBundle::public.html.twig');
    }

}
