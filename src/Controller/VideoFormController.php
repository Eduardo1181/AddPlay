<?php

declare(strict_types=1);

namespace Project\Mvc\Controller;

use League\Plates\Engine;
use Project\Mvc\Entity\Video;
use Project\Mvc\Repository\VideoRepository;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Nyholm\Psr7\Response;
use Psr\Http\Server\RequestHandlerInterface;

class VideoFormController implements RequestHandlerInterface
{

    public function __construct(
        private VideoRepository $repository,
        private Engine $templates
    ){
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $queryParams = $request->getQueryParams();
        $id = filter_var($queryParams['id'] ?? '', FILTER_VALIDATE_INT);
        /** @var ?Video $video */
        $video = null;
        if ($id !== false && $id !== null) {
            $video = $this->repository->find($id);
        }

        return new Response(200, body: $this->templates->render('video-form', [
            'video' => $video,
        ]));
    }
}
