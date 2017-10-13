<?php

namespace Security\TwigExtension;

use Psr\Http\Message\ServerRequestInterface;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class CsrfExtension extends AbstractExtension
{
    /**
     * @var string
     */
    private $csrfName;

    /**
     * @var string
     */
    private $csrfValue;

    /**
     * Constructor.
     *
     * @param ServerRequestInterface $request
     */
    public function __construct(ServerRequestInterface $request)
    {
        $this->csrfName = $request->getAttribute('csrf_name');
        $this->csrfValue = $request->getAttribute('csrf_value');
    }

    /**
     * {@inheritdoc}
     */
    public function getFunctions()
    {
        return [
            new TwigFunction('csrf', [$this, 'csrf'], ['is_safe' => ['html']])
        ];
    }

    /**
     * Gets the HTML for the CSRF fields.
     *
     * @return string
     */
    public function csrf()
    {
        return '
            <input type="hidden" name="csrf_name" value="' . $this->csrfName . '">
            <input type="hidden" name="csrf_value" value="' . $this->csrfValue . '">
        ';
    }
}
