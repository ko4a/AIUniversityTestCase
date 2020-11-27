<?php

declare(strict_types=1);

namespace App\EventListener;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;

class ExceptionListener
{
    public function onKernelException(ExceptionEvent $event): void
    {
        $code = 0 === $event->getThrowable()->getCode() ? Response::HTTP_BAD_REQUEST : $event->getThrowable()->getCode();

        $response = [
            'code' => $code,
            'message' => $event->getThrowable()->getMessage(),
        ];

        $event->setResponse(new Response(json_encode($response), $response['code']));
    }
}
