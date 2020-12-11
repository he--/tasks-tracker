<?php

namespace App\Infrastructure\Listener;

use DomainException;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\{
    AccessDeniedHttpException,
    HttpExceptionInterface,
    UnauthorizedHttpException
};

/**
 * Class ExceptionListener
 * @package App\Infrastructure\Listener
 */
class ExceptionListener
{

    /**
     * @var LoggerInterface
     */
    private LoggerInterface $logger;

    /**
     * ExceptionListener constructor.
     * @param LoggerInterface $logger
     */
    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    /**
     * @param ExceptionEvent $event
     */
    public function onKernelException(ExceptionEvent $event)
    {
        if ($this->isAccessSecurityException($event)) {
            return $this->buildAccessSecurityException($event);
        }

        if (
            $this->hasMappedExceptionOrNotProduction($event)
            || $event->getThrowable() instanceof DomainException
        ) {
            return $this->buildMappedExceptionResponse($event);
        }

        $this->logger->error($event->getThrowable());

        return $event->setResponse(
            new JsonResponse(
                ['message' => 'Ocorreu um erro no sistema. Por favor, tente novamente mais tarde'],
                JsonResponse::HTTP_INTERNAL_SERVER_ERROR
            )
        );
    }

    /**
     * @param ExceptionEvent $event
     */
    private function buildAccessSecurityException(ExceptionEvent $event)
    {
        /** @var HttpExceptionInterface $previous */
        $previous = $event->getThrowable();

        return $event->setResponse(
            new JsonResponse($previous->getMessage(), $previous->getStatusCode())
        );
    }

    /**
     * @param ExceptionEvent $event
     * @return bool
     */
    private function isAccessSecurityException(ExceptionEvent $event): bool
    {
        return
            $event->getThrowable() instanceof AccessDeniedHttpException ||
            $event->getThrowable() instanceof UnauthorizedHttpException;
    }

    /**
     * @param ExceptionEvent $event
     */
    private function buildMappedExceptionResponse(ExceptionEvent $event)
    {
        $exceptionCode = $event->getThrowable()->getCode();
        $httpCode = $exceptionCode ?: JsonResponse::HTTP_BAD_REQUEST;

        $this->logger->error($event->getThrowable());

        return $event->setResponse(
            new JsonResponse(
                [
                    'message' => $event->getThrowable()->getMessage(),
                    'code' => $exceptionCode,
                ],
                $httpCode
            )
        );
    }

    /**
     * @param ExceptionEvent $event
     * @return bool
     */
    private function hasMappedExceptionOrNotProduction(ExceptionEvent $event): bool
    {
        return true;
    }
}
