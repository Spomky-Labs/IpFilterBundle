<?php

namespace Spomky\IpFilterBundle\Model;

use Doctrine\ORM\EntityRepository;
use Spomky\IpFilterBundle\Model\RangeRepositoryInterface;


class RangeRepository extends EntityRepository implements RangeRepositoryInterface
{
    public function findOneByIp($ip){

        $result = $this->createQueryBuilder('r')
            ->select('r.start_ip, r.end_ip')
            ->where('r.start_ip <= :ip')
            ->AndWhere('r.end_ip >= :ip')
            ->setParameter('ip', bin2hex(inet_pton($ip)))
            ->setMaxResults(1)
            ->getQuery()
            ->execute();
        return count($result)===1?$result[0]:null;
    }
}
