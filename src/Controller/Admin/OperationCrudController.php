<?php

namespace App\Controller\Admin;

use App\Entity\Operation;
use App\Entity\Marque;
use App\Entity\Outil;
use App\Form\OutilType;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\Assets;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Dto\EntityDto;
use EasyCorp\Bundle\EasyAdminBundle\Event\AfterCrudActionEvent;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\HiddenField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\SlugField;
use EasyCorp\Bundle\EasyAdminBundle\Filter\EntityFilter;
use EasyCorp\Bundle\EasyAdminBundle\Form\Type\FileUploadType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichFileType;
use Vich\UploaderBundle\Form\Type\VichImageType;

class OperationCrudController extends AbstractCrudController
{
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }
    public static function getEntityFqcn(): string
    {
        return Operation::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Opération')
            ->setEntityLabelInPlural('Opérations')
            ->setSearchFields(['titre'])
            ->setDefaultSort(['updatedAt' => 'DESC'])
            ;
    }

    public function configureFilters(Filters $filters): Filters
    {
        return $filters
            ->add(EntityFilter::new('categorie'))
            ;
    }

    public function configureFields(string $pageName): iterable
    {
        yield IdField::new('id', 'ID')
            ->onlyOnIndex()
        ;
        yield ImageField::new('visuel', 'Visuel')
            ->setBasePath('/uploads/images/operations')
            ->onlyOnIndex()
        ;
        yield TextField::new('imageFile')
            ->setFormType(VichImageType::class)
            ->setFormTypeOptions([
                'allow_delete' => false,
                'required' => false,
                'download_uri' => false,
                'image_uri' => true,
                'asset_helper' => true,
                'label' => 'Visuel de l\'opération'
            ])
            ->setHelp('Fichier JPG')
            ->onlyOnForms()
        ;

        yield TextField::new('titre');
        yield SlugField::new('slug')
            ->setTargetFieldName('titre')
            ->onlyWhenCreating();

        yield BooleanField::new('alaune', 'Opération à la une')
            ->setHelp('Sera affiché "À la Une" sur la homepage');

        yield TextField::new('zipFile', 'Archive téléchargeable de l\'opération (ATTENTION : créer d\'abord l\'opération)')
            ->setFormType(VichFileType::class)
            ->setFormTypeOptions([
                'required' => false,
                'allow_delete' => true,
                'delete_label' => 'supprimer le fichier',
                'download_label' => 'télécharger le fichier',
                'asset_helper' => false
            ])
            ->onlyOnForms();

        yield TextEditorField::new('description')->onlyOnForms();
        yield AssociationField::new('categorie');
        yield AssociationField::new('marques')
            ->setFormTypeOptions([
                'class' => Marque::class,
                'choice_label' => 'nom',
                'placeholder' => 'Choose a marque',
                'multiple' => true,
                'expanded' => true
            ]);
        yield CollectionField::new('outils')
            ->useEntryCrudForm()
        ;
        yield DateField::new('date_debut')->setEmptyData('1970-01-01');
        yield DateField::new('date_fin')->setEmptyData('2100-01-01');
    }


    public function monActionPersonnalisee(Request $request): Response
    {
        $entity = new Outil();

        // Utilisez createEntityFormBuilder() pour obtenir le formulaire de création de l'entité imbriquée
        $form = $this->createEntityFormBuilder($entity, $request->getUri())->getForm();
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Utilisez persistEntity() pour enregistrer l'entité imbriquée dans la base de données
            $this->persistEntity($form->getData());

            // Redirigez ou effectuez d'autres actions après la sauvegarde réussie
            // ...

            return $this->redirectToRoute('admin');
        }

        // Rendez la vue du formulaire d'édition de l'entité imbriquée
        return $this->render('admin/votre_entite_imbriquee/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }




}


