<?php

namespace App\TwigExtension;

use Psr\Http\Message\ServerRequestInterface;
use Twig_Extension;
use Twig_SimpleFunction;

class AssetExtension extends Twig_Extension
{
    /**
     * @var ServerRequestInterface
     */
    protected $request;

    /**
     * @var string
     */
    protected $basePath;

    public function __construct(ServerRequestInterface $request, $basePath = '')
    {
        $this->request = $request;
        $this->basePath = $basePath;
    }

    public function getName()
    {
        return 'asset';
    }

    public function getFunctions()
    {
        return [
            new Twig_SimpleFunction('asset', [$this, 'asset'])
        ];
    }

    public function asset($path)
    {
        return $this->request->getUri()->getBaseUrl() . '/' . $this->basePath . $path;
    }
}
