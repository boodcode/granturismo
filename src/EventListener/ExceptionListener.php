<?php

namespace  App\EventListener;

use Symfony\Component\HttpFoundation\Response;
use Liip\ImagineBundle\Exception\Config\Filter\NotFoundException;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Twig\Environment;

use Symfony\Component\HttpFoundation\RedirectResponse;

use App\Controller\OperationController;

class ExceptionListener
{
    public function __construct(
        private Environment $twig
    )
    {

    }

    public function onKernelException(ExceptionEvent $event)
    {
        //dd($event);
        $exception = $event->getThrowable();
        if(!$exception instanceof NotFoundHttpException) {
            return;
        }

        $response = new RedirectResponse('http://127.0.0.1:8000/');
        $event->setResponse($response);


        //$content = $this->twig->render('exception/404.html.twig');
        //$event->setResponse((new Response())->setContent($content));
    }


}
