<?php

namespace App\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class UserController
{
    public function user(Request $request, Response $response): Response
    {
        //Retourne les informations de l'utilisateur
        $response->getBody()->write(json_encode([
            "success" => true,
            "user" => [
                "id" => $_ENV["ADMIN_ID"],
                "login" => $_ENV["ADMIN_LOGIN"],
                "email" => $_ENV["ADMIN_EMAIL"],
            ],
        ]));
        return $response
            ->withHeader("Content-Type", "application/json");
    }
}
