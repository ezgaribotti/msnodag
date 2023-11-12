<?php

namespace App\Controller;

use App\Providers\ResponseMacroServiceProvider;
use App\Services\DepartmentService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class DepartmentController extends AbstractController
{
    public function __construct(
        protected ResponseMacroServiceProvider $response,
        protected DepartmentService $departmentService
    )
    {}

    #[Route('/department', name: 'app_department')]
    public function index(): JsonResponse
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/DepartmentController.php',
        ]);
    }
}
