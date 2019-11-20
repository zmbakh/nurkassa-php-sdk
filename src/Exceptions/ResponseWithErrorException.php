<?php

namespace Nurkassa\Exceptions;

use Exception;
use Throwable;

class ResponseWithErrorException extends Exception
{
    /**
     * @var array
     */
    protected $errors = [];

    /**
     * ResponseWithErrorException constructor.
     *
     * @param string         $message
     * @param int            $code
     * @param array          $errors
     * @param Throwable|null $previous
     */
    public function __construct($message = '', $code = 0, $errors = [], Throwable $previous = null)
    {
        $this->errors = $errors;
        parent::__construct($message, $code, $previous);
    }

    /**
     * @return array
     */
    public function getErrors(): array
    {
        return $this->errors;
    }
}
