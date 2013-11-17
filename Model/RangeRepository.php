<?php

namespace Spomky\IpFilterBundle\Model;

use Doctrine\ORM\EntityRepository;
use Spomky\IpFilterBundle\Model\RangeRepositoryInterface;


class RangeRepository extends EntityRepository implements RangeRepositoryInterface
{
    public function findOneByIp($ip){

        $result = $this->createQueryBuilder('r')
            ->select('r.start_ip, r.end_ip')
            ->where('CONV(r.start_ip,16,10) <= CONV(:ip,16,10)')
            ->AndWhere('CONV(r.end_ip,16,10) >= CONV(:ip,16,10)')
            ->setParameter('ip', bin2hex(inet_pton($ip)))
            ->setMaxResults(1)
            ->getQuery()
            ->execute();
        return count($result)===1?$result[0]:null;
    }
}
