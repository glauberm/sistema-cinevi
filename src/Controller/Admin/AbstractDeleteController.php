<?php

namespace App\Controller\Admin;

use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Form;

abstract class AbstractDeleteController extends AbstractUpdateController
{
    public function delete(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $obj = $em->getRepository($this->repositoryName)->find($id);
        $this->denyAccessUnlessGranted('delete', $obj);
        $form = $this->createDeleteForm($obj);
        $form = $this->preFormDelete($obj, $form, $em);
        $form->handleRequest($request);
        $form = $this->postFormDelete($obj, $form, $em);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->remove($obj);
            $em->flush();
            $this->get('session')->getFlashBag()->set('success', 'Remoção de item realizada com sucesso!');
            $this->postDelete($obj, $em);
        }

        return $this->redirectToRoute($this->canonicalName.'_index');
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
