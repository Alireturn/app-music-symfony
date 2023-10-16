<?php

namespace App\Controller\Admin;

use App\Entity\Music;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class MusicCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Music::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('Name'),
            ImageField::new('image')->setBasePath('uploads/')->setUploadDir('public/uploads')->setUploadedFileNamePattern('[randomhash].[extension]')->setRequired(false),
            TextField::new('singer'),
            AssociationField::new('category'),
            ImageField::new('sound')->setBasePath('uploads/music')->setUploadDir('public/uploads/music')->setUploadedFileNamePattern('[randomhash].[extension]')->setRequired(false)
        ];
    }
}