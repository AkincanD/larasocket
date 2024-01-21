<?php

namespace Akincand\LaraSocket;

class SocketConnectionException extends \Exception
{
    protected $errorCode;
    protected $errorMessage;

    public function __construct($message = "", $code = 0, \Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
        $this->errorCode = $code;
        $this->errorMessage = $message;
    }

    public function getErrorCode()
    {
        return $this->errorCode;
    }

    public function getErrorMessage()
    {
        return $this->errorMessage;
    }
}
