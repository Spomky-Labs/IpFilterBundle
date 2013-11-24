<?php

namespace Spomky\IpFilterBundle\Model;

use Doctrine\ORM\EntityRepository;
use Spomky\IpFilterBundle\Model\RangeRepositoryInterface;


class RangeRepository extends EntityRepository implements RangeRepositoryInterface
{
    public function findOneByIp($ip, $environment){

        return $this->createQueryBuilder('r')
            ->select('r.start_ip, r.end_ip')
            ->where('CONV(r.start_ip,16,10) <= CONV(:ip,16,10)')
            ->andWhere('CONV(r.end_ip,16,10) >= CONV(:ip,16,10)')
            ->andWhere('r.environment LIKE :environment OR r.environment is NULL')
            ->orderBy('r.authorized', 'DESC')
            ->setParameter('ip', bin2hex(inet_pton($ip)))
            ->setParameter('environment', '%'.$environment.'%')
            ->getQuery()
            ->execute();
    }
}
