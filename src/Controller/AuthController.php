<?php

namespace App\Controller;

use Awurth\Slim\Helper\Controller\Controller;
use Awurth\SlimValidation\Validator;
use Cartalyst\Sentinel\Checkpoints\ThrottlingException;
use Cartalyst\Sentinel\Roles\EloquentRole;
use Cartalyst\Sentinel\Sentinel;
use Respect\Validation\Validator as V;
use Slim\Http\Request;
use Slim\Http\Response;
use App\Model\Translation;

/**
 * @property Validator validator
 * @property Sentinel  auth
 */
class AuthController extends Controller
{
    public function login(Request $request, Response $response)
    {
        if ($request->isPost()) {

            $credentials = [
                'username' => $request->getParam('username'),
                'password' => $request->getParam('password')
            ];
            $remember = (bool)$request->getParam('remember');

            try {
                if ($this->auth->authenticate($credentials, $remember)) {
                    $this->flash('success', $this->translate('auth.login_success'));

                    return $this->redirect($response, 'home');
                } else {
                    $this->validator->addError('auth',$this->translate('auth.error.login'));
                }
            } catch (ThrottlingException $e) {
                $this->validator->addError('auth', $this->translate('auth.error.too_many_attempts'));
            }
        }
        return $this->render($response, 'auth/login.twig');
    }

    public function register(Request $request, Response $response)
    {
        if ($request->isPost()) {
            $username = $request->getParam('username');
            $email = $request->getParam('email');
            $password = $request->getParam('password');

            $this->validator->request($request, [
                'username' => V::length(3, 25)->alnum('_')->noWhitespace(),
                'email' => V::noWhitespace()->email(),
                'password' => [
                    'rules' => V::noWhitespace()->length(6, 25),
                    'messages' => [
                        'length' => $this->translate('auth.error.password.length')
                    ]
                ],
                'password_confirm' => [
                    'rules' => V::equals($password),
                    'messages' => [
                        'equals' => $this->translate('auth.error.password.match')
                    ]
                ]
            ]);

            if ($this->auth->findByCredentials(['login' => $username])) {
                $this->validator->addError('username', $this->translate('auth.error.username'));
            }

            if ($this->auth->findByCredentials(['login' => $email])) {
                $this->validator->addError('email', $this->translate('auth.error.email'));
            }

            if ($this->validator->isValid()) {
                /** @var EloquentRole $role */
                $role = $this->auth->findRoleByName('user');

                $user = $this->auth->registerAndActivate([
                    'username' => $username,
                    'email' => $email,
                    'password' => $password,
                    'permissions' => [
                        'user.delete' => 0
                    ]
                ]);

                $role->users()->attach($user);

                $this->flash('success', $this->translate('auth.register_success'));

                return $this->redirect($response, 'login');
            }
        }

        return $this->render($response, 'auth/register.twig');
    }

    public function logout(Request $request, Response $response)
    {
        $this->auth->logout();

        return $this->redirect($response, 'home');
    }
}
