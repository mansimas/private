<?php

namespace Admin\MedicalBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Translatable\Entity\MappedSuperclass\AbstractPersonalTranslation;

/**
 * Companytranslation
 */
class Companytranslation extends AbstractPersonalTranslation
{   
    protected $object;    
}