<?php

namespace App\Controller;

use App\Dto\Requests\AddressTransferDto;
use App\Dto\Requests\UpdateAddressTransferDto;
use App\Providers\ResponseMacroServiceProvider;
use App\Rules\Api\AddressRule;
use App\Services\AddressService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class AddressController extends AbstractController
{
    public function __construct(
        protected ResponseMacroServiceProvider $response,
        protected AddressRule $addressRule,
        protected AddressService $addressService
    )
    {}

    #[Route('/addresses', methods: ['POST'])]
    public function save(Request $request): JsonResponse
    {
        $content = json_decode($request->getContent(), true);
        try {
            $this->addressRule->validateToSave($content);
        } catch (\Exception $exception) {
            return $this->response->error($exception->getMessage(), 422);
        }

        try {
            return $this->response->success(
                $this->addressService->save(
                    new AddressTransferDto($content)));

        } catch (\Exception $exception) {
            return $this->response->error($exception->getMessage(), $exception->getCode());
        }
    }

    #[Route('/addresses/{finger}', methods: ['GET'])]
    public function showByFinger(string $finger): JsonResponse
    {
        try {
            return $this->response->success(
                $this->addressService->getByFinger($finger));

        } catch (\Exception $exception) {
            return $this->response->error($exception->getMessage(), $exception->getCode());
        }
    }

    #[Route('/addresses/{finger}', methods: ['PUT'])]
    public function updateByFinger(string $finger, Request $request): JsonResponse
    {
        $content = json_decode($request->getContent(), true);
        try {
            $this->addressRule->validateToUpdate($content);
        } catch (\Exception $exception) {
            return $this->response->error($exception->getMessage(), 422);
        }

        try {
            $this->addressService->updateByFinger($finger, new UpdateAddressTransferDto($content));

        } catch (\Exception $exception) {
            return $this->response->error($exception->getMessage(), $exception->getCode());
        }
        return $this->response->success();
    }

    #[Route('/addresses/{finger}', methods: ['DELETE'])]
    public function deleteByFinger(string $finger): JsonResponse
    {
        try {
            $this->addressService->deleteByFinger($finger);

        } catch (\Exception $exception) {
            return $this->response->error($exception->getMessage(), $exception->getCode());
        }
        return $this->response->success();
    }
}
