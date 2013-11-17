<?php

namespace Spomky\IpFilterBundle;

use Spomky\IpFilterBundle\DependencyInjection\SpomkyIpFilterExtension;
use Symfony\Component\HttpKernel\Bundle\Bundle;
use Doctrine\DBAL\Types\Type;

class SpomkyIpFilterBundle extends Bundle
{
    public function boot() {

        Type::addType('geometry', 'geoloc\HelloBundle\ORM\GeometryType');
        $em = $this->container->get('doctrine.orm.default_entity_manager');
        $conn = $em->getConnection();
        $conn->getDatabasePlatform()->registerDoctrineTypeMapping('geometry', 'geometry');
    }
}
