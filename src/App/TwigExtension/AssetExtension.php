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

    public function __construct(ServerRequestInterface $request)
    {
        $this->request = $request;
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
        return $this->request->getUri()->getBaseUrl() . '/' . $path;
    }
}
