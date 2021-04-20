<?php

namespace App\Entity;

use App\Repository\ResolucionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity(repositoryClass=ResolucionRepository::class)
 * @Vich\Uploadable
 * @Gedmo\Loggable
 * @Assert\Callback(callback="validate")
 */
class Resolucion extends BaseClass
{
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
	private $numero;

	/**
	 * @ORM\Column(type="string", length=255)
	 * @Gedmo\Versioned
	 */
	private $anio;

	/**
	 * @ORM\Column(type="string", length=255, nullable=true)
	 * @Gedmo\Versioned
	 */
	private $descripcion;

	/**
	 * @ORM\Column(type="date")
	 * @Gedmo\Versioned
	 */
	private $fecha;

	/**
	 * @ORM\Column(type="boolean", nullable=true)
	 * @Gedmo\Versioned
	 */
	private $destacado;

	/**
	 * @ORM\Column(type="string", length=255, nullable=true)
	 * @var string
	 */
	private $archivo;

	/**
	 * @Vich\UploadableField(mapping="resoluciones", fileNameProperty="archivo")
	 * @var File
	 */
	private $resolucionFile;

	/**
	 * @ORM\ManyToMany(targetEntity=PalabraClave::class)
	 */
	private $palabrasClave;

	/**
	 * @ORM\Column(type="text", nullable=true)
	 * @Gedmo\Versioned
	 */
	private $texto;

	public function __construct() {
		$this->palabrasClave = new ArrayCollection();
	}

	/**
	 * @param ExecutionContextInterface $context
	 */
	public function validate( ExecutionContextInterface $context ) {
		if ( $this->resolucionFile && "" !== $this->resolucionFile->getMimeType() ) {
			if ( ! in_array( $this->resolucionFile->getMimeType(),
				[
					'image/jpeg',
					'image/jpg',
					'image/png',
					'application/pdf'
				] ) ) {
				$context
					->buildViolation( 'Solo se aceptan .jpg, .png, .jpeg, .pdf' )
					->atPath( 'fileName' )
					->addViolation();
			}
		}
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
	 * @return Resolucion
	 */
	public function setResolucionFile( File $file = null ) {
		$this->resolucionFile = $file;

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
	public function getResolucionFile() {
		return $this->resolucionFile;
	}

	public function __toString(): ?string {
		return $this->numero . ' - ' . $this->anio;
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
	public function setArchivo( ?string $archivo ): void {
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

	public function getTexto(): ?string {
		return $this->texto;
	}

	public function setTexto( ?string $texto ): self {
		$this->texto = $texto;

		return $this;
	}
}
