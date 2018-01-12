<?php

namespace AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

abstract class AbstractCommonController extends Controller
{
    protected $canonicalName;
    protected $bundleName;

    protected function createView($template, array $data = [])
    {
        return $this->render($this->bundleName.':'.$template, $data);
    }

    protected function createDeleteForm($obj)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl($this->canonicalName.'_delete', [
                'id' => $obj->getId()
            ]))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
