<?php

namespace Spomky\IpFilterBundle\Model;

use Spomky\IpFilterBundle\Model\RangeRepositoryInterface;
use Doctrine\ORM\EntityManager;

class RangeManager implements RangeManagerInterface
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
        if(!$this->repository instanceof RangeRepositoryInterface) {
            throw new \Exception("The repository of class $class must implement Spomky\IpFilterBundle\Model\RangeRepositoryInterface");
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
    public function findByIp($ip) {
        return $this->getRepository()->findOneByIp($ip);
    }
}
