<?php

namespace Cinevi\ConfigBundle\Controller;

use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\View\ViewHandlerInterface;
use FOS\RestBundle\View\View;
use Cinevi\AdminBundle\Controller\RestfulCrudController;
use Cinevi\AdminBundle\Entity\Configuration;
use Cinevi\AdminBundle\Form\Type\ConfigurationType;

class ConfigurationController extends RestfulCrudController
{
    protected $bundleName = 'CineviAdminBundle:Configuration';
    protected $repositoryName = 'CineviAdminBundle:Configuration';
    protected $className = Configuration::class;
    protected $routeSuffix = 'configuration';
    protected $formClassName = ConfigurationType::class;

    public function cgetAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $configuration = $this->getConfiguration($em);

        if($configuration) {
            $response = $this->forward( $this->bundleName.':get', array(
                'id' => $configuration->getId()
            ));
        } else {
            $response = $this->forward( $this->bundleName.':new', array());
        }

        return $response;
    }

    public function newAction()
    {
        $em = $this->getDoctrine()->getManager();

        $configuration = $this->getConfiguration($em);

        if($configuration) {
            return $this->forward( $this->bundleName.':get', array(
                'id' => $configuration->getId()
            ));
        } else {
            $obj = new $this->className();

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
    }
}
