<?php

namespace App\Repository;

use App\Entity\Decreto;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Decreto|null find( $id, $lockMode = null, $lockVersion = null )
 * @method Decreto|null findOneBy( array $criteria, array $orderBy = null )
 * @method Decreto[]    findAll()
 * @method Decreto[]    findBy( array $criteria, array $orderBy = null, $limit = null, $offset = null )
 */
class DecretoRepository extends ServiceEntityRepository {
	public function __construct( ManagerRegistry $registry ) {
		parent::__construct( $registry, Decreto::class );
	}

	// /**
	//  * @return Decreto[] Returns an array of Decreto objects
	//  */
	/*
	public function findByExampleField($value)
	{
		return $this->createQueryBuilder('d')
			->andWhere('d.exampleField = :val')
			->setParameter('val', $value)
			->orderBy('d.id', 'ASC')
			->setMaxResults(10)
			->getQuery()
			->getResult()
		;
	}
	*/

	/*
	public function findOneBySomeField($value): ?Decreto
	{
		return $this->createQueryBuilder('d')
			->andWhere('d.exampleField = :val')
			->setParameter('val', $value)
			->getQuery()
			->getOneOrNullResult()
		;
	}
	*/

	public function buscarDecretos( $data ) {
		$searchQuery = $data['s'];

		$qb = $this->createQueryBuilder( 'd' );

		if ( $searchQuery ) {

			$qb->add( 'where',
				$qb->expr()->orX(
					$qb->expr()->like( 'd.anio', $qb->expr()->literal( "%$searchQuery%" ) ),
					$qb->expr()->like( 'UPPER(d.descripcion)', $qb->expr()->literal( "%$searchQuery%" ) ),
					$qb->expr()->like( 'd.numero', $qb->expr()->literal( "%$searchQuery%" ) )
				) )
			   ;

			$qb->leftJoin( 'd.palabrasClave', 'palabrasClave' );

			$qb->orWhere( $qb->expr()->like( 'palabrasClave.descripcion', $qb->expr()->literal( "%$searchQuery%" )  ) );

		}

		return $qb;
	}
}
