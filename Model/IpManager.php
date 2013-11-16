<?php

namespace Spomky\IpFilterBundle\Model;

use Spomky\IpFilterBundle\Model\IpRepositoryInterface;
use Spomky\IpFilterBundle\Model\IpManagerInterface;
use Symfony\Bridge\Doctrine\RegistryInterface;

class IpManager implements IpManagerInterface
{
    /**
     * @var \Doctrine\Common\Persistence\ObjectManager
     */
    protected $manager;

    /**
     * @var \Doctrine\ORM\EntityRepository
     */
    protected $repository;

    public function __construct(RegistryInterface $registry, $class)
    {
        $this->manager = $registry->getManager();
        
        if (!in_array('Spomky\\IpFilterBundle\\Model\\IpInterface', class_implements($class)) ) {
            throw new \Exception("The Ip class $class must implement Spomky\IpFilterBundle\Model\IpInterface");
        }

        $this->repository = $this->getManager()->getRepository($class);
        if (!$this->repository instanceof IpRepositoryInterface) {
            throw new \Exception("The repository of class $class must implement Spomky\IpFilterBundle\Model\IpRepositoryInterface");
        }
    }

    /**
     * @return \Doctrine\Common\Persistence\ObjectManager
     */
    protected function getManager()
    {
        return $this->manager;
    }

    /**
     * {@inheritdoc}
     */
    protected function getRepository()
    {
        return $this->repository;
    }

    /**
     * {@inheritdoc}
     */
    public function findIp($ip, $environment)
    {
        return $this->getRepository()->findByIp($ip, $environment);
    }
}
