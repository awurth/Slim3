<?php

namespace App\TwigExtension;

use Slim\Csrf\Guard;

class Csrf extends \Twig_Extension
{
    private $csrf;

    public function __construct(Guard $csrf)
    {
        $this->csrf = $csrf;
    }

    public function getName()
    {
        return 'csrf';
    }

    public function getFunctions()
    {
        return [
            new \Twig_SimpleFunction('csrf', array($this, 'csrf'), array('is_safe' => array('html')))
        ];
    }

    public function csrf()
    {
        return '
            <input type="hidden" name="' . $this->csrf->getTokenNameKey() . '" value="' . $this->csrf->getTokenName() . '">
            <input type="hidden" name="' . $this->csrf->getTokenValueKey() . '" value="' . $this->csrf->getTokenValue() . '">
        ';
    }
}