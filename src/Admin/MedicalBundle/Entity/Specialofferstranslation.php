<?php

namespace Admin\MedicalBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Translatable\Entity\MappedSuperclass\AbstractPersonalTranslation;

/**
 * Specialofferstranslation
 */
class Specialofferstranslation extends AbstractPersonalTranslation
{   
    protected $object;    
}