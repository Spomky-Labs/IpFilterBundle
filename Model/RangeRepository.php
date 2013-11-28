<?php

namespace Spomky\IpFilterBundle\Model;

use Doctrine\ORM\EntityRepository;
use Spomky\IpFilterBundle\Model\RangeRepositoryInterface;

class RangeRepository extends EntityRepository implements RangeRepositoryInterface
{
    public function findByIp($ip, $environment)
    {
        return $this->createQueryBuilder('r')
            ->where('r.start_ip <= :ip')
            ->andWhere('r.end_ip >= :ip')
            ->andWhere('r.environment LIKE :environment OR r.environment is NULL')
            ->orderBy('r.authorized', 'DESC')
            ->setParameter('ip', bin2hex(inet_pton($ip)))
            ->setParameter('environment', '%'.$environment.'%')
            ->getQuery()
            ->execute();
    }
}
