<?php

namespace App\Controller;

use App\Providers\ResponseMacroServiceProvider;
use App\Services\StreetService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class StreetController extends AbstractController
{
    public function __construct(
        protected ResponseMacroServiceProvider $response,
        protected StreetService $streetService
    )
    {}

    #[Route('/street', name: 'app_street')]
    public function index(): JsonResponse
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/StreetController.php',
        ]);
    }
}
