<?php

namespace Cinevi\AdminBundle\Controller;

use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\View\ViewHandlerInterface;
use FOS\RestBundle\View\View;

class IndexController extends FOSRestController
{
    protected $bundleName = "CineviAdminBundle:Index";
    protected $indexTemplate = 'index.html.twig';

    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $output = $this->getOutput($em);

        $view = View::create();
        $view
            ->setData($output)
            ->setStatusCode(200)
            ->setTemplate($this->bundleName.':'.$this->indexTemplate)
            ->setTemplateVar('output')
        ;

        return $view;
    }

    protected function getOutput(EntityManager $em)
    {
        $output = array(
            'mensagem' => "Navegue pelo menu para continuar usando o sistema."
        );

        return $output;
    }

}
