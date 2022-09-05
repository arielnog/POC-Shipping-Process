<?php

namespace App\Http\Controllers;

use App\Exceptions\ClientSaveException;
use App\Services\ClientService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ClientController extends Controller
{
    public function __construct(
        private ClientService $clientService
    ) {
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @throws ClientSaveException
     */
    public function save(Request $request): JsonResponse
    {
        $parameters = $request->all();

        $client = $this->clientService->save($parameters);

        if (is_null($client)) {
            return response()->json(
                [
                    'message' => 'Erro ao criar usuário'
                ],
                Response::HTTP_CREATED
            );
        }

        return response()->json(
            [
                'message' => 'Sucesso ao salvar o usuário',
                'content' => $client->toArray()
            ],
            Response::HTTP_BAD_REQUEST
        );
    }
}
