<?php

namespace App\Controller\Admin;

use App\Entity\Operation;
use App\Entity\Marque;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\SlugField;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
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
            // ->add(EntityFilter::new('conference'))
            ;
    }

    public function configureFields(string $pageName): iterable
    {
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
            ->onlyOnForms();

        yield TextField::new('zipFile', 'Archive téléchargeable de l\'opération')
            ->setFormType(VichFileType::class)
            ->setFormTypeOptions([
                'required' => false,
                'allow_delete' => true,
                'delete_label' => 'supprimer le fichier',
                'download_label' => 'télécharger le fichier',
                'asset_helper' => true,
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
        yield DateField::new('date_debut');
        yield DateField::new('date_fin');
    }



}
