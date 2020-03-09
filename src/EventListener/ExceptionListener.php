<?php

namespace App\EventListener;

use App\Exception\EmailAlreadyUsedException;
use App\Exception\PostNotFoundException;
use App\Exception\UserNotFoundException;
use Symfony\Component\Config\Exception\LoaderLoadException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Messenger\Exception\HandlerFailedException;

class ExceptionListener
{
    public function onKernelException(ExceptionEvent $event)
    {
        $exception = $event->getThrowable();

        $body = $this->exceptionHandler($exception);

        if ($body) {
            $responseData = [
                'error' => $body,
            ];

            $event->setResponse(new JsonResponse($responseData, $body['code']));
        }

    }

    private function exceptionHandler($exception)
    {
        $code = Response::HTTP_INTERNAL_SERVER_ERROR;
        $class = get_class($exception);

        switch ($class) {
            case HandlerFailedException::class:
                $previousException = $exception->getPrevious();
                return $this->ExceptionHandler($previousException);
            case LoaderLoadException::class:
                $previousException = $exception->getPrevious();
                return $this->ExceptionHandler($previousException);
            case NotFoundHttpException::class:
                return null;
            case PostNotFoundException::class:
            case UserNotFoundException::class:
                $code = 404;
                break;
            case \InvalidArgumentException::class:
            case EmailAlreadyUsedException::class:
                $code = 400;
                break;
        }

        return [
            'code' => $code,
            'message' => $exception->getMessage(),
            'class' => $class,
        ];

    }
}
