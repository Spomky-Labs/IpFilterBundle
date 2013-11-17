<?php

namespace Spomky\IpFilterBundle;

use Spomky\IpFilterBundle\DependencyInjection\SpomkyIpFilterExtension;
use Symfony\Component\HttpKernel\Bundle\Bundle;
use Doctrine\DBAL\Types\Type;

class SpomkyIpFilterBundle extends Bundle
{
    public function boot() {

        Type::addType('ipaddress', 'Spomky\IpFilterBundle\Doctrine\Type\IpAddress');
        $em = $this->container->get('doctrine.orm.default_entity_manager');
        $conn = $em->getConnection();
        $conn->getDatabasePlatform()->registerDoctrineTypeMapping('ipaddress', 'ipaddress');
    }
}
