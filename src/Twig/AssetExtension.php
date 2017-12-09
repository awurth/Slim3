<?php

namespace App\Twig;

use Psr\Http\Message\ServerRequestInterface as Request;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class AssetExtension extends AbstractExtension
{
    /**
     * @var Request
     */
    protected $request;

    /**
     * @var string
     */
    protected $basePath;

    /**
     * Constructor.
     *
     * @param Request $request
     * @param string  $basePath
     */
    public function __construct(Request $request, $basePath = null)
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
            return $this->request->getUri()->getBaseUrl().'/'.trim($this->basePath, '/').'/'.$path;
        }

        return $this->request->getUri()->getBaseUrl().'/'.$path;
    }
}
