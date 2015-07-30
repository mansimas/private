<?php

namespace Admin\MedicalBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Translatable\Entity\MappedSuperclass\AbstractPersonalTranslation;

/**
 * InsuranceTranslation
 */
class Insurancetranslation extends AbstractPersonalTranslation
{   
    protected $object;    
}