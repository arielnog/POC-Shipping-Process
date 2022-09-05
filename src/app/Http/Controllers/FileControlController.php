<?php

namespace App\Http\Controllers;

use App\Exceptions\InvalidArgumentException;
use App\Services\FileControlService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class FileControlController extends Controller
{
    public function __construct(
        private FileControlService $fileControlService
    ) {
    }

    /**
     * @throws Throwable
     * @throws InvalidArgumentException
     */
    public function save(Request $request): JsonResponse
    {
        $clientId = $request->header('clientId');
        $files = $request->file('file');

        $saveFile = $this->fileControlService->saveFile(
            $files,
            $clientId
        );

        if (!$saveFile) {
            return response()->json(
                [
                    'message' => 'Erro ao salvar arquivo(s).'
                ],
                Response::HTTP_BAD_REQUEST
            );
        }

        return response()->json(
            [
                'message' => 'Arquivo(s) salvo(s) com sucesso'
            ],
            Response::HTTP_CREATED
        );
    }
}
