<?php

namespace App\Controller;

use App\Dto\Requests\StreetTransferDto;
use App\Providers\ResponseMacroServiceProvider;
use App\Rules\Api\StreetRule;
use App\Services\StreetService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class StreetController extends AbstractController
{
    public function __construct(
        protected ResponseMacroServiceProvider $response,
        protected StreetService $streetService,
        protected StreetRule $streetRule
    )
    {}

    #[Route('/streets', methods: ['GET'])]
    public function search(Request $request): JsonResponse
    {
        try {
            $this->streetRule->validateToSearch($request->query->all());
        } catch (\Exception $exception) {
            return $this->response->error($exception->getMessage(), 422);
        }

        try {
            $streets = $this->streetService->search(
                new StreetTransferDto($request->query->all()));

        } catch (\Exception $exception) {
            return $this->response->error($exception->getMessage(), $exception->getCode());
        }
        return $this->response->success($streets);
    }
}
