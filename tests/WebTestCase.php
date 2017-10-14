<?php

namespace Tests;

use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;
use Slim\App;
use Slim\Http\Environment;
use Slim\Http\Request;
use Slim\Http\Response;

class WebTestCase extends TestCase
{
    /**
     * @var bool
     */
    protected $withMiddleware = true;

    /**
     * {@inheritdoc}
     */
    public function __construct($name = null, array $data = [], $dataName = '')
    {
        session_start();

        parent::__construct($name, $data, $dataName);
    }

    /**
     * Processes the application given a request method and URI.
     *
     * @param string $requestMethod
     * @param string $requestUri
     * @param array|object|null $requestData
     *
     * @return ResponseInterface
     */
    public function runApp($requestMethod, $requestUri, $requestData = null)
    {
        $environment = Environment::mock(
            [
                'REQUEST_METHOD' => $requestMethod,
                'REQUEST_URI' => $requestUri
            ]
        );

        $request = Request::createFromEnvironment($environment);

        if (isset($requestData)) {
            $request = $request->withParsedBody($requestData);
        }

        $response = new Response();

        $app = new App([
            'env' => 'test',
            'root_dir' => dirname(__DIR__)
        ]);
        $container = $app->getContainer();

        $container['config'] = require __DIR__ . '/../app/config/config.php';

        require __DIR__ . '/../app/dependencies.php';
        require __DIR__ . '/../app/handlers.php';

        if ($this->withMiddleware) {
            require __DIR__ . '/../app/middleware.php';
        }

        require __DIR__ . '/../app/controllers.php';
        require __DIR__ . '/../app/routing.php';

        return $app->process($request, $response);
    }
}
