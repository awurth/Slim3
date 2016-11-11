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

    public function register(Request $request, Response $response)
    {
        if ($request->isPost()) {
            $username = $request->getParam('username');
            $email = $request->getParam('email');
            $password = $request->getParam('password');

            $this->validator->validate($request, [
                'username' => V::length(6, 25)->alnum('_')->noWhitespace(),
                'email' => V::noWhitespace()->email(),
                'password' => V::noWhitespace()->length(6, 25),
                'password-confirm' => V::equals($password)
            ]);

            if ($this->sentinel->findByCredentials(['login' => $username])) {
                $this->validator->addError('username', 'User already exists with this username.');
            }

            if ($this->sentinel->findByCredentials(['login' => $email])) {
                $this->validator->addError('email', 'User already exists with this email address.');
            }

            if ($this->validator->isValid()) {
                $role = $this->sentinel->findRoleByName('User');

                $user = $this->sentinel->create([
                    'username' => $username,
                    'email' => $email,
                    'password' => $password,
                    'permissions' => [
                        'user.delete' => 0
                    ]
                ]);

                $role->users()->attach($user);

                $this->flash('success', 'Your account has been created.');
                return $this->redirect($response, 'home');
            }
        }

        return $this->view->render($response, 'Auth/register.twig');
    }

    public function logout(Request $request, Response $response)
    {
        $this->auth->logout();
        return $this->redirect($response, 'home');
    }
}