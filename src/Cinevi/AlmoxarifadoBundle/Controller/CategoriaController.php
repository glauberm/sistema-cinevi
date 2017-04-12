<?php

namespace Cinevi\AlmoxarifadoBundle\Controller;

use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\View\ViewHandlerInterface;
use FOS\RestBundle\View\View;
use Cinevi\AdminBundle\Controller\RestfulCrudController;
use Cinevi\AlmoxarifadoBundle\Entity\Categoria;
use Cinevi\AlmoxarifadoBundle\Form\Type\CategoriaType;
use Cinevi\AdminBundle\Form\Type\DeleteType;

class CategoriaController extends RestfulCrudController
{
    protected $bundleName = 'CineviAlmoxarifadoBundle:Categoria';
    protected $repositoryName = 'CineviAlmoxarifadoBundle:Categoria';
    protected $className = Categoria::class;
    protected $routeSuffix = 'categoria';
    protected $formClassName = CategoriaType::class;

    /*
     * Sobreescrevendo com a mesma coisa
     * porque deu erro do id virar 'new'
     * no getAction() caso não sobreescrit
    */
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
     * Sobreescrevendo o método para adicionar a listagem de equipamentos
     */
    public function getAction(Request $request, $id)
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

        // PAGINADOR DE EQUIPAMENTOS
        // Número de resultados
        if ($request->query->get('numResultados')) {
            $numResultados = $request->query->get('numResultados');
        } else {
            $numResultados = 10;
        }

        // Exclusão por permissões de visualização
        $builderEquipamentos = $em->getRepository('CineviAlmoxarifadoBundle:Equipamento')
                ->createQueryBuilder('item')
                ->where('item.categoria = '.$id)
                ->orderBy('item.id', 'DESC');

        foreach ($builderEquipamentos->getQuery()->getResult() as $result) {
            if (false === $this->get('security.authorization_checker')->isGranted('view', $result)) {
                $builderEquipamentos->where('item.id != '.$result->getId());
            }
        }

        // Paginador
        $paginatorEquipamentos = $this->get('knp_paginator');
        $paginationEquipamentos = $paginatorEquipamentos->paginate(
            $builderEquipamentos,
            $request->query->getInt('page', 1),
            $numResultados
        );

        $view = View::create();
        $view
            ->setData($obj)
            ->setTemplate($this->bundleName.':'.$this->mostrarTemplate)
            ->setTemplateVar('item')
            ->setTemplateData(function (ViewHandlerInterface $viewHandler, View $view) use ($deleteForm, $paginationEquipamentos, $numResultados, $configuration) {
                return array(
                    'deleteForm' => $deleteForm->createView(),
                    'paginationEquipamentos' => $paginationEquipamentos,
                    'numResultados' => $numResultados,
                    'configuration' => $configuration,
                );
            })
        ;

        return $view;
    }
}
