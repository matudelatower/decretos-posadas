<?php

namespace App\Entity;

use App\Repository\PalabraClaveRepository;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity(repositoryClass=PalabraClaveRepository::class)
 * @Gedmo\Loggable
 */
class PalabraClave extends BaseClass {
	/**
	 * @ORM\Id()
	 * @ORM\GeneratedValue()
	 * @ORM\Column(type="integer")
	 */
	private $id;

	/**
	 * @ORM\Column(type="string", length=255)
	 * @Gedmo\Versioned
	 */
	private $descripcion;

	public function getId(): ?int {
		return $this->id;
	}

	public function __toString(): string {
		return $this->descripcion;
	}

	public function getDescripcion(): ?string {
		return $this->descripcion;
	}

	public function setDescripcion( string $descripcion ): self {
		$this->descripcion = $descripcion;

		return $this;
	}
}
