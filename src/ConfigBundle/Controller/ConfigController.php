<?php

namespace ConfigBundle\Controller;

use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\Request;
use AdminBundle\Controller\AbstractCommonController;
use ConfigBundle\Form\ConfigType;

class ConfigController extends AbstractCommonController
{
    protected $canonicalName = 'config_config';
    protected $bundleName = 'ConfigBundle:Config';
    protected $repositoryName = 'ConfigBundle:Config';
    protected $showTemplate = 'show.html.twig';
    protected $editTemplate = 'edit.html.twig';
    protected $formClassName = ConfigType::class;

    public function showAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $obj = $em->getRepository($this->repositoryName)->getConfig();
        $this->denyAccessUnlessGranted('view', $obj);

        return $this->createView($this->showTemplate, [
            'item' => $obj
        ]);
    }

    public function editAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $obj = $em->getRepository($this->repositoryName)->getConfig();
        $this->denyAccessUnlessGranted('edit', $obj);
        $form = $this->createForm($this->formClassName, $obj);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->merge($obj);
            $em->flush();
            $this->get('session')->getFlashBag()->set('success', 'Configurações editadas com sucesso!');

            return $this->redirectToRoute($this->canonicalName.'_show');
        }

        return $this->createView($this->editTemplate, [
            'form' => $form->createView(),
            'item' => $obj
        ]);
    }
}
