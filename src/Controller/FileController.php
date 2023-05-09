<?php
// src/Controller/FileController.php

namespace App\Controller;

use App\Entity\Operation;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;


class FileController extends AbstractController
{
    public function __construct(EntityManagerInterface $entityManager,SluggerInterface $slugger,)
    {
        $this->entityManager = $entityManager;
        $this->slugger = $slugger;
    }

    #[Route('/upload/{id}', name:'upload_zip', methods: ['POST'])]
    public function uploadFile(Request $request, int $id)
    {
       // var_dump($request->files);
        //dd($request->files);
        //die();

        $uploadedFile = $request->files->get('Operation')['zipFile']['file'];
        //var_dump($uploadedFile);
        if (!$uploadedFile instanceof UploadedFile) {
            throw new \Exception('No file uploaded');
        }


        try {
            $originalFilename = pathinfo($uploadedFile->getClientOriginalName(), PATHINFO_FILENAME);
            // this is needed to safely include the file name as part of the URL
            $safeFilename = $this->slugger->slug($originalFilename);
            $newFilename = $safeFilename.'-'.uniqid().'.'.$uploadedFile->guessExtension();

            $now = new \DateTimeImmutable();
            $date = $now->format('Ymd');
            $destination = 'uploads/files/'.$id.'/'.$date.'/';
            $size = $uploadedFile->getSize();
            $movedFile = $uploadedFile->move($destination, $newFilename);

            $operation = $this->entityManager->getRepository(Operation::class)->find($id);
            $operation->setZipFile($movedFile);
            $operation->setGlobalZip($newFilename);

            $this->entityManager->flush();

            //dd($operation);

            return new JsonResponse([
                'success' => true,
                'file' => [
                    'name' => $newFilename,
                    'size' => $size,
                    'url' => $destination.$newFilename // URL vers le fichier téléchargé
                ]
            ]);
        } catch (FileException $e) {
            //var_dump($e);
            return new JsonResponse([
                'error' => $e->getMessage()
            ]);
        }
    }
}
