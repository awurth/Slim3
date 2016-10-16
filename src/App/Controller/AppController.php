<?php

namespace App\Controller;

class AppController extends Controller
{
    public function home()
    {
        return $this->render('App/home.twig');
    }
}