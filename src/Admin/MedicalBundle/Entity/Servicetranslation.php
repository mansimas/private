<?php

namespace Admin\MedicalBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Translatable\Entity\MappedSuperclass\AbstractPersonalTranslation;

/**
 * @ORM\Entity
 * @ORM\Table(name="servicetranslation",
 *     uniqueConstraints={@ORM\UniqueConstraint(name="lookup_unique_idx", columns={
 *         "locale", "object_id", "field"
 *     })}
 * )
 */
class Servicetranslation extends AbstractPersonalTranslation
{   
	/**
	 * Convinient constructor
	 *
	 * @param string $locale
	 * @param string $field
	 * @param string $value
	 */
	public function __construct($locale, $field, $value)
	{
		$this->setLocale($locale);
		$this->setField($field);
		$this->setContent($value);
	}
	/**
	 * @ORM\ManyToOne(targetEntity="Service", inversedBy="translations")
	 * @ORM\JoinColumn(name="object_id", referencedColumnName="id", onDelete="CASCADE")
	 */
	protected $object;
}
