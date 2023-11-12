<?php

namespace App\Controller;

use App\Providers\ResponseMacroServiceProvider;
use App\Services\LocalityService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class LocalityController extends AbstractController
{
    public function __construct(
        protected ResponseMacroServiceProvider $response,
        protected LocalityService $localityService
    )
    {}

    #[Route('/locality', name: 'app_locality')]
    public function index(): JsonResponse
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/LocalityController.php',
        ]);
    }
}
