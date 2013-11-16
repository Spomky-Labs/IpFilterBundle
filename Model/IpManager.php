<?php

namespace Spomky\IpFilterBundle\Model;

use Doctrine\ORM\EntityManager;

class IpManager implements IpManagerInterface
{
    /**
     * @var \Doctrine\ORM\EntityManager
     */
    protected $em;

    /**
     * @var \Doctrine\ORM\EntityRepository
     */
    protected $repository;

    public function __construct(EntityManager $em, $class) {
        $this->em = $em;
        $this->repository = $em->getRepository($class);
    }

    /**
     * {@inheritdoc}
     */
    public function getRepository() {
        return $this->repository;
    }

    /**
     * {@inheritdoc}
     */
    public function findIp($ip) {
        return $this->getRepository()->findOneBy(array('ip'=>$ip));
    }
}