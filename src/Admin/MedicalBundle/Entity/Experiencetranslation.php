<?php

namespace Admin\MedicalBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Translatable\Entity\MappedSuperclass\AbstractPersonalTranslation;
/**
 * Experiencetranslation
 */
class Experiencetranslation extends AbstractPersonalTranslation
{
    /**
     * @var integer
     */
    protected $object;   
}