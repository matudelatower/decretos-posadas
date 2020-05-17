<?php

namespace App\Entity;

use App\Repository\DecretoRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @ORM\Entity(repositoryClass=DecretoRepository::class)
 * @Vich\Uploadable
 */
class Decreto extends BaseClass {
	/**
	 * @ORM\Id()
	 * @ORM\GeneratedValue()
	 * @ORM\Column(type="integer")
	 */
	private $id;

	/**
	 * @ORM\Column(type="string", length=255)
	 */
	private $numero;

	/**
	 * @ORM\Column(type="string", length=255)
	 */
	private $anio;

	/**
	 * @ORM\Column(type="string", length=255, nullable=true)
	 */
	private $descripcion;

	/**
	 * @ORM\Column(type="date")
	 */
	private $fecha;

	/**
	 * @ORM\Column(type="boolean", nullable=true)
	 */
	private $destacado;

	/**
	 * @ORM\Column(type="string", length=255, nullable=true)
	 * @var string
	 */
	private $archivo;

	/**
	 * @Vich\UploadableField(mapping="decretos", fileNameProperty="archivo")
	 * @var File
	 */
	private $decretoFile;

	/**
	 * @ORM\ManyToMany(targetEntity=PalabraClave::class)
	 */
	private $palabrasClave;

	public function __construct() {
		$this->palabrasClave = new ArrayCollection();
	}


	/**
	 * If manually uploading a file (i.e. not using Symfony Form) ensure an instance
	 * of 'UploadedFile' is injected into this setter to trigger the  update. If this
	 * bundle's configuration parameter 'inject_on_load' is set to 'true' this setter
	 * must be able to accept an instance of 'File' as the bundle will inject one here
	 * during Doctrine hydration.
	 *
	 * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile $image
	 *
	 * @return Decreto
	 */
	public function setDecretoFile( File $file = null ) {
		$this->decretoFile = $file;

		if ( $file ) {
			// It is required that at least one field changes if you are using doctrine
			// otherwise the event listeners won't be called and the file is lost
			$this->fechaActualizacion = new \DateTime( 'now' );
		}

		return $this;
	}

	/**
	 * @return File|null
	 */
	public function getDecretoFile() {
		return $this->decretoFile;
	}

	public function getId(): ?int {
		return $this->id;
	}

	public function getNumero(): ?string {
		return $this->numero;
	}

	public function setNumero( string $numero ): self {
		$this->numero = $numero;

		return $this;
	}

	public function getAnio(): ?string {
		return $this->anio;
	}

	public function setAnio( string $anio ): self {
		$this->anio = $anio;

		return $this;
	}

	public function getDescripcion(): ?string {
		return $this->descripcion;
	}

	public function setDescripcion( ?string $descripcion ): self {
		$this->descripcion = $descripcion;

		return $this;
	}

	public function getFecha(): ?\DateTimeInterface {
		return $this->fecha;
	}

	public function setFecha( \DateTimeInterface $fecha ): self {
		$this->fecha = $fecha;

		return $this;
	}

	public function getDestacado(): ?bool {
		return $this->destacado;
	}

	public function setDestacado( ?bool $destacado ): self {
		$this->destacado = $destacado;

		return $this;
	}

	/**
	 * @return string
	 */
	public function getArchivo(): ?string {
		return $this->archivo;
	}

	/**
	 * @param string $archivo
	 */
	public function setArchivo( string $archivo ): void {
		$this->archivo = $archivo;
	}

	/**
	 * @return Collection|PalabraClave[]
	 */
	public function getPalabrasClave(): Collection {
		return $this->palabrasClave;
	}

	public function addPalabrasClave( PalabraClave $palabrasClave ): self {
		if ( ! $this->palabrasClave->contains( $palabrasClave ) ) {
			$this->palabrasClave[] = $palabrasClave;
		}

		return $this;
	}

	public function removePalabrasClave( PalabraClave $palabrasClave ): self {
		if ( $this->palabrasClave->contains( $palabrasClave ) ) {
			$this->palabrasClave->removeElement( $palabrasClave );
		}

		return $this;
	}


}
