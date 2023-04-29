<?php
namespace App\Naming;

use Vich\UploaderBundle\Mapping\PropertyMapping;
use Vich\UploaderBundle\Naming\DirectoryNamerInterface;

class CustomDirectoryNamer implements DirectoryNamerInterface
{
    public function directoryName($object, PropertyMapping $mapping): string
    {
        $now = new \DateTime();
        $id = $object->getId();
        return sprintf('%d/%s', $id, $now->format('Ymd'));
    }

}
