<?php

namespace App\Controller;

use App\Providers\ResponseMacroServiceProvider;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\ErrorHandler\Exception\FlattenException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Log\DebugLoggerInterface;

class ErrorController extends AbstractController
{
    public function __construct(
        protected ResponseMacroServiceProvider $response
    )
    {}

    public function show(FlattenException $exception, DebugLoggerInterface $logger = null): JsonResponse
    {
        return $this->response->error(
            $exception->getMessage(), $exception->getStatusCode());
    }
}
