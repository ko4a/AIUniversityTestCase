<?php

declare(strict_types=1);

namespace App\EventListener;

use App\Exception\ValidationFailedException;
use FOS\RestBundle\View\View;
use FOS\RestBundle\View\ViewHandlerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;

class ValidationFailedListener
{
    private $viewHandler;

    public function __construct(ViewHandlerInterface $viewHandler)
    {
        $this->viewHandler = $viewHandler;
    }

    public function onKernelException(ExceptionEvent $event): void
    {
        if (!$event->getThrowable() instanceof ValidationFailedException) {
            return;
        }

        $errors = $event->getThrowable()->getViolations();

        $view = View::create($errors, JsonResponse::HTTP_BAD_REQUEST)->setFormat('json');

        $event->setResponse($this->viewHandler->handle($view));
    }
}
