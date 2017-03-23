<?php

namespace Cinevi\AdminBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class IndexController extends Controller
{
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $configuration = $em->getRepository('CineviAdminBundle:Configuration')
            ->createQueryBuilder('config')
            ->getQuery()
            ->getOneOrNullResult()
        ;

        return $this->render('CineviAdminBundle:Index:index.html.twig', array(
            'configuration' => $configuration,
        ));
    }
}
