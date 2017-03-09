<?php

namespace Cinevi\AdminBundle\Controller;

use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Routing\ClassResourceInterface;
use Symfony\Component\Form\Form;
use FOS\RestBundle\View\ViewHandlerInterface;
use FOS\RestBundle\View\View;
use Cinevi\AdminBundle\Form\Type\DeleteType;

// exit(var_dump("<pre>",\Doctrine\Common\Util\Debug::dump($pagination),"</pre>"));

abstract class RestfulCrudController extends FOSRestController implements ClassResourceInterface
{
    protected $bundleName;
    protected $repositoryName;
    protected $className;
    protected $routeSuffix;
    protected $formClassName;
    protected $label = 'item';
    protected $listarTemplate = 'listar.html.twig';
    protected $criarTemplate = 'adicionar.html.twig';
    protected $editarTemplate = 'editar.html.twig';
    protected $mostrarTemplate = 'mostrar.html.twig';

    /**
     * Lista todas as entidades.
     */
    public function cgetAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $repository = $em->getRepository($this->bundleName);

        // Número de resultados
        if ($request->query->get('numResultados')) {
            $numResultados = $request->query->get('numResultados');
        } else {
            $numResultados = 10;
        }

        // Exclusão por permissões de visualização
        $builder = $repository->createQueryBuilder('item')->orderBy('item.id', 'DESC');
        foreach ($builder->getQuery()->getResult() as $result) {
            if (false === $this->get('security.authorization_checker')->isGranted('view', $result)) {
                $builder->where('item.id != '.$result->getId());
            }
        }

        // Chama o método a ser sobreescrito listar()
        $builder = $this->listar($builder, $em);

