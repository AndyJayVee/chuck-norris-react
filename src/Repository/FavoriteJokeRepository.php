<?php

namespace App\Repository;

use App\Entity\FavoriteJoke;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;

/**
 * @method FavoriteJoke|null find($id, $lockMode = null, $lockVersion = null)
 * @method FavoriteJoke|null findOneBy(array $criteria, array $orderBy = null)
 * @method FavoriteJoke[]    findAll()
 * @method FavoriteJoke[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FavoriteJokeRepository extends ServiceEntityRepository
{
    /**
     * @var string
     */
    protected $entityClass = FavoriteJoke::class;

    /**
     * @var EntityManagerInterface
     */
    protected $entityManager;

    public function __construct(ManagerRegistry $registry)
    {
        $this->entityManager = $registry->getManager();
        parent::__construct($registry, $this->entityClass);
    }

    /**
     * @param FavoriteJoke $joke
     * @return void
     */
    public function save(FavoriteJoke $joke): void
    {
        $this->entityManager->persist($joke);
        $this->entityManager->flush();
    }

    /**
     * @param FavoriteJoke $joke
     * @return void
     */
    public function remove(FavoriteJoke $joke): void
    {
        $this->entityManager->remove($joke);
        $this->entityManager->flush();
    }

    /**
     * @param array $criteria
     * @return int|mixed
     * @throws NoResultException
     * @throws NonUniqueResultException
     */
    public function favoriteJokesAmount(array $criteria)
    {
        $query = $this->entityManager->createQueryBuilder('g')->select('count(g.joke_id)')
            ->from($this->entityClass, 'g');
        return $query
            ->getQuery()
            ->getSingleScalarResult();
    }
}
