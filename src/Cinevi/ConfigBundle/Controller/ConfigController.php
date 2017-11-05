<?php

namespace Cinevi\ConfigBundle\Controller;

use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\Annotations\RouteResource;
use FOS\RestBundle\Routing\ClassResourceInterface;
use FOS\RestBundle\View\View;
use Cinevi\AdminBundle\Controller\RestfulCommonController;
use Cinevi\ConfigBundle\Form\Type\ConfigType;

/**
 * @RouteResource("Configuracoes", pluralize=false)
 */
class ConfigController extends RestfulCommonController implements ClassResourceInterface
{
    protected $bundleName = 'CineviConfigBundle:Config';

    public function getAction(Request $request)
    {
        $obj = $this->getConfig($this->getDoctrine()->getManager());

        $this->denyAccessUnlessGranted('view', $obj);

        return $this->getView($obj, 'show.html.twig', 'item');
    }

    public function editAction(Request $request)
    {
        $obj = $this->getConfig($this->getDoctrine()->getManager());

        $form = $this->getForm($obj, ConfigType::class, 'PUT', 'put_configuracoes');

        return $this->getView($form->createView(), 'edit.html.twig', 'form');
    }

    public function putAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $obj = $this->getConfig($em);

        $this->denyAccessUnlessGranted('edit', $obj);

        $form = $this->getForm($obj, ConfigType::class, 'PUT');

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->merge($obj);
            $em->flush();

            $this->get('session')->getFlashBag()->set('success', 'Configurações editadas com sucesso!');

            $view = View::createRouteRedirect('get_configuracoes');
        } else {
            $view = $this->getView($form->createView(), 'edit.html.twig', 'form');
        }

        return $view;
    }

    private function getConfig(EntityManager $em) {
        return $em->getRepository('CineviConfigBundle:Config')
            ->createQueryBuilder('config')
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
}
