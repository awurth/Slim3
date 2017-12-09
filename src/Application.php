<?php

namespace App;

use Psr\Container\ContainerInterface;
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
     * @param string                   $environment
     * @param ContainerInterface|array $settings
     */
    public function __construct($environment, $settings = [])
    {
        parent::__construct($settings);

        $this->environment = $environment;
        $this->rootDir = $this->getRootDir();

        $this->loadConfiguration();
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
        return $this->getRootDir().'/app';
    }

    public function getEnvironment()
    {
        return $this->environment;
    }

    public function getLogDir()
    {
        return $this->getRootDir().'/var/logs';
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
        $container = $this->getContainer();
        require $this->getConfigurationDir().'/container.php';
    }

    protected function loadConfiguration()
    {
        $app = $this;
        $container = $this->getContainer();
        if (file_exists($this->getConfigurationDir().'/config/config.'.$this->getEnvironment().'.php')) {
            $container['config'] = require $this->getConfigurationDir().'/config/config.'.$this->getEnvironment().'.php';
        } else {
            $container['config'] = require $this->getConfigurationDir().'/config/config.php';
        }
    }

    protected function loadMiddleware()
    {
        $app = $this;
        $container = $this->getContainer();
        require $this->getConfigurationDir().'/middleware.php';
    }

    protected function loadRoutes()
    {
        $app = $this;
        $container = $this->getContainer();
        require $this->getConfigurationDir().'/routes.php';
    }

    protected function registerControllers()
    {
        $container = $this->getContainer();
        if (file_exists($this->getConfigurationDir().'/controllers.php')) {
            $controllers = require $this->getConfigurationDir().'/controllers.php';
            foreach ($controllers as $key => $class) {
                $container[$key] = function ($container) use ($class) {
                    return new $class($container);
                };
            }
        }
    }

    protected function registerHandlers()
    {
        $container = $this->getContainer();
        require $this->getConfigurationDir().'/handlers.php';
    }
}
