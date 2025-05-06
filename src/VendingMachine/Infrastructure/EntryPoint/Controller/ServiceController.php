<?php

declare(strict_types=1);

namespace App\VendingMachine\Infrastructure\EntryPoint\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ServiceController
{
    #[Route('/api/service', methods: Request::METHOD_PUT)]
    public function __invoke(): JsonResponse
    {
        return new JsonResponse([]);
    }
}