        // Paginador
        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $builder,
            $request->query->getInt('page', 1),
            $numResultados
        );

        // $listarForm = $this->getForm($builder->getQuery()->getResult(), ListarType::class, 'DELETE', 'delete_'.$this->routeSuffix, array('id' => $id));

        $view = View::create();
        $view
            ->setData($pagination)
            ->setTemplate($this->bundleName.':'.$this->listarTemplate)
            ->setTemplateVar('pagination')
            ->setTemplateData(function (ViewHandlerInterface $viewHandler, View $view) use ($numResultados) {
                return array(
                    'numResultados' => $numResultados,
                );
            })
        ;

        return $view;
    }

    public function newAction()
    {
        $obj = new $this->className();

        $form = $this->getForm($obj, $this->formClassName, 'POST', 'post_'.$this->routeSuffix);

        $view = View::create();
        $view
            ->setData($form->createView())
            ->setTemplate($this->bundleName.':'.$this->criarTemplate)
            ->setTemplateVar('form')
            ->setTemplateData(function (ViewHandlerInterface $viewHandler, View $view) use ($obj) {
                return array(
                    'item' => $obj,
                );
            })
        ;

        return $view;
    }

    /**
     * Encontra e mostra uma entidade.
     */
    public function getAction($id)
    {
        $obj = $this->getDoctrine()->getManager()
            ->getRepository($this->repositoryName)->find($id)
        ;

        $this->denyAccessUnlessGranted('view', $obj, 'Você não tem permissão para visualizar este '.$this->label.'.');

        $deleteForm = $this->getForm($obj, DeleteType::class, 'DELETE', 'delete_'.$this->routeSuffix, array('id' => $id));

        // Chama o método a ser sobreescrito mostrar()
        $obj = $this->mostrar($obj);

        $view = View::create();
        $view
            ->setData($obj)
            ->setTemplate($this->bundleName.':'.$this->mostrarTemplate)
            ->setTemplateVar('item')
            ->setTemplateData(function (ViewHandlerInterface $viewHandler, View $view) use ($deleteForm) {
                return array(
                    'deleteForm' => $deleteForm->createView(),
                );
            })
        ;

        return $view;
    }

    /**
     * Cria uma nova entidade.
     */
    public function postAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $obj = new $this->className();

        $this->denyAccessUnlessGranted('create', $obj, 'Você não tem permissão para criar um(a) '.$this->label.'.');

        $form = $this->getForm($obj, $this->formClassName, 'POST');

        $form->handleRequest($request);

        // Chama o método a ser sobreescrito preCriar()
        $form = $this->preCriar($form, $em);

        if ($form->isValid()) {
            $em->persist($obj);
            $em->flush();

            // Chama o método a ser sobreescrito posCriar()
            $obj = $this->posCriar($obj, $em);

            // Note: use FOSHttpCacheBundle to automatically move this flash message to a cookie
            $this->get('session')->getFlashBag()->set('success', 'Criação de '.$this->label.' realizada com sucesso!');

            $view = View::createRouteRedirect('get_'.$this->routeSuffix.'s');
        } else {
            $view = View::create();
            $view
                ->setData($form->createView())
                ->setTemplate($this->bundleName.':'.$this->criarTemplate)
                ->setTemplateVar('form')
                ->setTemplateData(function (ViewHandlerInterface $viewHandler, View $view) use ($obj) {
                    return array(
                        'item' => $obj,
                    );
                })
            ;
        }

        return $view;
    }

    public function editAction($id)
    {
        $obj = $this->getDoctrine()->getManager()
            ->getRepository($this->repositoryName)->find($id)
        ;

        $editForm = $this->getForm($obj, $this->formClassName, 'PUT', 'put_'.$this->routeSuffix, array('id' => $id));
        $deleteForm = $this->getForm($obj, DeleteType::class, 'DELETE', 'delete_'.$this->routeSuffix, array('id' => $id));

        $view = View::create();
        $view
            ->setData($editForm->createView())
            ->setTemplate($this->bundleName.':'.$this->editarTemplate)
            ->setTemplateVar('editForm')
            ->setTemplateData(function (ViewHandlerInterface $viewHandler, View $view) use ($deleteForm, $obj) {
                return array(
                    'deleteForm' => $deleteForm->createView(),
                    'item' => $obj,
                );
            })
        ;

        return $view;
    }

    /**
     * Mostra um formulário para edição de uma entidade.
     */
    public function putAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $obj = $this->getDoctrine()->getManager()
            ->getRepository($this->repositoryName)->find($id)
        ;

        $this->denyAccessUnlessGranted('edit', $obj, 'Você não tem permissão para editar um(a) '.$this->label.'.');

        $editForm = $this->getForm($obj, $this->formClassName, 'PUT');
        $deleteForm = $this->getForm($obj, DeleteType::class, 'DELETE', 'delete_'.$this->routeSuffix, array('id' => $id));

        $editForm->submit($request->request->get($editForm->getName()));

        // Chama o método a ser sobreescrito preEditar()
        $editForm = $this->preEditar($obj, $editForm, $em);

        if ($editForm->isValid()) {
            $em->merge($obj);
            $em->flush();

            // Chama o método a ser sobreescrito posEditar()
            $obj = $this->posEditar($obj, $em);

            // Note: use FOSHttpCacheBundle to automatically move this flash message to a cookie
            $this->get('session')->getFlashBag()->set('success', 'Edição de '.$this->label.' realizada com sucesso!');

            $view = View::createRouteRedirect('get_'.$this->routeSuffix.'s');
        } else {
            $view = View::create();
            $view
                ->setData($editForm->createView())
                ->setTemplate($this->bundleName.':'.$this->editarTemplate)
                ->setTemplateVar('editForm')
                ->setTemplateData(function (ViewHandlerInterface $viewHandler, View $view) use ($deleteForm, $obj) {
                    return array(
                        'deleteForm' => $deleteForm->createView(),
                        'item' => $obj,
                    );
                })
            ;
        }

        return $view;
    }

    /**
     * Remove uma entidade.
     */
    public function deleteAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $obj = $this->getDoctrine()->getManager()
             ->getRepository($this->repositoryName)->find($id)
         ;

        $this->denyAccessUnlessGranted('delete', $obj, 'Você não tem permissão para deletar um(a) '.$this->label.'.');

        $form = $this->getForm($obj, DeleteType::class, 'DELETE');

        $form->submit($request->request->get($form->getName()));

        if ($form->isValid()) {
            $em->remove($obj);
            $em->flush();

            // Chama o método a ser sobreescrito posDeletar()
            $obj = $this->posDeletar($obj, $em);

            // @TODO: Note: use FOSHttpCacheBundle to automatically move this flash message to a cookie
            $this->get('session')->getFlashBag()->set('success', 'Remoção de '.$this->label.' realizada com sucesso!');

            $view = View::createRouteRedirect('get_'.$this->routeSuffix.'s');
        } else {
            $view = View::createRouteRedirect('edit_'.$this->routeSuffix, array(
                'id' => $obj->getId(),
            ));
        }

        return $view;
    }

    private function getForm($obj, $formClass, $method, $routeName = null, $params = array())
    {
        $options = array();
        $options['method'] = $method;
        if (null !== $routeName) {
            $options['action'] = $this->generateUrl($routeName, $params);
        }

        return $this->createForm($formClass, $obj, $options);
    }

    /**
     * Métodos que podem ser sobreescritos para adicionar funcionalidade entre as ações.
     * Precisa retornar o $obj ou o $builder.
     *
     * @TODO: PHP7 com declaração de retono.
     */
    protected function listar($builder, EntityManager $em)
    {
        return $builder;
    }

    protected function mostrar($obj)
    {
        return $obj;
    }

    protected function preCriar(Form $form, EntityManager $em)
    {
        return $form;
    }

    protected function posCriar($obj, EntityManager $em)
    {
        return $obj;
    }

    protected function preEditar($obj, Form $form, EntityManager $em)
    {
        return $form;
    }

    protected function posEditar($obj, EntityManager $em)
    {
        return $obj;
    }

    protected function posDeletar($obj, EntityManager $em)
    {
        return $obj;
    }
}
