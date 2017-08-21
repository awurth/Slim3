<?php

namespace App\Controller;

use Slim\Http\Request;
use Slim\Http\Response;

class AppController extends Controller
{
    public function home(Request $request, Response $response)
    {
        return $this->view->render($response, 'App/home.twig');
    }
}
