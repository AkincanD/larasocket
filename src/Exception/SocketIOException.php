<?php

namespace Akincand\LaraSocket;

class SocketIOException extends \Exception
{
    protected $errorInfo;

    public function __construct($message = "", $code = 0, \Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
        $this->errorInfo = $message;
    }

    public function getErrorInfo()
    {
        return $this->errorInfo;
    }
}