<?php

namespace App\TwigExtension;

use Psr\Http\Message\RequestInterface;
use Twig_SimpleFunction;
use Twig_Extension;

class AssetExtension extends Twig_Extension
{
    protected $request;

    public function __construct(RequestInterface $request)
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
