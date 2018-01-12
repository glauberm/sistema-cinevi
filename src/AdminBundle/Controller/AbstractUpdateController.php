<?php

namespace AdminBundle\Controller;

use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Form;
use AdminBundle\Http\CsvResponse;

abstract class AbstractUpdateController extends AbstractCreateController
{
    protected $editTemplate = 'edit.html.twig';

    public function editAction(Request $request, $params)
    {
        $em = $this->getDoctrine()->getManager();
        $obj = $em->getRepository($this->repositoryName)->findOneBy([
            $this->paramsKey => $params
        ]);
        $this->denyAccessUnlessGranted('edit', $obj);
        $deleteForm = $this->createDeleteForm($obj);
        $editForm = $this->createForm($this->formClassName, $obj);
        $editForm = $this->preFormEdit($obj, $editForm, $em);
        $editForm->handleRequest($request);
        $editForm = $this->postFormEdit($obj, $editForm, $em);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em->merge($obj);
            $em->flush();
            $this->get('session')->getFlashBag()->set('success', 'Edição de item realizada com sucesso!');
            $obj = $this->postEdit($obj, $em);

            return $this->redirectToRoute($this->canonicalName.'_index');
        }

        return $this->createView($this->editTemplate, [
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            'item' => $obj
        ]);
    }

    protected function preFormEdit($obj, Form $form, EntityManager $em) : Form
    {
        return $form;
    }

    protected function postFormEdit($obj, Form $form, EntityManager $em) : Form
    {
        return $form;
    }

    protected function postEdit($obj, EntityManager $em)
    {
        return;
    }
}
