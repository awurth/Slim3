<?php

namespace App\Controller;

use Slim\Http\Request;
use Slim\Http\Response;

class AdminController extends Controller
{
    public function home(Request $request, Response $response)
    {
        return $this->twig->render($response, 'admin/home.twig');
    }
}
