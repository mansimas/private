<?php

namespace Admin\MedicalBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Translatable\Entity\MappedSuperclass\AbstractPersonalTranslation;
/**
 * Categorytranslation
 */
class Categorytranslation extends AbstractPersonalTranslation
{
   protected $object; 
}