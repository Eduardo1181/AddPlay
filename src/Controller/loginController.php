<?php

declare(strict_types=1);

namespace Project\Mvc\Controller;

use Nyholm\Psr7\Response;
use Project\Mvc\Traits\FlashMessageTrait;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class loginController implements RequestHandlerInterface
{
   use FlashMessageTrait;
   private \PDO $pdo;
   public function __construct()
   {
    $dbPath = __DIR__ . '/../../banco.sqlite';
    $this->pdo = new \PDO("sqlite:$dbPath");
   }
   
   public function handle(ServerRequestInterface $request): ResponseInterface
   {
        $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
        $password = filter_input(INPUT_POST, 'password');
        
        $sql = 'SELECT * FROM users WHERE email = ?';
        $statement = $this->pdo->prepare($sql);
        $statement->bindValue(1, $email);
        $statement->execute();

        $userDate = $statement->fetch(\PDO::FETCH_ASSOC);
        $correctPassword = password_verify($password, $userDate['password'] ?? '');
        
        if (!$correctPassword) {
            $this->addErrorMessage('Usuário ou senha inválidos');
            return new Response(302, ['Location' => '/login']);$this->addErrorMessage('Usuário ou senha inválidos');
        }

        if (password_needs_rehash($userDate['password'], PASSWORD_ARGON2ID)) {
            $statement = $this->pdo->prepare('UPDATE users SET password = ? WHERE id = ?');
            $statement->bindValue(1, password_hash($password, PASSWORD_ARGON2ID));
            $statement->bindValue(2, $userDate['id']);
            $statement->execute();
        }

            $_SESSION['logado'] = true;
            return new Response(302, ['Location' => '/']);
        }

}
