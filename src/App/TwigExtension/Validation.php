<?php

namespace App\TwigExtension;

use App\Service\Validator;

class Validation extends \Twig_Extension
{
    /**
     * Validator service
     *
     * @var Validator
     */
    private $validator;

    public function __construct(Validator $validator)
    {
        $this->validator = $validator;
    }

    public function getName()
    {
        return 'validator';
    }

    public function getFunctions()
    {
        return [
            new \Twig_SimpleFunction('error', array($this, 'getError')),
            new \Twig_SimpleFunction('errors', array($this, 'getErrors')),
            new \Twig_SimpleFunction('hasError', array($this, 'hasError')),
            new \Twig_SimpleFunction('hasErrors', array($this, 'hasErrors'))
        ];
    }

    /**
     * Get the first validation error of param
     *
     * @param string $param
     * @return string
     */
    public function getError($param)
    {
        return $this->validator->getFirst($param);
    }

    /**
     * Get the validation errors of param
     *
     * @param string $param
     * @return array
     */
    public function getErrors($param)
    {
        return $this->validator->getErrorsOf($param);
    }

    /**
     * Return true if there are validation errors for param
     *
     * @param string $param
     * @return bool
     */
    public function hasError($param)
    {
        return !empty($this->validator->getErrorsOf($param));
    }

    /**
     * Return true if there are validation errors
     *
     * @return bool
     */
    public function hasErrors()
    {
        return !$this->validator->isValid();
    }
}