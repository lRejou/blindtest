<?php

namespace App\Repository;

use App\Entity\Musiques;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Musiques|null find($id, $lockMode = null, $lockVersion = null)
 * @method Musiques|null findOneBy(array $criteria, array $orderBy = null)
 * @method Musiques[]    findAll()
 * @method Musiques[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MusiquesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Musiques::class);
    }

    public function findId($diff, $theme, $soustheme)
    {
        $conn = $this->getEntityManager()->getConnection();

        // [1, 1 , 0 , 0]
        $whereSQLDiff = "";
        $boucleWereDiff = 0;
        foreach ($diff as $key => $value){
            if($value == 1){
                if($boucleWereDiff != 0){
                    $whereSQLDiff = $whereSQLDiff . " or ";
                }
                $whereSQLDiff = $whereSQLDiff . 'difficulte = '.$key;
                $boucleWereDiff++;
            }
        }

        //theme
        $compteurTheme = 0;
        $whereSQLTheme = "";
        foreach($theme as $key => $value){
            if($compteurTheme != 0){
                $whereSQLTheme = $whereSQLTheme . " or ";
            }
            $whereSQLTheme = $whereSQLTheme . 'theme = "'.$value.'"';
            $compteurTheme++;
        }

        //soustheme
        $compteurSousTheme = 0;
        $whereSQLSousTheme = "";
        foreach($soustheme as $key => $value){
            if($compteurSousTheme != 0){
                $whereSQLSousTheme = $whereSQLSousTheme . " or ";
            }
            $whereSQLSousTheme = $whereSQLSousTheme . 'sous_cat = "'.$value.'"';
            $compteurSousTheme++;
        }


        //Ecriture SQL
        $sql='
        SELECT id
        FROM musiques
        WHERE ('.$whereSQLDiff.") AND (".$whereSQLTheme.') AND ('.$whereSQLSousTheme.')
        ORDER BY RAND()
        ';

        //var_dump($sql);


        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $videos = $stmt->fetchAll();
        return $videos;

    }


    // /**
    //  * @return Musiques[] Returns an array of Musiques objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('m.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Musiques
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
