<?php

namespace App\EventSubscriber;

use App\Exception\VinhoException;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\KernelEvents;

final class ExceptionSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::EXCEPTION => 'onKernelException',
        ];
    }

    public function onKernelException(ExceptionEvent $event): void
    {
        $exception = $event->getThrowable();

        if ($exception instanceof VinhoException) {
            $response = new JsonResponse(
                [
                    'mensagem' => $event->getThrowable()->getMessage(),
                ],
                $event->getThrowable()->getCode()
            );
        } else {
            $response = new JsonResponse(
                [
                    'mensagem' => 'Ocorreu um erro ao processar a sua requisição. Tente novamente!',
                ],
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }

        $event->setResponse($response);
    }
}
