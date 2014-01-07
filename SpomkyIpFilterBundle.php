<?php

namespace Spomky\IpFilterBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use Doctrine\DBAL\Types\Type;

class SpomkyIpFilterBundle extends Bundle
{
    public function boot()
    {
        $types = Type::getTypesMap();
        if(!isset($types['ipaddress'])) {
            Type::addType('ipaddress', 'Spomky\IpFilterBundle\Doctrine\Type\IpAddress');
    
            $em = $this->container->get('doctrine.orm.entity_manager');
            $em->getConnection()->getDatabasePlatform()->registerDoctrineTypeMapping('ipaddress', 'ipaddress');
        }
    }
}
