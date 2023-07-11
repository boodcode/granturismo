<?php

namespace App\Controller;

use App\Entity\Categorie;
use App\Entity\Operation;
use App\Entity\StatUser;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class OperationController extends AbstractController
{
    #[Route('/operation', name: 'app_operations')]
    public function index(EntityManagerInterface $entityManager): Response
    {
        /** @var \App\Entity\User $user */

        $user = $this->getUser();

        $operations = [];

        $categorieRepository = $entityManager->getRepository(Categorie::class);
        $operationRepository = $entityManager->getRepository(Operation::class);
        $categories = $categorieRepository->findAll();
        foreach ($categories as $category) {
            $operations[$category->getTitre()] = $operationRepository->findByCategorie($category);
        }
        $operationAlaune = $operationRepository->findOneBy(['alaune'=> true]);


        return $this->render('default/index.html.twig', [
            'user' => $user,
            'operations' => $operations,
            'opeAlaune' => $operationAlaune
        ]);
    }

    #[Route('/operation/{slug}', name: 'app_operation')]
    public function showOperation(EntityManagerInterface $entityManager, string $slug): Response
    {
        /** @var \App\Entity\User $user */

        $user = $this->getUser();

        //ope pour le menu
        $operations = [];
        $categorieRepository = $entityManager->getRepository(Categorie::class);
        $operationRepository = $entityManager->getRepository(Operation::class);
        $categories = $categorieRepository->findAll();
        foreach ($categories as $category) {
            $operations[$category->getTitre()] = $operationRepository->findByCategorie($category);
        }



        //ope en cours
        $operation = [];
        $operationRepository = $entityManager->getRepository(Operation::class);
        $operation = $operationRepository->findOneBy(['slug' => $slug ]);

        //Stat
        $stat = new StatUser();
        $stat
            ->setType('visite')
            ->setDate(new \DateTimeImmutable())
            ->setUser($user)
            ->setOperation($operation);
        $entityManager->persist($stat);
        $entityManager->flush();

        return $this->render('default/operation.html.twig', [
            'user' => $user,
            'ope' => $operation,
            'operations' => $operations
        ]);
    }
}
