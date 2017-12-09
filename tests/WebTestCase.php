<?php

namespace Tests;

use App\Application;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;
use Slim\App;
use Slim\Http\Environment;
use Slim\Http\Request;
use Slim\Http\Response;
use Symfony\Component\Dotenv\Dotenv;

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
        $environment = Environment::mock([
            'REQUEST_METHOD' => $requestMethod,
            'REQUEST_URI' => $requestUri
        ]);

        $request = Request::createFromEnvironment($environment);

        if (isset($requestData)) {
            $request = $request->withParsedBody($requestData);
        }

        $response = new Response();

        if (!isset($_SERVER['APP_TEST_ENV'])) {
            if (!class_exists(Dotenv::class)) {
                throw new \RuntimeException('APP_TEST_ENV environment variable is not defined. You need to define environment variables for configuration or add "symfony/dotenv" as a Composer dependency to load variables from a .env file.');
            }
            (new Dotenv())->load(__DIR__.'/../.env');
        }

        $app = new Application($_SERVER['APP_TEST_ENV'] ?? 'test');

        return $app->process($request, $response);
    }
}
