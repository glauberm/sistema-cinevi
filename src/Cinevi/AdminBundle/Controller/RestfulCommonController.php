<?php

namespace Cinevi\AdminBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Routing\ClassResourceInterface;
use FOS\RestBundle\View\ViewHandlerInterface;
use FOS\RestBundle\View\View;

abstract class RestfulCommonController extends FOSRestController implements ClassResourceInterface
{
    protected $bundleName;

    protected function getView($data, $template, $templateVar, array $return = [])
    {
        $view = View::create();

        $view
            ->setData($data)
            ->setTemplate($this->bundleName.':'.$template)
            ->setTemplateVar($templateVar)
            ->setTemplateData(
                function (ViewHandlerInterface $viewHandler, View $view) use ($return) {
                    return $return;
                }
            )
        ;

        return $view;
    }

    protected function getForm($obj, $formClass, $method, $routeName = null, $params = array())
    {
        $options = array();

        $options['method'] = $method;

        if (!empty($routeName)) {
            $options['action'] = $this->generateUrl($routeName, $params);
        }

        return $this->createForm($formClass, $obj, $options);
    }
}
