<?php

namespace App\Controller\Admin;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Form;
use Swift_Mailer;
use Twig_Environment;
use App\Http\CsvResponse;
use App\Entity\Historico;

abstract class AbstractUpdateController extends AbstractCreateController
{
    protected $editTemplate = 'edit.html.twig';

    public function edit(Request $request, EntityManagerInterface $em, SessionInterface $session, TokenStorageInterface $tokenStorageInterface, Swift_Mailer $mailer, Twig_Environment $twig, $params)
    {
        $repository = $em->getRepository($this->repositoryName);
        $obj = $repository->findOneBy([ $this->paramsKey => $params ]);
        $this->denyAccessUnlessGranted('edit', $obj);
        $deleteForm = $this->createDeleteForm($obj);
        $editForm = $this->createForm($this->formClassName, $obj);
        $editForm = $this->preFormEdit($obj, $editForm, $em);
        $editForm->handleRequest($request);
        $editForm = $this->postFormEdit($obj, $editForm, $em);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $arrayResult = $repository->getArrayResultById($obj->getId(), $this->repositoryName);
            $obj = $this->createHistorico($obj, $arrayResult, $tokenStorageInterface, $em);
            $em->merge($obj);
            $em->flush();
            $session->getFlashBag()->set('success', 'Edição de item realizada com sucesso!');
            $obj = $this->postEdit($obj, $em, $session, $mailer, $twig);

            return $this->redirectToRoute($this->canonicalName.'_index');
        }

        return $this->createView($this->editTemplate, [
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            'item' => $obj
        ]);
    }

    protected function preFormEdit($obj, Form $form, EntityManagerInterface $em) : Form
    {
        return $form;
    }

    protected function postFormEdit($obj, Form $form, EntityManagerInterface $em) : Form
    {
        return $form;
    }

    protected function postEdit($obj, EntityManagerInterface $em, SessionInterface $session, Swift_Mailer $mailer, Twig_Environment $twig)
    {
        return;
    }

    private function createHistorico($obj, array $data, TokenStorageInterface $tokenStorageInterface, EntityManagerInterface $em)
    {
        $historicoRepository = $em->getRepository($this->historicoRepository);
        $historico = $historicoRepository->buildHistorico($obj, $data, new $this->historicoRepository(), $tokenStorageInterface);
        $obj->addHistorico($historico);

        return $obj;
    }
}
