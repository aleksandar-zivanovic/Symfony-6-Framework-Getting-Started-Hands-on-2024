<?php

namespace App\Repository;

use App\Entity\Location;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use PhpParser\Node\Expr\Cast\Bool_;

/**
 * @extends ServiceEntityRepository<Location>
 *
 * @method Location|null find($id, $lockMode = null, $lockVersion = null)
 * @method Location|null findOneBy(array $criteria, array $orderBy = null)
 * @method Location[]    findAll()
 * @method Location[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LocationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Location::class);
    }

    public function save(Location $location, bool $flush = false): void {
        $em = $this->getEntityManager();
        $em->persist($location);
        $flush ? $em->flush() : '';
    }

    public function remove(Location $location, bool $flush = null): void 
    {
        $em = $this->getEntityManager();
        $em->remove($location);
        $flush ? $em->flush() : null;
    }

    public function findOneByName($name): ?Location
    {
        $qb = $this->createQueryBuilder('l');
        $qb->where('l.name = :name')
            ->setParameter('name', $name)
            // ->andWhere('l.countryCode = :code')
            // ->setParameter('code', 'FR')
        ;
        $query = $qb->getQuery();
        $result = $query->getOneOrNullResult();

        return $result;
    }

    public function findAllWithForecasts(): array {
        $query = $this->createQueryBuilder('l')
            ->select('l', 'f')
            ->leftJoin('l.forecasts', 'f')
            ->getQuery();
        return $query->getResult();
    }

//    /**
//     * @return Location[] Returns an array of Location objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('l')
//            ->andWhere('l.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('l.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Location
//    {
//        return $this->createQueryBuilder('l')
//            ->andWhere('l.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
