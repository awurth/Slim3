<?php

namespace Admin\Controller;

use App\Controller\Controller;
use Slim\Http\Request;
use Slim\Http\Response;

class AdminController extends Controller
{
    public function home(Request $request, Response $response)
    {
        return $this->view->render($response, 'Admin/home.twig');
    }
}
