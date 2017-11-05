<?php

namespace Cinevi\AdminBundle\Controller;

use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Form;
use FOS\RestBundle\Routing\ClassResourceInterface;
use FOS\RestBundle\View\View;

abstract class RestfulCreateController extends RestfulReadController implements ClassResourceInterface
{
    protected $className;
    protected $routeSuffix;
    protected $formClassName;
    protected $addTemplate = 'add.html.twig';

    public function newAction()
    {
        $em = $this->getDoctrine()->getManager();

        $obj = new $this->className();

        $form = $this->getForm($obj, $this->formClassName, 'POST', 'post_'.$this->routeSuffix);

        $view = $this->newReturn($em, $form, ['item' => $obj]);

        return $view;
    }

    public function postAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $obj = new $this->className();

        $this->denyAccessUnlessGranted('create', $obj);

        $form = $this->getForm($obj, $this->formClassName, 'POST');

        $form = $this->preFormPost($form, $em);

        $form->handleRequest($request);

        $form = $this->postFormPost($form, $em);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($obj);
            $em->flush();

            $this->get('session')->getFlashBag()->set('success', 'Criação de item realizada com sucesso!');

            $this->postPost($obj, $em);

            $view = View::createRouteRedirect('cget_'.$this->routeSuffix);
        } else {
            $view = $this->newReturn($em, $form, ['item' => $obj]);
        }

        return $view;
    }

    private function newReturn(EntityManager $em, $form, $return)
    {
        $return = $this->preNew($em, $return);

        $view = $this->getView($form->createView(), $this->addTemplate, 'form', $return);

        return $view;
    }

    protected function preNew(EntityManager $em, array $return = []) : array
    {
        return $return;
    }
    
    protected function preFormPost(Form $form, EntityManager $em) : Form
    {
        return $form;
    }

    protected function postFormPost(Form $form, EntityManager $em) : Form
    {
        return $form;
    }

    protected function postPost($obj, EntityManager $em)
    {
        return;
    }
}
