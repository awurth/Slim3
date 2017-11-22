<?php

namespace App\Core\Controller;

use Slim\Http\Request;
use Slim\Http\Response;

class CoreController extends Controller
{
    public function home(Request $request, Response $response)
    {
        return $this->twig->render($response, 'app/home.twig');
    }
}
