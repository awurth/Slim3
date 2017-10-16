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
    public function __construct(ServerRequestInterface $request, $basePath = null)
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
        if (null !== $this->basePath) {
            return $this->request->getUri()->getBaseUrl() . '/' . trim($this->basePath, '/') . '/' . $path;
        }

        return $this->request->getUri()->getBaseUrl() . '/' . $path;
    }
}
