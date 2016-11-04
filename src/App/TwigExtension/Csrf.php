<?php

namespace App\TwigExtension;

use Psr\Http\Message\RequestInterface as Request;

class Csrf extends \Twig_Extension
{
    private $csrfName;

    private $csrfValue;

    public function __construct(Request $request)
    {
        $this->csrfName = $request->getAttribute('csrf_name');
        $this->csrfValue = $request->getAttribute('csrf_value');
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
            <input type="hidden" name="csrf_name" value="' . $this->csrfName . '">
            <input type="hidden" name="csrf_value" value="' . $this->csrfValue . '">
        ';
    }
}