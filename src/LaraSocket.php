<?php

namespace Akincand\LaraSocket;

use Akincand\LaraSocket\SocketConnectionException;
use Akincand\LaraSocket\SocketIOException;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Arr;
use Symfony\Component\HttpFoundation\Response;

class LaraSocket
{
    private $socketUrl;
    private $socketPort;
    private $socketProtocol;
    private $socket;

    public function __construct()
    {
        $this->socketUrl = config('larasocket.socket_url');
        $this->socketPort = config('larasocket.socket_port');
        $this->socketProtocol = config('larasocket.socket_protocol');
        $this->socket = null;
    }

    public function connect($queryParams = [], $authParams = [])
    {
        $query = http_build_query($queryParams);
        $auth = !empty($authParams) ? 'Authorization: Basic ' . base64_encode(json_encode($authParams)) : '';

        $host = $this->socketUrl . ":" . $this->socketPort;
        $headers = [
            'Host: ' . $host,
            'Upgrade: websocket',
            'Connection: Upgrade',
            'Sec-WebSocket-Key: ' . base64_encode(openssl_random_pseudo_bytes(16)),
            'Sec-WebSocket-Version: 13',
        ];

        if (!empty($auth)) {
            $headers[] = $auth;
        }

        $path = "/socket.io/?EIO=3&transport=websocket" . (!empty($query) ? "&" . $query : "");

        $this->socket = @fsockopen($this->socketUrl, $this->socketPort, $errno, $errstr, 2);
        if (!$this->socket) {
            throw new SocketConnectionException("Socket could not be opened: $errstr ($errno)");
        }

        if (@fwrite($this->socket, "GET " . $path . " HTTP/1.1\r\n" . implode("\r\n", $headers) . "\r\n\r\n") === false) {
            throw new SocketIOException("Could not write data to socket.");
        }

        $response = @fread($this->socket, 1500);
        if ($response === false) {
            throw new SocketIOException("Could not read data from socket.");
        }
    }

    public function emit($event, $data)
    {
        if ($this->socket === null) {
            throw new \RuntimeException("Socket connection is not established. Please call connect() first.");
        }

        try {
            $message = $this->formatMessage($event, $data);
            if (fwrite($this->socket, $message) === false) {
                throw new SocketIOException("Failed to write data to socket.");
            }
        } catch (\Exception $e) {
            fclose($this->socket);
            $this->socket = null;
            throw $e;
        }

        return true;
    }

    private function formatMessage($event, $data)
    {
        return '42["' . $event . '",' . json_encode($data) . ']';
    }

    public function listen($event, $timeout = 5)
    {
        if ($this->socket === null) {
            throw new \RuntimeException("Socket connection is not established. Please call connect() first.");
        }

        try {
            $endTime = time() + $timeout;
            $receivedData = [];

            while (time() < $endTime) {
                $chunk = fread($this->socket, 512);
                if ($chunk === false) {
                    break;
                }

                $receivedData[] = $chunk;

                if ($this->containsEvent($chunk, $event)) {
                    return implode('', $receivedData);
                }
            }
        } catch (\Exception $e) {
            fclose($this->socket);
            $this->socket = null;
            throw $e;
        }

        return null;
    }

    private function containsEvent($data, $event)
    {
        return strpos($data, $event) !== false;
    }

}