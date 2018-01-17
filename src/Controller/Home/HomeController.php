<?php

namespace App\Controller\Home;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class HomeController extends Controller
{
    public function home()
    {
        return $this->render('home/home.html.twig');
    }

}
