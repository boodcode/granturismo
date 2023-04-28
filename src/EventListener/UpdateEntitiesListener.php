<?php
// src/EventListener/UpdateEntitiesListener.php

namespace App\EventListener;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\Event\LifecycleEventArgs;
use App\Entity\Operation;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class UpdateEntitiesListener extends AbstractController
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function postPersist(LifecycleEventArgs $args): void
    {
        $entity = $args->getObject();

        if ($entity instanceof Operation) {
            $unitOfWork = $this->entityManager->getUnitOfWork();
            $unitOfWork->computeChangeSets(); // nécessaire pour éviter les modifications répétées des instances

            $repository = $this->entityManager->getRepository(Operation::class);
            $entities = $repository->findAll();

            foreach ($entities as $existingEntity) {
                if ($existingEntity !== $entity) {
                    if($entity->isAlaune()) {
                        $existingEntity->setAlaune(false);
                    }

                }
            }

            $this->entityManager->flush();
        }
    }

    public function postUpdate(LifecycleEventArgs $args): void
    {
        $entity = $args->getObject();

        if ($entity instanceof Operation) {
            $unitOfWork = $this->entityManager->getUnitOfWork();
            $unitOfWork->computeChangeSets(); // nécessaire pour éviter les modifications répétées des instances

            $repository = $this->entityManager->getRepository(Operation::class);
            $entities = $repository->findAll();

            foreach ($entities as $existingEntity) {
                if ($existingEntity !== $entity) {
                    if($entity->isAlaune()) {
                        $existingEntity->setAlaune(false);
                    }

                }
            }

            $this->entityManager->flush();
        }
    }
}
