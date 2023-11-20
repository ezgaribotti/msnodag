<?php

namespace App\Controller;

use App\Dto\Requests\LocalityTransferDto;
use App\Providers\ResponseMacroServiceProvider;
use App\Rules\Api\LocalityRule;
use App\Services\LocalityService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class LocalityController extends AbstractController
{
    public function __construct(
        protected ResponseMacroServiceProvider $response,
        protected LocalityService $localityService,
        protected LocalityRule $localityRule
    )
    {}

    #[Route('/localities', methods: ['GET'])]
    public function index(Request $request): JsonResponse
    {
        try {
            $this->localityRule->validate($request->query->all());
        } catch (\Exception $exception) {
            return $this->response->error($exception->getMessage(), 422);
        }

        try {
            $localities = $this->localityService->search(
                new LocalityTransferDto($request->query->all()));

        } catch (\Exception $exception) {
            return $this->response->error($exception->getMessage(), $exception->getCode());
        }
        return $this->response->success($localities);
    }
}
