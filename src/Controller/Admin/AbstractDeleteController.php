<?php

namespace App\Controller\Admin;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Form;

abstract class AbstractDeleteController extends AbstractUpdateController
{
    public function delete(Request $request, EntityManagerInterface $em, SessionInterface $session, $id)
    {
        $obj = $em->getRepository($this->repositoryName)->find($id);
        $this->denyAccessUnlessGranted('delete', $obj);
        $form = $this->createDeleteForm($obj);
        $form = $this->preFormDelete($obj, $form, $em);
        $form->handleRequest($request);
        $form = $this->postFormDelete($obj, $form, $em);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->remove($obj);
            $em->flush();
            $session->getFlashBag()->set('success', 'Remoção de item realizada com sucesso!');
            $this->postDelete($obj, $em);
        }

        return $this->redirectToRoute($this->canonicalName.'_index');
    }

    protected function preFormDelete($obj, Form $form, EntityManagerInterface $em) : Form
    {
        return $form;
    }

    protected function postFormDelete($obj, Form $form, EntityManagerInterface $em) : Form
    {
        return $form;
    }

    protected function postDelete($obj, EntityManagerInterface $em)
    {
        return;
    }
}
