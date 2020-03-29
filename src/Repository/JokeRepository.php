<?php


namespace App\Repository;


use App\Entity\Joke;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Joke|null find($id, $lockMode = null, $lockVersion = null)
 * @method Joke|null findOneBy(array $criteria, array $orderBy = null)
 * @method Joke[]    findAll()
 * @method Joke[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class JokeRepository extends ServiceEntityRepository
{
    /**
     * @var string
     */
    protected $entityClass = Joke::class;

    /**
     * @var EntityManagerInterface
     */
    protected $entityManager;
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, $this->entityClass);
    }
}