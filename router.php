<?php

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Middlewares\CorsMiddleware;
use Tuupola\Middleware\JwtAuthentication;
use Slim\App;

return function (App $app) {

    $app->add(new JwtAuthentication([
        "attribute" => "token",
        "header" => "Authorization",
        "regexp" => "/Bearer\s+(.*)$/i",
        "secure" => false,
        "algorithm" => ["HS256"],
        "secret" => $_ENV["JWT_SECRET"],
        "path" => ["/"],
        "error" => function ($response) {
            return $response
                ->withStatus(401)
                ->getBody()
                ->write(json_encode([
                    "success" => false,
                    "message" => "Invalid JWT Token"
                ]));
        }
    ]));

    $app->options('/{routes:.*}', function (Request $request, Response $response) {
        return $response;
    });
    $app->add(CorsMiddleware::class);

    $app->get('/', "App\Controllers\HomeController:home");

    $app->get('/user', "App\Controllers\UserController:user");   

};
