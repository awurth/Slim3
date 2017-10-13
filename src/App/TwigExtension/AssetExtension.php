<?php

namespace App\TwigExtension;

use Psr\Http\Message\ServerRequestInterface;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class AssetExtension extends AbstractExtension
{
    /**
     * @var ServerRequestInterface
     */
    protected $request;

    /**
     * @var string
     */
    protected $basePath;

    /**
     * Constructor.
     *
     * @param ServerRequestInterface $request
     * @param string                 $basePath
     */
    public function __construct(ServerRequestInterface $request, $basePath = '')
    {
        $this->request = $request;
        $this->basePath = $basePath;
    }

    /**
     * {@inheritdoc}
     */
    public function getFunctions()
    {
        return [
            new TwigFunction('asset', [$this, 'asset'])
        ];
    }

    /**
     * Gets the path to the asset.
     *
     * @param string $path
     *
     * @return string
     */
    public function asset($path)
    {
        return $this->request->getUri()->getBaseUrl() . '/' . $this->basePath . $path;
    }
}
