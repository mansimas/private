<?php

namespace Admin\MedicalBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Translatable\Entity\MappedSuperclass\AbstractPersonalTranslation;

/**
 * Testimonialtranslation
 */
class Testimonialtranslation extends AbstractPersonalTranslation
{
    protected $object;
}