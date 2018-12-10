<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redis;
use Illuminate\Redis\Connections\PredisConnection;

class Logger
{
    private $request_id;

    public function __construct()
    {
        $this->request_id = uniqid(time());
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(!isset($_SERVER['REQUEST_METHOD'])){
            return $next($request);
        }
        if (stripos('options', $_SERVER['REQUEST_METHOD']) === false) {
            Log::info(var_export([
                'Request ID' => $this->request_id,
                'Host' => $_SERVER['SERVER_NAME'],
                'Uri'  => $_SERVER['REQUEST_URI'],
                'Headers' => $request->headers->all(),
                'Protocol' => $_SERVER['SERVER_PROTOCOL'],
                'RemoteIP' => $_SERVER['REMOTE_ADDR'],
                'Method' => $_SERVER['REQUEST_METHOD'],
                'Params' => $request->all()
            ], true));
        }


        $response = $next($request);

        if (stripos('options', $_SERVER['REQUEST_METHOD']) === false) {
            Log::info(var_export([
                'Response ID' => $this->request_id,
                'StatusCode' => $response->getStatusCode(),
                'Content'  => json_decode($response->getContent(), true),
            ], true));
        }

        return $response;
    }

}
