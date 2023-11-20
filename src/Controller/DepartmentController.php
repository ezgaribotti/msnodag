<?php

namespace App\Controller;

use App\Dto\Requests\DepartmentTransferDto;
use App\Providers\ResponseMacroServiceProvider;
use App\Rules\Api\DepartmentRule;
use App\Services\DepartmentService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class DepartmentController extends AbstractController
{
    public function __construct(
        protected ResponseMacroServiceProvider $response,
        protected DepartmentService $departmentService,
        protected DepartmentRule $departmentRule
    )
    {}

    #[Route('/departments', methods: ['GET'])]
    public function index(Request $request): JsonResponse
    {
        try {
            $this->departmentRule->validate($request->query->all());
        } catch (\Exception $exception) {
            return $this->response->error($exception->getMessage(), 422);
        }

        try {
            $departments = $this->departmentService->search(
                new DepartmentTransferDto($request->query->all()));

        } catch (\Exception $exception) {
            return $this->response->error($exception->getMessage(), $exception->getCode());
        }
        return $this->response->success($departments);
    }
}
