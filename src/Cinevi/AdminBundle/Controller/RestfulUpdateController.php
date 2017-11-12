<?php

namespace Cinevi\AdminBundle\Controller;

use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Form;
use FOS\RestBundle\Routing\ClassResourceInterface;
use FOS\RestBundle\View\ViewHandlerInterface;
use FOS\RestBundle\View\View;
use Cinevi\AdminBundle\Form\Type\DeleteType;
use Cinevi\AdminBundle\Http\CsvResponse;

abstract class RestfulUpdateController extends RestfulCreateController implements ClassResourceInterface
{
    protected $editTemplate = 'edit.html.twig';

    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $obj = $em->getRepository($this->repositoryName)->find($id);

        $editForm = $this->getForm($obj, $this->formClassName, 'PUT', 'put_'.$this->routeSuffix, array('id' => $id));
        $deleteForm = $this->getForm($obj, DeleteType::class, 'DELETE', 'delete_'.$this->routeSuffix, ['id' => $obj->getId()]);

        $view = $this->editReturn($em, $editForm, ['deleteForm' => $deleteForm->createView(), 'item' => $obj]);

        return $view;
    }

    public function putAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $obj = $this->getDoctrine()->getManager()
            ->getRepository($this->repositoryName)->find($id)
        ;

        $this->denyAccessUnlessGranted('edit', $obj);

        $editForm = $this->getForm($obj, $this->formClassName, 'PUT');

        $editForm = $this->preFormPut($obj, $editForm, $em);

        $editForm->handleRequest($request);

        $editForm = $this->postFormPut($obj, $editForm, $em);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em->merge($obj);
            $em->flush();

            $this->get('session')->getFlashBag()->set('success', 'Edição de item realizada com sucesso!');

            $obj = $this->postPut($obj, $em);

            $view = View::createRouteRedirect('cget_'.$this->routeSuffix);
        } else {
            $deleteForm = $this->getForm($obj, DeleteType::class, 'DELETE', 'delete_'.$this->routeSuffix, ['id' => $obj->getId()]);

            $view = $this->editReturn($em, $editForm, ['deleteForm' => $deleteForm->createView(), 'item' => $obj]);

            return $view;
        }

        return $view;
    }

    private function editReturn(EntityManager $em, $form, $return)
    {
        $return = $this->preEdit($em, $return);

        $view = $this->getView($form->createView(), $this->editTemplate, 'editForm', $return);

        return $view;
    }

    protected function preEdit(EntityManager $em, array $return = []) : array
    {
        return $return;
    }

    protected function preFormPut($obj, Form $form, EntityManager $em) : Form
    {
        return $form;
    }

    protected function postFormPut($obj, Form $form, EntityManager $em) : Form
    {
        return $form;
    }

    protected function postPut($obj, EntityManager $em)
    {
        return;
    }
}
