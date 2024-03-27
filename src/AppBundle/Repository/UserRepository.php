<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query\ResultSetMapping;
use Doctrine\ORM\Query\ResultSetMappingBuilder;

class UserRepository extends EntityRepository
{
    public function getUsers()
    {

        $arrayUsers = [];
        $arrayUsers = $this->findAll();

        return $arrayUsers;
    }


    public function getUsersByQueryBuilder()
    {
        $strParam = "Cristhian";


        // select u.* from User As u  
        $objEM = $this->getEntityManager()->createQueryBuilder();

        $objQB = $this->createQueryBuilder('p')
            ->where('p.name = :name')
            ->setParameter('name', $strParam)
            ->getQuery()
            ->getResult();

        return $objQB;
    }

    public function getUsersByNativeQuery()
    {
        $objEM = $this->getEntityManager();
        $objRSM = new ResultSetMappingBuilder($objEM);

        // Configurar el mapeo de la entidad User
        $objRSM->addEntityResult('AppBundle\Entity\User', 'u');
        $objRSM->addFieldResult('u', 'id', 'id');

        $objRSM->addFieldResult('u', 'name', 'name');
        $objRSM->addFieldResult('u', 'username', 'username');
        $objRSM->addFieldResult('u', 'password', 'password');
        $objRSM->addFieldResult('u', 'status', 'status');
        $objRSM->addFieldResult('u', 'creatd_at', 'creatdAt');
        $objRSM->addFieldResult('u', 'updated_at', 'updatedAt');
        $objRSM->addFieldResult('u', 'age', 'age');
        


        $strSQL = " SELECT * FROM user";

        $objNQ = $objEM->createNativeQuery($strSQL, $objRSM);

        $arrayUsers = $objNQ->getResult();

        return $arrayUsers;
    }

    public function getUsersByDQL()
    {
        $objEM = $this->getEntityManager();

        $strSQL = " SELECT u FROM AppBundle:User u";

        $objDQL = $objEM->createQuery($strSQL);

        $arrayUsers = $objDQL->getResult();

        return $arrayUsers;
    }
}
