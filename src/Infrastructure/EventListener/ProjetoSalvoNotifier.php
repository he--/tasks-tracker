<?php

namespace App\Infrastructure\EventListener;


use App\Domain\Model\Projeto;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Psr\Log\LoggerInterface;

class ProjetoSalvoNotifier
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
     * @param Projeto $projeto
     * @param LifecycleEventArgs $event
     */
    public function postUpdate(Projeto $projeto, LifecycleEventArgs $event): void
    {
        $this->logger->info("aqui sim");
        dump(1);exit;
    }

}
