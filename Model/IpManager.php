<?php

/*
 * The MIT License (MIT)
 *
 * Copyright (c) 2014-2015 Spomky-Labs
 *
 * This software may be modified and distributed under the terms
 * of the MIT license.  See the LICENSE file for details.
 */

namespace SpomkyLabs\IpFilterBundle\Model;

use Symfony\Bridge\Doctrine\RegistryInterface;

class IpManager implements IpManagerInterface
{
    /**
     * @var \Doctrine\Common\Persistence\ObjectManager
     */
    protected $entity_manager;

    /**
     * @var string
     */
    protected $class;

    /**
     * @var \Doctrine\Common\Persistence\ObjectRepository
     */
    protected $entity_repository;

    public function __construct(RegistryInterface $registry, $class)
    {
        $this->class = $class;
        $this->entity_manager = $registry->getManagerForClass($class);
        $this->entity_repository = $this->entity_manager->getRepository($class);
    }

    /**
     * @return \Doctrine\Common\Persistence\ObjectManager
     */
    protected function getEntityManager()
    {
        return $this->entity_manager;
    }

    /**
     * {@inheritdoc}
     */
    protected function getEntityRepository()
    {
        return $this->entity_repository;
    }

    /**
     * {@inheritdoc}
     */
    public function findIpAddress($ip, $environment)
    {
        return $this->getEntityRepository()->createQueryBuilder('r')
            ->where('r.ip = :ip')
            ->andWhere("r.environment LIKE :environment OR r.environment='a:0:{}'")
            ->orderBy('r.authorized', 'DESC')
            ->setParameter('ip', $ip)
            ->setParameter('environment', "%$environment%")
            ->getQuery()
            ->execute();
    }

    /**
     * {@inheritdoc}
     */
    public function createIp()
    {
        $class = $this->class;

        return new $class();
    }

    /**
     * {@inheritdoc}
     */
    public function saveIp(IpInterface $ip)
    {
        $this->getEntityManager()->persist($ip);
        $this->getEntityManager()->flush();

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function deleteIp(IpInterface $ip)
    {
        $this->getEntityManager()->remove($ip);
        $this->getEntityManager()->flush();

        return $this;
    }
}
