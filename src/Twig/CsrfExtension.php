<?php

namespace App\Twig;

use Slim\Csrf\Guard;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class CsrfExtension extends AbstractExtension
{
    /**
     * @var Guard
     */
    protected $csrf;

    /**
     * Constructor.
     *
     * @param Guard $csrf
     */
    public function __construct(Guard $csrf)
    {
        $this->csrf = $csrf;
    }

    /**
     * {@inheritdoc}
     */
    public function getFunctions()
    {
        return [
            new TwigFunction('csrf', [$this, 'csrfFields'], ['is_safe' => ['html']])
        ];
    }

    /**
     * Gets the HTML for the CSRF fields.
     *
     * @return string
     */
    public function csrfFields()
    {
        return '
            <input type="hidden" name="'.$this->csrf->getTokenNameKey().'" value="'.$this->csrf->getTokenName().'">
            <input type="hidden" name="'.$this->csrf->getTokenValueKey().'" value="'.$this->csrf->getTokenValue().'">
        ';
    }
}
