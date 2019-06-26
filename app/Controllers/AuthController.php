<?php

namespace App\Controllers;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

class AuthController extends BaseController
{
    public function login(Request $request, Response $response, array $args)
    {
        $msg = null;
        $body = $request->getParsedBody();
        if (!isset($body['username'])) {
            $msg = 'The username field is required.';
        } elseif (!isset($body['password'])) {
            $msg = 'The password field is required.';
        }

        if ($msg !== null) {
            return $response->withJson($msg);
        }

        if ($body['username'] !== 'admin' || $body['password'] !== 'admin') {
        	return $response->withJson('Incorrect username or password');
        }

        return $response->withJson(array(
        	'token' => '123456',
        	'username' => $body['username'],
        ));
    }
}
