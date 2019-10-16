<?php

namespace Tests;

use App\Application;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;
use Slim\Http\Environment;
use Slim\Http\Request;
use Slim\Http\Response;
use Symfony\Component\Dotenv\Dotenv;

class WebTestCase extends TestCase
{
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
     * @param string            $requestMethod
     * @param string            $requestUri
     * @param array|object|null $requestData
     *
     * @return ResponseInterface
     */
    public function runApp(string $requestMethod, string $requestUri, $requestData = null)
    {
        $environment = Environment::mock([
            'REQUEST_METHOD' => $requestMethod,
            'REQUEST_URI' => $requestUri
        ]);

        $request = Request::createFromEnvironment($environment);

        if (isset($requestData)) {
            $request = $request->withParsedBody($requestData);
        }

        $response = new Response();

        (new Dotenv())->loadEnv(__DIR__.'/../.env');

        $app = new Application('test');

        return $app->process($request, $response);
    }
}
