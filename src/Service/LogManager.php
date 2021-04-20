<?php


namespace App\Service;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Gedmo\Loggable\Entity\LogEntry;
use Gedmo\Tool\Wrapper\EntityWrapper;

class LogManager {

	/**
	 * @var EntityManager
	 */
	protected $entityManager;

	public function __construct(
		EntityManagerInterface $entityManager
	) {
		$this->entityManager = $entityManager;
	}

	public function getByField( $entity, $field ) {


		$wrapped     = new EntityWrapper( $entity, $this->entityManager );
		$objectClass = $wrapped->getMetadata()->name;
		$meta        = $this->entityManager->getClassMetadata( LogEntry::class );
		$dql         = "SELECT log FROM {$meta->name} log";
		$dql         .= " WHERE log.objectId = :objectId";
		$dql         .= " AND log.objectClass = :objectClass";
		$dql         .= " AND log.data LIKE :field";
//		$dql         .= " AND JSON_EXTRACT(o.jsonData, :jsonPath) = :value";
		$dql .= " ORDER BY log.version DESC";

		$objectId = (string) $wrapped->getIdentifier();
		$q        = $this->entityManager->createQuery( $dql );
		$q->setParameters( compact( 'objectId', 'objectClass' ) );
//		$q->setParameter( 'jsonPath', '$.test.key1' )
		$q->setParameter( 'field', '%"' . $field . '"%' );

		return $q;

	}
}