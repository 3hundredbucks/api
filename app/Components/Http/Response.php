<?php

namespace Components\Http;

class Response
{
    private function requestStatus($code): string
    {
        $status = [
            200 => 'OK',
            400 => 'Bad Request',
            404 => 'Not Found',
            405 => 'Method Not Allowed',
            500 => 'Internal Server Error',
        ];
        return $status[$code];
    }

    public function response($data, $status = 500)
    {
        header("HTTP/1.1 " . $status . " " . $this->requestStatus($status));
        echo(json_encode($data));
        die;
    }

}
