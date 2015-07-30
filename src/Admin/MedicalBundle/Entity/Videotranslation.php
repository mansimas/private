<?php

namespace Admin\MedicalBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Translatable\Entity\MappedSuperclass\AbstractPersonalTranslation;
/**
 * Videotranslation
 */
class Videotranslation extends AbstractPersonalTranslation
{
    protected $object;
}