<?php
namespace App\Controller;

use App\Entity\Categorie;
use App\Entity\Operation;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;

class DefaultController extends AbstractController
{
    #[Route('/', name:'homepage')]
    public function index(EntityManagerInterface $entityManager): Response
    {
        // usually you'll want to make sure the user is authenticated first,
        // see "Authorization" below
        //$this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        // returns your User object, or null if the user is not authenticated
        // use inline documentation to tell your editor your exact User class
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


}
