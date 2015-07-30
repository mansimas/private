<?php

namespace Admin\MedicalBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Translatable\Entity\MappedSuperclass\AbstractPersonalTranslation;

/**
 * Newstranslation
 */
class Newstranslation extends AbstractPersonalTranslation
{
    protected $object;
}