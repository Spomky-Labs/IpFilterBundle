<?php

namespace Spomky\IpFilterBundle\Model;

use Symfony\Bridge\Doctrine\RegistryInterface;

class RangeManager implements RangeManagerInterface
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

        if (!in_array('Spomky\\IpFilterBundle\\Model\\RangeInterface', class_implements($class))) {
            throw new \Exception("The Range class $class must implement Spomky\IpFilterBundle\Model\RangeInterface");
        }

        $this->repository = $this->getManager()->getRepository($class);
        if (!$this->repository instanceof RangeRepositoryInterface) {
            throw new \Exception("The repository of class $class must implement Spomky\IpFilterBundle\Model\RangeRepositoryInterface");
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
    public function findByIp($ip, $environment)
    {
        return $this->getRepository()->findByIp($ip, $environment);
    }
}
