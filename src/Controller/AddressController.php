<?php

namespace App\Controller;

use App\Dto\Requests\AddressTransferDto;
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

    #[Route('/addresses', name: 'app_address', methods: ['POST'])]
    public function index(Request $request): JsonResponse
    {
        $content = json_decode($request->getContent(), true);
        try {
            $this->addressRule->validate($content);
        } catch (\Exception $exception) {
            return $this->response->error($exception->getMessage(), 422);
        }

        try {
            $address = $this->addressService->save(
                new AddressTransferDto($content));

        } catch (\Exception $exception) {
            return $this->response->error($exception->getMessage(), $exception->getCode());
        }
        return $this->response->success($address);
    }
}
