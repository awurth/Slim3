<?php

namespace App\Controller;

use Psr\Http\Message\RequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Respect\Validation\Validator as V;

class AuthController extends Controller
{
    public function login(Request $request, Response $response)
    {
        if ($request->isPost()) {
            if (!$this->auth->attempt($request->getParam('username'), $request->getParam('password'))) {
                $this->flash('danger', 'Wrong username or password.');
                return $this->redirect($response, 'login');
            }

            return $this->redirect($response, 'home');
        }

        return $this->view->render($response, 'Auth/login.twig');
    }

    public function logout(Request $request, Response $response)
    {
        $this->auth->logout();
        return $this->redirect($response, 'home');
    }
}