<?php

declare(strict_types=1);

namespace Project\Mvc\Controller;

use League\Plates\Engine;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Nyholm\Psr7\Response;
use Psr\Http\Server\RequestHandlerInterface;

class loginFController  implements RequestHandlerInterface
{
   public function __construct(private Engine $tamplates) {
    
   }

   public function handle(ServerRequestInterface $request): ResponseInterface
   {
       if (array_key_exists('logado', $_SESSION) && $_SESSION['logado'] === true) {
           return new Response(302, [
               'Location' => '/'
           ]);
       }

       return new Response(200, body: $this->tamplates->render('login'));
   }
}
