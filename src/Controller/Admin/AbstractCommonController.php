<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

abstract class AbstractCommonController extends Controller
{
    protected $canonicalName;
    protected $templateDir;

    protected function createView($template, array $data = [])
    {
        return $this->render($this->templateDir.'/'.$template, $data);
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
