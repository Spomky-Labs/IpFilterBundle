<?php

namespace Spomky\IpFilterBundle\Model;

use Doctrine\ORM\EntityRepository;
use Spomky\IpFilterBundle\Model\RangeRepositoryInterface;


class RangeRepository extends EntityRepository implements RangeRepositoryInterface
{
    public function findOneByIp($ip, $environment){

        $result = $this->createQueryBuilder('r')
            ->select('r.start_ip, r.end_ip')
            ->where('CONV(r.start_ip,16,10) <= CONV(:ip,16,10)')
            ->andWhere('CONV(r.end_ip,16,10) >= CONV(:ip,16,10)')
            ->andWhere('r.environment = :environment OR r.environment is NULL')
            ->setParameter('ip', bin2hex(inet_pton($ip)))
            ->setParameter('environment', $environment)
            ->setMaxResults(1)
            ->getQuery()
            ->execute();
        return count($result)===1?$result[0]:null;
    }
}
