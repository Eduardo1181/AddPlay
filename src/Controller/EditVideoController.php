<?php

declare(strict_types=1);

namespace Project\Mvc\Controller;

use Nyholm\Psr7\Response;
use Project\Mvc\Entity\Video;
use Project\Mvc\Repository\VideoRepository;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Project\Mvc\Traits\FlashMessageTrait;
use Psr\Http\Server\RequestHandlerInterface;

class EditVideoController implements RequestHandlerInterface
{
    use FlashMessageTrait;

    public function __construct(private VideoRepository $videoRepository)
    {
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $queryParams = $request->getQueryParams();
        $id = filter_var($queryParams['id'], FILTER_VALIDATE_INT);
        if ($id === null || $id === false) {
            $this->addErrorMessage('ID inválido');
            return new Response(302, [
                'Location' => '/?sucesso=0'
            ]);
        }

        $parsedBody = $request->getParsedBody();
        $url = filter_var($parsedBody['url'] ?? null, FILTER_VALIDATE_URL);
        if ($url === false) {
            $this->addErrorMessage('URL inválida');
            return new Response(302, [
                'Location' => '/?sucesso=0'
            ]);
        }

        $titulo = $parsedBody['titulo'] ?? null;
        if (empty($titulo)) {
            $this->addErrorMessage('Título inválido');
            return new Response(302, [
                'Location' => '/?sucesso=0'
            ]);
        }

        $video = new Video($url, $titulo);
        $video->setId($id);

        $uploadedFiles = $request->getUploadedFiles();
        if (isset($uploadedFiles['image']) && $uploadedFiles['image']->getError() === UPLOAD_ERR_OK) {
            $filePath = __DIR__ . '/../../public/img/uploads/' . $uploadedFiles['image']->getClientFilename();
            $uploadedFiles['image']->moveTo($filePath);
            $video->setFilePath($uploadedFiles['image']->getClientFilename());
        }

        $success = $this->videoRepository->update($video);

        if ($success === false) {
            $this->addErrorMessage('Erro ao atualizar vídeo');
            return new Response(302, [
                'Location' => '/?sucesso=0'
            ]);
        }

        $this->addSuccessMessage('Vídeo atualizado com sucesso!');
        return new Response(302, [
            'Location' => '/?sucesso=1'
        ]);
    }
}
