<?php 

declare(strict_types=1);

return [
    'GET|/' =>
        \Project\Mvc\Controller\VideoListController::class,
    'GET|/novo-video' =>
        \Project\Mvc\Controller\VideoFormController::class,
    'POST|/novo-video' =>
        \Project\Mvc\Controller\NewVideoController::class,
    'GET|/editar-video' => 
        \Project\Mvc\Controller\VideoFormController::class,
    'POST|/editar-video' =>
        \Project\Mvc\Controller\EditVideoController::class,
    'GET|/remover-video' =>
        \Project\Mvc\Controller\DeleteVideoController::class,
    'GET|/login' =>
        \Project\Mvc\Controller\loginFController::class,
    'POST|/login' =>
        \Project\Mvc\Controller\loginController::class,
    'GET|/logout' =>
        \Project\Mvc\Controller\logoutController::class
];
