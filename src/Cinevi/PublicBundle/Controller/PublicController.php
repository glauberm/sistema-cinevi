<?php

namespace Cinevi\PublicBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Routing\ClassResourceInterface;
use FOS\RestBundle\View\ViewHandlerInterface;
use FOS\RestBundle\View\View;

class PublicController extends FOSRestController implements ClassResourceInterface
{
    public function publicAction()
    {
        $view = View::create();

        $view->setTemplate('CineviPublicBundle::public.html.twig');

        return $view;
    }

}
