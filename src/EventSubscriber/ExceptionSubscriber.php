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

        $response = new JsonResponse();
        if ($exception instanceof VinhoException) {
            $response->setJson(
                json_encode(
                    [
                        'mensagem' => $event->getThrowable()->getMessage(),
                    ]
                )
            );
            $response->setStatusCode($event->getThrowable()->getCode());
        } else {
            $response->setJson(
                json_encode(
                    [
                        'mensagem' => 'Ocorreu um erro ao processar a sua requisição. Tente novamente!',
                    ]
                )
            );
            $response->setStatusCode(Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        $event->setResponse($response);
    }
}
