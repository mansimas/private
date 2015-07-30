<?php

namespace Admin\MedicalBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Translatable\Entity\MappedSuperclass\AbstractPersonalTranslation;

/**
 * Staticarticletranslation
 */
class Staticarticletranslation extends AbstractPersonalTranslation
{
    protected $object;
}