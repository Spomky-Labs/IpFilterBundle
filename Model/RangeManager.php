<?php

namespace SpomkyLabs\IpFilterBundle\Model;

use SpomkyLabs\IpFilterBundle\Tool\Network;
use Symfony\Bridge\Doctrine\RegistryInterface;

class RangeManager implements RangeManagerInterface
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
     * {@inheritdoc}
     */
    public function findByIpAddress($ip, $environment)
    {
        return $this->getEntityRepository()->createQueryBuilder('r')
            ->where('r.start_ip <= :ip')
            ->andWhere('r.end_ip >= :ip')
            ->andWhere("r.environment LIKE :environment OR r.environment='a:0:{}'")
            ->orderBy('r.authorized', 'DESC')
            ->setParameter('ip', $ip)
            ->setParameter('environment', "%$environment%")
            ->getQuery()
            ->execute();
    }

    public function createRangeFromNetwork($network)
    {
        $range = $this->createRange();
        $values = Network::getRange($network);
        $range->setStartIp($values['start']);
        $range->setEndIp($values['end']);

        return $range;
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
    public function createRange()
    {
        $class = $this->class;

        return new $class();
    }

    /**
     * {@inheritdoc}
     */
    public function saveRange(RangeInterface $range)
    {
        $this->getEntityManager()->persist($range);
        $this->getEntityManager()->flush();

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function deleteRange(RangeInterface $range)
    {
        $this->getEntityManager()->remove($range);
        $this->getEntityManager()->flush();

        return $this;
    }
}
