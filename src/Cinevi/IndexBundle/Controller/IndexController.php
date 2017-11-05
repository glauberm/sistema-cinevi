<?php

namespace Cinevi\IndexBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Routing\ClassResourceInterface;
use FOS\RestBundle\View\ViewHandlerInterface;
use FOS\RestBundle\View\View;

class IndexController extends FOSRestController implements ClassResourceInterface
{
    public function indexAction()
    {
        $view = View::create();

        $view->setTemplate('CineviIndexBundle::index.html.twig');

        return $view;
    }
}
