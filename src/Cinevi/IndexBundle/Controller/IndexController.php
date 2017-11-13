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
        return $this->redirect($this->generateUrl('fos_user_profile_show'));
    }
}
