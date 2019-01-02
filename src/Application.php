<?php

namespace App;

use Slim\App;

class Application extends App
{
    /**
     * @var string
     */
    protected $environment;

    /**
     * @var string
     */
    protected $rootDir;

    /**
     * Constructor.
     *
     * @param string $environment
     */
    public function __construct($environment)
    {
        $this->environment = $environment;
        $this->rootDir = $this->getRootDir();

        parent::__construct($this->loadConfiguration());

        $this->configureContainer();
        $this->registerHandlers();
        $this->loadMiddleware();
        $this->registerControllers();
        $this->loadRoutes();
    }

    public function getCacheDir()
    {
        return $this->getRootDir().'/var/cache/'.$this->environment;
    }

    public function getConfigurationDir()
    {
        return $this->getRootDir().'/config';
    }

    public function getEnvironment()
    {
        return $this->environment;
    }

    public function getLogDir()
    {
        return $this->getRootDir().'/var/log';
    }

    public function getRootDir()
    {
        if (null === $this->rootDir) {
            $this->rootDir = dirname(__DIR__);
        }

        return $this->rootDir;
    }

    protected function configureContainer()
    {
        $this->readConfigFile('container.php', ['container' => $this->getContainer()]);
    }

    protected function loadConfiguration()
    {
        $settings = $this->readConfigFile('framework.php', ['app' => $this]);

        if (file_exists($this->getConfigurationDir().'/services.'.$this->getEnvironment().'.php')) {
            $filename = 'services.'.$this->getEnvironment().'.php';
        } else {
            $filename = 'services.php';
        }

        $settings += $this->readConfigFile($filename, ['app' => $this]);

        return ['settings' => $settings];
    }

    protected function loadMiddleware()
    {
        $this->readConfigFile('middleware.php', [
            'app' => $this,
            'container' => $this->getContainer()
        ]);
    }

    protected function loadRoutes()
    {
        $this->readConfigFile('routes.php', [
            'app' => $this,
            'container' => $this->getContainer()
        ]);
    }

    protected function registerControllers()
    {
        $container = $this->getContainer();
        $controllers = $this->readConfigFile('controllers.php', ['container' => $container]);

        foreach ($controllers as $key => $class) {
            $container['controller.'.$key] = function ($container) use ($class) {
                return new $class($container);
            };
        }
    }

    protected function registerHandlers()
    {
        $this->readConfigFile('handlers.php', ['container' => $this->getContainer()]);
    }

    private function readConfigFile(string $filename, array $params = [])
    {
        foreach ($params as $name => $value) {
            if ($name) {
                ${$name} = $value;
            }
        }

        return require $this->getConfigurationDir().'/'.$filename;
    }
}
