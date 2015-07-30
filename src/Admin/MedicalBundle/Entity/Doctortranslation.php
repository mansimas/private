<?php

namespace Admin\MedicalBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Translatable\Entity\MappedSuperclass\AbstractPersonalTranslation;
/**
 * Doctortranslation
 */
class Doctortranslation extends AbstractPersonalTranslation
{
    protected $object;
}