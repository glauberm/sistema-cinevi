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
use Cinevi\AdminBundle\Http\CsvResponse;

// exit(var_dump("<pre>",\Doctrine\Common\Util\Debug::dump($pagination),"</pre>"));

abstract class RestfulCrudController extends FOSRestController implements ClassResourceInterface
{
    protected $bundleName;
    protected $repositoryName;
    protected $className;
    protected $routeSuffix;
    protected $formClassName;
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

        $configuration = $this->getConfiguration($em);

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

        $view = View::create();
        $view
            ->setData($pagination)
            ->setTemplate($this->bundleName.':'.$this->listarTemplate)
            ->setTemplateVar('pagination')
            ->setTemplateData(function (ViewHandlerInterface $viewHandler, View $view) use ($configuration, $numResultados) {
                return array(
                    'configuration' => $configuration,
                    'numResultados' => $numResultados
                );
            })
        ;

        return $view;
    }

    public function newAction()
    {
        $em = $this->getDoctrine()->getManager();

        $obj = new $this->className();

        $configuration = $this->getConfiguration($em);

        $form = $this->getForm($obj, $this->formClassName, 'POST', 'post_'.$this->routeSuffix);

        $view = View::create();
        $view
            ->setData($form->createView())
            ->setTemplate($this->bundleName.':'.$this->criarTemplate)
            ->setTemplateVar('form')
            ->setTemplateData(function (ViewHandlerInterface $viewHandler, View $view) use ($obj, $configuration) {
                return array(
                    'item' => $obj,
                    'configuration' => $configuration,
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
        $em = $this->getDoctrine()->getManager();

        $obj = $em->getRepository($this->repositoryName)
            ->find($id)
        ;

        $configuration = $this->getConfiguration($em);

        $this->denyAccessUnlessGranted('view', $obj, 'Você não tem permissão para visualizar este item.');

        $deleteForm = $this->getForm($obj, DeleteType::class, 'DELETE', 'delete_'.$this->routeSuffix, array('id' => $id));

        // Chama o método a ser sobreescrito mostrar()
        $obj = $this->mostrar($obj);

        $view = View::create();
        $view
            ->setData($obj)
            ->setTemplate($this->bundleName.':'.$this->mostrarTemplate)
            ->setTemplateVar('item')
            ->setTemplateData(function (ViewHandlerInterface $viewHandler, View $view) use ($deleteForm, $configuration) {
                return array(
                    'deleteForm' => $deleteForm->createView(),
                    'configuration' => $configuration,
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
        $configuration = $this->getConfiguration($em);

        $this->denyAccessUnlessGranted('create', $obj, 'Você não tem permissão para criar um(a) item.');

        $form = $this->getForm($obj, $this->formClassName, 'POST');

        // Chama o método a ser sobreescrito preCriar()
        $form = $this->preCriar($form, $em);

        $form->handleRequest($request);

        // Chama o método a ser sobreescrito posCriar()
        $form = $this->posCriar($form, $em);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($obj);
            $em->flush();

            // Note: use FOSHttpCacheBundle to automatically move this flash message to a cookie
            $this->get('session')->getFlashBag()->set('success', 'Criação de item realizada com sucesso!');

            // Chama o método a ser sobreescrito posPersist()
            $obj = $this->posPersist($obj, $em);

            $view = View::createRouteRedirect('get_'.$this->routeSuffix.'s');
        } else {
            $view = View::create();
            $view
                ->setData($form->createView())
                ->setTemplate($this->bundleName.':'.$this->criarTemplate)
                ->setTemplateVar('form')
                ->setTemplateData(function (ViewHandlerInterface $viewHandler, View $view) use ($obj, $configuration) {
                    return array(
                        'item' => $obj,
                        'configuration' => $configuration,
                    );
                })
            ;
        }

        return $view;
    }

    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $obj = $this->getDoctrine()->getManager()
            ->getRepository($this->repositoryName)->find($id)
        ;

        $configuration = $this->getConfiguration($em);

        $editForm = $this->getForm($obj, $this->formClassName, 'PUT', 'put_'.$this->routeSuffix, array('id' => $id));
        $deleteForm = $this->getForm($obj, DeleteType::class, 'DELETE', 'delete_'.$this->routeSuffix, array('id' => $id));

        $view = View::create();
        $view
            ->setData($editForm->createView())
            ->setTemplate($this->bundleName.':'.$this->editarTemplate)
            ->setTemplateVar('editForm')
            ->setTemplateData(function (ViewHandlerInterface $viewHandler, View $view) use ($deleteForm, $obj, $configuration) {
                return array(
                    'deleteForm' => $deleteForm->createView(),
                    'item' => $obj,
                    'configuration' => $configuration,
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

        $configuration = $this->getConfiguration($em);

        $this->denyAccessUnlessGranted('edit', $obj, 'Você não tem permissão para editar um(a) item.');

        $editForm = $this->getForm($obj, $this->formClassName, 'PUT');
        $deleteForm = $this->getForm($obj, DeleteType::class, 'DELETE', 'delete_'.$this->routeSuffix, array('id' => $id));

        // Chama o método a ser sobreescrito preEditar()
        $editForm = $this->preEditar($obj, $editForm, $em);

        $editForm->submit($request->request->get($editForm->getName()));

        // Chama o método a ser sobreescrito posEditar()
        $editForm = $this->posEditar($obj, $editForm, $em);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em->merge($obj);
            $em->flush();

            // Note: use FOSHttpCacheBundle to automatically move this flash message to a cookie
            $this->get('session')->getFlashBag()->set('success', 'Edição de item realizada com sucesso!');

            // Chama o método a ser sobreescrito posMerge()
            $obj = $this->posMerge($obj, $em);

            $view = View::createRouteRedirect('get_'.$this->routeSuffix.'s');
        } else {
            $view = View::create();
            $view
                ->setData($editForm->createView())
                ->setTemplate($this->bundleName.':'.$this->editarTemplate)
                ->setTemplateVar('editForm')
                ->setTemplateData(function (ViewHandlerInterface $viewHandler, View $view) use ($deleteForm, $obj, $configuration) {
                    return array(
                        'deleteForm' => $deleteForm->createView(),
                        'item' => $obj,
                        'configuration' => $configuration,
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

        $this->denyAccessUnlessGranted('delete', $obj, 'Você não tem permissão para deletar um(a) item.');

        $form = $this->getForm($obj, DeleteType::class, 'DELETE');

        // Chama o método a ser sobreescrito preDeletar()
        $editForm = $this->preDeletar($obj, $form, $em);

        $form->submit($request->request->get($form->getName()));

        // Chama o método a ser sobreescrito posDeletar()
        $editForm = $this->posDeletar($obj, $form, $em);

        if ($editForm->isSubmitted() && $form->isValid()) {
            $em->remove($obj);
            $em->flush();

            // @TODO: Note: use FOSHttpCacheBundle to automatically move this flash message to a cookie
            $this->get('session')->getFlashBag()->set('success', 'Remoção de item realizada com sucesso!');

            // Chama o método a ser sobreescrito posRemove()
            $obj = $this->posRemove($obj, $em);

            $view = View::createRouteRedirect('get_'.$this->routeSuffix.'s');
        } else {
            $view = View::createRouteRedirect('edit_'.$this->routeSuffix, array(
                'id' => $obj->getId(),
            ));
        }

        return $view;
    }

    protected function getForm($obj, $formClass, $method, $routeName = null, $params = array())
    {
        $options = array();
        $options['method'] = $method;
        if (null !== $routeName) {
            $options['action'] = $this->generateUrl($routeName, $params);
        }

        return $this->createForm($formClass, $obj, $options);
    }

    public function getCsvAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $keys = array();

        $itens = $em->getRepository($this->bundleName)
               ->createQueryBuilder('item')
               ->select('item')
               ->getQuery()
               ->getResult(\Doctrine\ORM\Query::HYDRATE_ARRAY);

        foreach($itens as $item) {
            $keys[] = array_keys($item);
            break;
        }

        $arrayResultado = array_merge($keys, $itens);

        return new CsvResponse($this->routeSuffix, $arrayResultado);
    }

    protected function getConfiguration(EntityManager $em)
    {
        return $em->getRepository('CineviAdminBundle:Configuration')
            ->createQueryBuilder('config')
            ->getQuery()
            ->getOneOrNullResult()
        ;
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

    protected function posCriar(Form $form, EntityManager $em)
    {
        return $form;
    }

    protected function posPersist($obj, EntityManager $em)
    {
        return $obj;
    }

    protected function preEditar($obj, Form $form, EntityManager $em)
    {
        return $form;
    }

    protected function posEditar($obj, Form $form, EntityManager $em)
    {
        return $form;
    }

    protected function posMerge($obj, EntityManager $em)
    {
        return $obj;
    }

    protected function preDeletar($obj, Form $form, EntityManager $em)
    {
        return $form;
    }

    protected function posDeletar($obj, Form $form, EntityManager $em)
    {
        return $form;
    }

    protected function posRemove($obj, EntityManager $em)
    {
        return $obj;
    }
}
