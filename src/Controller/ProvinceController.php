<?php

namespace App\Controller;

use App\Providers\ResponseMacroServiceProvider;
use App\Services\ProvinceService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class ProvinceController extends AbstractController
{
    public function __construct(
        protected ResponseMacroServiceProvider $response,
        protected ProvinceService $provinceService
    )
    {}

    #[Route('/province', name: 'app_province')]
    public function index(): JsonResponse
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/ProvinceController.php',
        ]);
    }
}
