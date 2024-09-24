<?php

declare(strict_types=1);

namespace Project\Mvc\Controller;

use Project\Mvc\Repository\VideoRepository;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Nyholm\Psr7\Response;
use Psr\Http\Server\RequestHandlerInterface;
use League\Plates\Engine;

class VideoListController implements RequestHandlerInterface
{
    public function __construct(
        private VideoRepository $videoRepository,
        private Engine $templates,
    ) {
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $videoList = $this->videoRepository->all();
        return new Response(200, body: $this->templates->render(
            'video-list',
            ['videoList' => $videoList]
        ));
    }
}
