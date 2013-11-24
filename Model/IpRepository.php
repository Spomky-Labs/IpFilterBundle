<?php

namespace Spomky\IpFilterBundle\Model;

use Doctrine\ORM\EntityRepository;
use Spomky\IpFilterBundle\Model\IpRepositoryInterface;


class IpRepository extends EntityRepository implements IpRepositoryInterface
{
    public function findOneByIp($ip, $environment){

        return $this->createQueryBuilder('r')
            ->select('r.ip')
            ->where('CONV(r.ip,16,10) = CONV(:ip,16,10)')
            ->andWhere('r.environment LIKE :environment OR r.environment is NULL')
            ->orderBy('r.authorized', 'DESC')
            ->setParameter('ip', bin2hex(inet_pton($ip)))
            ->setParameter('environment', '%'.$environment.'%')
            ->getQuery()
            ->execute();
    }
}
