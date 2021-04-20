<?php

namespace App\Repository;

use App\Entity\Resolucion;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Resolucion|null find($id, $lockMode = null, $lockVersion = null)
 * @method Resolucion|null findOneBy(array $criteria, array $orderBy = null)
 * @method Resolucion[]    findAll()
 * @method Resolucion[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ResolucionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Resolucion::class);
    }

    // /**
    //  * @return Resolucion[] Returns an array of Resolucion objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('r.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Resolucion
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

	public function buscarResoluciones( $data ) {
		$searchQuery = $data['s'];

		$qb = $this->createQueryBuilder( 'r' );

		if ( $searchQuery ) {

			$qb->add( 'where',
				$qb->expr()->orX(
					$qb->expr()->like( 'r.anio', $qb->expr()->literal( "%$searchQuery%" ) ),
					$qb->expr()->like( 'UPPER(r.descripcion)', $qb->expr()->literal( "%$searchQuery%" ) ),
					$qb->expr()->like( 'UPPER(r.texto)', $qb->expr()->literal( "%$searchQuery%" ) ),
					$qb->expr()->like( 'r.numero', $qb->expr()->literal( "%$searchQuery%" ) )
				) )
			;

			$qb->leftJoin( 'r.palabrasClave', 'palabrasClave' );

			$qb->orWhere( $qb->expr()->like( 'palabrasClave.descripcion', $qb->expr()->literal( "%$searchQuery%" )  ) );

		}

		$qb->andWhere('r.activo = true');

		return $qb;
	}
}
