<?php

namespace App\Controller\Admin;

use App\Entity\Outil;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Vich\UploaderBundle\Form\Type\VichImageType;

class OutilCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Outil::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Outil')
            ->setEntityLabelInPlural('Outils')
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
            ->setBasePath('/uploads/images/outils')
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
                'label' => 'Visuel de l\'outil'
            ])
            ->setHelp('Fichier JPG')
            ->onlyOnForms()
        ;

        yield TextField::new('titre');
        yield TextEditorField::new('description')->onlyOnForms();
        yield AssociationField::new('operation');

    }
}
