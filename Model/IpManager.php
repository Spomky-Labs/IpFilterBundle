<?php

namespace Spomky\IpFilterBundle\Model;

use Spomky\IpFilterBundle\Model\IpRepositoryInterface;
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
        if(!$this->repository instanceof IpRepositoryInterface) {
            throw new \Exception("The repository of class $class must implement Spomky\IpFilterBundle\Model\IpRepositoryInterface");
        }
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
        return $this->getRepository()->findOneByIp($ip);
    }
}
