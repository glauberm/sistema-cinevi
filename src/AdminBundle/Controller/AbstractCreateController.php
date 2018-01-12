<?php

namespace AdminBundle\Controller;

use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Form;

abstract class AbstractCreateController extends AbstractReadController
{
    protected $className;
    protected $formClassName;
    protected $addTemplate = 'add.html.twig';

    public function newAction(Request $request)
    {
        $obj = new $this->className();
        $this->denyAccessUnlessGranted('create', $obj);
        $em = $this->getDoctrine()->getManager();
        $form = $this->createForm($this->formClassName, $obj);
        $form = $this->preFormNew($form, $em);
        $form->handleRequest($request);
        $form = $this->postFormNew($form, $em);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($obj);
            $em->flush();
            $this->get('session')->getFlashBag()->set('success', 'Criação de item realizada com sucesso!');
            $this->postNew($obj, $em);

            return $this->redirectToRoute($this->canonicalName.'_index');
        }

        return $this->createView($this->addTemplate, [
            'form' => $form->createView(),
            'item' => $obj
        ]);
    }

    protected function preFormNew(Form $form, EntityManager $em) : Form
    {
        return $form;
    }

    protected function postFormNew(Form $form, EntityManager $em) : Form
    {
        return $form;
    }

    protected function postNew($obj, EntityManager $em)
    {
        return;
    }
}
