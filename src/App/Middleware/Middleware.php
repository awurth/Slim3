<?php

namespace App\Middleware;

use Slim\Http\Request;
use Slim\Http\Response;

interface Middleware
{
    /**
     * Method call when the class is user as a function.
     *
     * @param Request $request
     * @param Response $response
     * @param callable $next
     *
     * @return mixed
     */
    public function __invoke(Request $request, Response $response, callable $next);
}
