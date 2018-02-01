<?php

namespace App\Controller\Admin;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Form;
use Swift_Mailer;
use Twig_Environment;

abstract class AbstractCreateController extends AbstractReadController
{
    protected $className;
    protected $formClassName;
    protected $addTemplate = 'add.html.twig';

    public function new(Request $request, EntityManagerInterface $em, SessionInterface $session, AuthorizationCheckerInterface $ac, TokenStorageInterface $tokenStorageInterface, Swift_Mailer $mailer, Twig_Environment $twig)
    {
        $obj = new $this->className();
        $form = $this->createForm($this->formClassName, $obj);
        $form = $this->preFormNew($form, $em);
        $form->handleRequest($request);
        $form = $this->postFormNew($form, $em, $ac);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->denyAccessUnlessGranted('create', $obj);
            $obj->setAutor($tokenStorageInterface->getToken()->getUser());
            $obj->setCreatedIn(new \DateTime());
            $em->persist($obj);
            $em->flush();
            $session->getFlashBag()->set('success', 'Criação de item realizada com sucesso!');
            $this->postNew($obj, $em, $session, $mailer, $twig);

            return $this->redirectToRoute($this->canonicalName.'_show', array(
                'params' => $obj->getId()
            ));
        }

        return $this->createView($this->addTemplate, [
            'form' => $form->createView(),
            'item' => $obj
        ]);
    }

    protected function preFormNew(Form $form, EntityManagerInterface $em) : Form
    {
        return $form;
    }

    protected function postFormNew(Form $form, EntityManagerInterface $em, AuthorizationCheckerInterface $ac) : Form
    {
        return $form;
    }

    protected function postNew($obj, EntityManagerInterface $em, SessionInterface $session, Swift_Mailer $mailer, Twig_Environment $twig)
    {
        return;
    }
}
