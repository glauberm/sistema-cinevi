<?php

namespace App\Controller\Index;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class IndexController extends Controller
{
    public function index()
    {
        return $this->redirect($this->generateUrl('fos_user_profile_show'));
    }
}
