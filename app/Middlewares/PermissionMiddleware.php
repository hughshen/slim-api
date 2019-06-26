<?php

namespace App\Middlewares;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class PermissionMiddleware
{
    public function __invoke(RequestInterface $request, ResponseInterface $response, callable $next)
    {
        $token = $request->getHeaderLine('Authorization');

        if (empty($token)) {
            return $response->withJson('API token required')->withStatus(401);
        }

        if (strpos($token, 'Bearer ') !== 0 || $token !== 'Bearer 123456') {
            return $response->withJson('Invalid API token')->withStatus(401);
        }

        return $next($request, $response);
    }
}