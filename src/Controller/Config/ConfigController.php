<?php

namespace App\Controller\Config;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpFoundation\Request;
use App\Controller\Admin\AbstractCommonController;
use App\Entity\Config;
use App\Form\Config\ConfigType;

class ConfigController extends AbstractCommonController
{
    protected $canonicalName = 'config';
    protected $templateDir = 'config';
    protected $repositoryName = Config::class;
    protected $showTemplate = 'show.html.twig';
    protected $editTemplate = 'edit.html.twig';
    protected $formClassName = ConfigType::class;

    public function show(Request $request, EntityManagerInterface $em)
    {
        $obj = $em->getRepository($this->repositoryName)->getConfig();
        $this->denyAccessUnlessGranted('view', $obj);

        return $this->createView($this->showTemplate, [
            'item' => $obj
        ]);
    }

    public function edit(Request $request, EntityManagerInterface $em, SessionInterface $session)
    {
        $obj = $em->getRepository($this->repositoryName)->getConfig();
        $form = $this->createForm($this->formClassName, $obj);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->denyAccessUnlessGranted('edit', $obj);
            $em->merge($obj);
            $em->flush();
            $session->getFlashBag()->set('success', 'Configurações editadas com sucesso!');

            return $this->redirectToRoute($this->canonicalName.'_show');
        }

        return $this->createView($this->editTemplate, [
            'form' => $form->createView(),
            'item' => $obj
        ]);
    }
}
