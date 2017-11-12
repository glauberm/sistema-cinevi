<?php

namespace Cinevi\AdminBundle\Controller;

use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Form;
use FOS\RestBundle\Routing\ClassResourceInterface;
use FOS\RestBundle\View\View;
use Cinevi\AdminBundle\Form\Type\DeleteType;

abstract class RestfulDeleteController extends RestfulUpdateController implements ClassResourceInterface
{
    public function deleteAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $obj = $em->getRepository($this->repositoryName)->find($id);

        $this->denyAccessUnlessGranted('delete', $obj);

        $form = $this->getForm($obj, DeleteType::class, 'DELETE');

        $form = $this->preFormDelete($obj, $form, $em);

        $form->handleRequest($request);

        $form = $this->postFormDelete($obj, $form, $em);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->remove($obj);
            $em->flush();

            $this->get('session')->getFlashBag()->set('success', 'Remoção de item realizada com sucesso!');

            $this->postDelete($obj, $em);

            $view = View::createRouteRedirect('cget_'.$this->routeSuffix);
        } else {
            $view = View::createRouteRedirect('edit_'.$this->routeSuffix, array(
                'id' => $obj->getId(),
            ));
        }

        return $view;
    }

    protected function preFormDelete($obj, Form $form, EntityManager $em) : Form
    {
        return $form;
    }

    protected function postFormDelete($obj, Form $form, EntityManager $em) : Form
    {
        return $form;
    }

    protected function postDelete($obj, EntityManager $em)
    {
        return;
    }
}
