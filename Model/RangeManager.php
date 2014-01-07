<?php

namespace Spomky\IpFilterBundle\Model;

use Spomky\IpFilterBundle\Model\RangeRepositoryInterface;
use Spomky\IpFilterBundle\Model\RangeManagerInterface;
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

    public function __construct(EntityManager $em, $class)
    {
        $this->em = $em;
        
        if (!in_array('Spomky\\IpFilterBundle\\Model\\RangeInterface', class_implements($class)) ) {
            throw new \Exception("The Range class $class must implement Spomky\IpFilterBundle\Model\RangeInterface");
        }
        
        $this->repository = $em->getRepository($class);
        if (!$this->repository instanceof RangeRepositoryInterface) {
            throw new \Exception("The repository of class $class must implement Spomky\IpFilterBundle\Model\RangeRepositoryInterface");
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getRepository()
    {
        return $this->repository;
    }

    /**
     * {@inheritdoc}
     */
    public function findByIp($ip, $environment)
    {
        return $this->getRepository()->findByIp($ip, $environment);
    }
}
