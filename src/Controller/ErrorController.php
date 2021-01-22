<?php

namespace App\Controller;

use App\Dto\ApiError;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;

class ErrorController
{
    public function show(\Throwable $exception, $logger, SerializerInterface $serializer)
    {
        $error = new ApiError();
        $error->addError('exception', $exception->getMessage());

        return JsonResponse::fromJsonString(
            $serializer->serialize(
                $error,
                'json'
            )
        );
    }
}
