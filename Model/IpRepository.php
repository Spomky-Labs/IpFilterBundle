<?php

namespace Spomky\IpFilterBundle\Model;

use Doctrine\ORM\EntityRepository;
use Spomky\IpFilterBundle\Model\IpRepositoryInterface;


class IpRepository extends EntityRepository implements IpRepositoryInterface
{
    public function findOneByIp($ip, $environment){

        $result = $this->createQueryBuilder('r')
            ->select('r.ip')
            ->where('CONV(r.ip,16,10) = CONV(:ip,16,10)')
            ->andWhere('r.environment = :environment OR r.environment is NULL')
            ->setParameter('ip', bin2hex(inet_pton($ip)))
            ->setParameter('environment', $environment)
            ->setMaxResults(1)
            ->getQuery()
            ->execute();
        return count($result)===1?$result[0]:null;
    }
}
